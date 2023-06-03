<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Room;
use App\Models\Plan;
use App\Models\FramePlan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    public function create($plan_id, $frame_id)
    {
        $plan = Plan::find($plan_id);
        $frame = Frame::find($frame_id);

        return view('reservations.create', compact('plan', 'frame'));
    }

    public function confirm(Request $request): View|RedirectResponse
    {        
        $plan = Plan::findOrFail($data['plan_id']);
        $frame = Frame::findOrFail($data['frame_id']);
    
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
    
        $frames = Frame::where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
    
        // 登録されていない日付または予約不可のフレームが含まれている場合はエラーを生成
        if ($frames->contains('count', 0)) {
            return redirect()->back()->withErrors(['message' => '予約不可能な日にちが含まれています。'])->withInput();
        }
    
        $totalPrice = Frame::where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->join('frame_plans', 'frames.id', '=', 'frame_plans.frame_id')
            ->sum('frame_plans.price');
    
        return view('reservations.confirm', [
            'plan' => $plan,
            'frame' => $frame,
            'data' => $data,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();
    
        $plan = Plan::findOrFail($data['plan_id']);
        $frame = Frame::findOrFail($data['frame_id']);
        $frames = Frame::where('date', '>=', $request->input('start_date'))
            ->where('date', '<=', $request->input('end_date'))
            ->get();
            
            foreach ($frames as $frame) {
                if ($frame->count === 0) {
                    return redirect()->route('reservations.create', ['plan' => $plan, 'frame' => $frame])->withErrors(['message' => 'Selected frame is fully booked.'])->withInput();
                }
            }

            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
        
            $frames = Frame::where('date', '>=', $startDate)
                ->where('date', '<=', $endDate)
                ->get();
        
            if ($frames->isEmpty() || $frames->contains('count', 0)) {
                return redirect()->back()->withErrors(['message' => '予約不可能な日にちが含まれています。'])->withInput();
            }
    
        $reservation = new Reservation();
        $reservation->name = $data['name'];
        $reservation->email = $data['email'];
        $reservation->address = $data['address'];
        $reservation->phone = $data['phone'];
        $reservation->message = $data['message'];
        $reservation->start_date = $data['start_date'];
        $reservation->end_date = $data['end_date'];
        $reservation->frame_plan_id = $frame->framePlan->first()->id;
        $reservation->save();
    
        foreach ($frames as $frame) {
            $frame->count -= 1;
            $frame->save();
        }

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
