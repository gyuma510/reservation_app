<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FrameController\StoreRequest;
use App\Http\Requests\FrameController\UpdateRequest;
use App\Models\Frame;
use App\Models\Room;
use Carbon\Carbon;

class FrameController extends Controller
{
    public function index()
    {
        $frames = Frame::all();

        return view('admin.frames.index', compact('frames'));
    }

    public function create()
    {
        $rooms = Room::all();

        return view('admin.frames.create', compact('rooms'));
    }

    public function store(StoreRequest $request)
    {
        $frame = new Frame();
        $frame->room_id = $request->room_id;
        $frame->date = $request->date;
        $frame->number = $request->number;
        $frame->save();
    
        return redirect()->route('frames.index')->with('flashmessage', '予約枠を登録しました');
    }

    public function createBulk()
    {
        $rooms = Room::all();
        return view('admin.frames.create-bulk', compact('rooms'));
    }

    public function storeBulk(Request $request)
    {
        $room_id = $request->input('room_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $number = $request->input('number');
    
        $dates = [];
        $current_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);
    
        while ($current_date <= $end_date) {
            $dates[] = $current_date->format('Y-m-d');
            $current_date->addDay();
        }
    
        $frames = [];
        foreach ($dates as $date) {
            $frames[] = [
                'room_id' => $room_id,
                'date' => $date,
                'number' => $number,
            ];
        }
    
        Frame::insert($frames);
    
        return redirect()->route('frames.index')->with('success', '予約枠が一括作成されました');
    }
    

    public function edit(string $id)
    {
        $rooms = Room::all();
        $frame = Frame::find($id);

        return view('admin.frames.edit', compact('rooms', 'frame'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $frame = Frame::find($id);
        $frame->room_id = $request->room_id;
        $frame->date = $request->date;
        $frame->number = $request->number;
        $frame->save();

        return redirect()->route('frames.index')->with('flash_message', '予約枠を編集しました');
    }

    public function destroy(string $id)
    {
        $frame = Frame::find($id);
        $frame->delete();

        return redirect()->route('frames.index')->with('flash_delete', '予約枠を削除しました');
    }
}
