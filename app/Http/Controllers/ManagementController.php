<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frame;
use App\Models\Plan;
use App\Models\FramePlan;
use App\Models\Reservation;
use App\Mail\Cancelmail;
use Carbon\Carbon;

class ManagementController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Reservation::from('reservations')->simplePaginate(10);

        $now = \Carbon\Carbon::now();

        // 日付ショートカット検索の定義
        $shortcut = [
            '今日' => $now->format('Y-m-d'),
            '明日' => $now->addDay()->format('Y-m-d'),
            '明後日' => $now->addDay()->format('Y-m-d'),
        ];

        // キーワードを取得
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $start_date_shortcut = $request->input('start_date_shortcut');


        // 日付ショートカット検索が選択された場合、開始日時を上書きする
        if (!empty($start_date_shortcut)) {
            $start_date = $start_date_shortcut;
        } elseif (!empty($request->input('start_date_input'))) {
            $start_date = $request->input('start_date_input');
        }

        // 検索クエリを作成する
        $query = Reservation::query();
        if (!empty($start_date)) {
            $query->where('start_date', '=', $start_date);
        }
        if (!empty($end_date)) {
            $query->where('end_date', '=', $end_date);
        }

        // クエリを実行し、結果を取得する
        $reservations = $query->paginate(10);

        return view('admin.managements.index', [
            'reservations' => $reservations,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_date_shortcut' => $start_date_shortcut,
            'date_shortcut' => $shortcut,
        ]);

        // return view('admin.managements.index', compact('reservations'));
    }

    public function show(string $id)
    {
        $reservation = Reservation::find($id);

        return view('admin.managements.show', compact('reservation'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->cancel = true;
        $reservation->save();

        // 宿泊予約キャンセルメール
        \Mail::to($reservation->email)->send(new Cancelmail($reservation));

        // 予約枠解放
        $framePlan = $reservation->framePlan;
        $framePlan->frame->number += 1;
        $framePlan->frame->save();

        return redirect()->route('managements.index')->with('flash_delete', '宿泊予約をキャンセルしました');
    }

    public function createMemo($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('admin.managements.create_memo', compact('reservation'));
    }

    public function storeMemo(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->memo = $request->get('memo');
        $reservation->save();

        return redirect()->route('managements.index')->with('flash_message', 'メモを作成しました');
    }
}
