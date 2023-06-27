<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Plan;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    public function calendar(int $id): View
    {
        $plan = Plan::findOrFail($id);
        $rooms = Room::whereIn('id', $plan->frames->pluck('room_id'))->get();
        return view('availability.calendar', ['plan' => $plan, 'rooms' => $rooms]);
    }

    public function calendarData(Request $request): JsonResponse
    {
        $plan_id = $request->input('plan_id');
        $plan = Plan::find($plan_id);
        $room_type_id = $request->input('room_type_id');
    
        $events = [];
    
        // 予約枠を1つずつイベントに変換する
        foreach ($plan->frames as $frame) {
            // 今日以前の予約枠はスキップする
            if (strtotime($frame->date) < strtotime('today')) {
                continue;
            }
    
            $rooms = $frame->room()->where('id', $room_type_id)->get();
            foreach ($rooms as $room) {
                $event = [
                    'title' => '',
                    'date' => $frame->date,
                    'color' => '',
                ];
                $price = $frame->pivot->price;
                $reservationCount = $frame->number;
    
                if ($reservationCount === 0) {
                    $event['title'] = '×' . $price . '円';
                    $event['color'] = 'black';
                } elseif ($reservationCount === 1) {
                    $event['title'] = '△' . $price . '円';
                    $event['color'] = 'red';
                } elseif ($reservationCount < 4) {
                    $event['title'] = '△' . $price . '円';
                    $event['color'] = 'yellow';
                    $event['textColor'] = 'gray';
                } else {
                    $event['title'] = '◯' . $price . '円';
                    $event['color'] = 'green';
                }
                $events[] = $event;
            }
        }
    
        return response()->json($events);
    }
    
}
