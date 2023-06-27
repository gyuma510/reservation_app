<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationController\StoreRequest;
use App\Mail\ReservationSendmail;
use App\Models\Frame;
use App\Models\FramePlan;
use App\Models\Plan;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $now = \Carbon\Carbon::now();

        $keyword = $request->input('keyword');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Plan::query();
        if (!empty($start_date)) {
            $query->where('start_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $query->where('end_date', '<=', $end_date);
        }
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // クエリを実行し、結果を取得する
        $plans = $query->paginate(10);

        return view('reservations.index', [
            'plans' => $plans,
            'keyword' => $keyword,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

    }

    public function create(Request $request, $plan_id, $room_id)
    {
        $plan = Plan::find($plan_id);
        $frame = Frame::where('room_id', $room_id)->where('date', $request->date)->first();
        $data = [
            'plan_id' => $plan_id,
            'frame_id' => $frame->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'message' => $request->message,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        return view('reservations.create', compact('plan', 'frame', 'data'));
    }

    public function confirm(StoreRequest $request)
    {
        $data = $request->all();
        $plan = Plan::findOrFail($data['plan_id']);
        $frame = Frame::findOrFail($data['frame_id']);
        $framePlan = $frame->plans()->where('plan_id', $plan->id)->first();
        $framePlanId = $framePlan ? $framePlan->id : null;
    
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
    
        // 各日付チェック
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $frameExists = Frame::where('date', $date->toDateString())
                ->where('room_id', $frame->room_id)
                ->first();
    
            if (!$frameExists) {
                return back()->with('flash_delete', '予約不可能な日にちが含まれています。再度予約をしてください。');
            }
        }
    
        // 存在しない日付に書き換えた際のエラー
        if ($framePlanId === null) {
            return  back()->with('flash_delete', '予約不可能な日にちが含まれています。再度予約をしてください。');
        }
    
        $pricePerDay = $frame->plans()->where('plan_id', $plan->id)->value('price');
        $totalDays = $endDate->diffInDays($startDate);
        $totalPrice = $pricePerDay * $totalDays;
    
        return view('reservations.confirm', [
            'plan' => $plan,
            'frame' => $frame,
            'data' => $data,
            'totalPrice' => $totalPrice,
            'frame_plan_id' => $framePlanId,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $plan = Plan::findOrFail($data['plan_id']);
        $frame = Frame::findOrFail($data['frame_id']);
        $frames = Frame::where('date', '>=', $request->input('start_date'))
            ->where('date', '<=', $request->input('end_date'))
            ->get();
            
        foreach ($frames as $frame) {
            if ($frame->number === 0) {
                return redirect()->route('reservations.create', ['plan' => $plan, 'frame' => $frame])->withErrors(['message' => 'Selected frame is fully booked.'])->withInput();
            }
        }

        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        $selectedFrame = Frame::where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->first();

        $framePlanId = $selectedFrame->plans()->where('plan_id', $plan->id)->pluck('frame_plans.id')->first();

        // 存在しない日付に書き換えた際のエラー
        if ($framePlanId === null) {
            return redirect()->route('reservations.top')->with('flash_delete', '予約不可能な日にちが含まれているため、再度予約をしてください。');
        }

        $reservation = new Reservation();
        $reservation->first_name = $data['first_name'];
        $reservation->last_name = $data['last_name'];
        $reservation->email = $data['email'];
        $reservation->address = $data['address'];
        $reservation->phone = $data['phone'];
        $reservation->message = $data['message'];
        $reservation->start_date = $data['start_date'];
        $reservation->end_date = $data['end_date'];
        $reservation->frame_plan_id = $framePlanId;
        $reservation->save();

        $selectedFrame->number -= 1;
        $selectedFrame->save();

        // 重複予約対策
        $request->session()->regenerateToken();

        // 予約完了メール
        \Mail::to($request->email)->send(new ReservationSendmail($reservation));
        \Mail::to('yumagoto287@gmail.com')->send(new ReservationSendmail($reservation));

        return redirect()->route('reservations.complete');
    }

    public function complete()
    {
        return view('reservations.complete');
    }

    public function show(string $id)
    {
        $plan = Plan::find($id);
        return view('reservations.show', compact('plan'));
    }

    public function top()
    {
        return view('reservations.top');
    }

    public function access()
    {
        return view('reservations.access');
    }

    public function room()
    {
        $rooms = Room::all();

        return view('reservations.room', compact('rooms'));
    }
}
