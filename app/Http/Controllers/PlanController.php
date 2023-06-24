<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlanController\StoreRequest;
use App\Http\Requests\PlanController\UpdateRequest;
use App\Models\Plan;
use App\Models\Image;
use App\Models\Frame;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        $frames = Frame::orderBy('date')->get();

        return view('admin.plans.create', compact('frames'));
    }

    public function store(StoreRequest $request)
    {
        $plan = new Plan();
        $plan->title = $request->title;
        $plan->description = $request->description;
        $plan->min_price = $request->min_price;
        $plan->max_price = $request->max_price;
        $plan->start_date = $request->start_date;
        $plan->end_date = $request->end_date;
        $plan->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $plan->images()->create(['path' => $path]);
            }
        }

        $framePrices = $request->input('frame_prices');
        foreach ($framePrices as $frameId => $price) {
            $frame = Frame::findOrFail($frameId);
            $plan->frames()->attach($frame->id, ['price' => $price]);
        }

        return redirect()->route('admin.plans.index')->with('flash_message', '宿泊プランを登録しました');
    }

    public function show(string $id)
    {
        $plan = Plan::with(['frames' => function ($query) {
            $query->orderBy('date');
        }])->find($id);
    
        return view('admin.plans.show', compact('plan'));
    }    

    public function edit(string $id)
    {
        $plan = Plan::find($id);
        $frames = Frame::with('plans')->orderBy('date')->get();
    
        return view('admin.plans.edit', compact('plan', 'frames'));
    }    

    public function update(UpdateRequest $request, string $id)
    {
        $plan = Plan::find($id);
        $plan->title = $request->title;
        $plan->description = $request->description;
        $plan->min_price = $request->min_price;
        $plan->max_price = $request->max_price;
        $plan->start_date = $request->start_date;
        $plan->end_date = $request->end_date;
        $plan->save();

        if ($request->hasFile('images')) {
            $plan->images()->delete();
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $plan->images()->create(['path' => $path]);
            }
        }

        $framePrices = $request->input('frame_prices');
        foreach ($framePrices as $frameId => $price) {
            $frame = Frame::findOrFail($frameId);
            $plan->frames()->syncWithoutDetaching([$frame->id => ['price' => $price]]);
        }

        return redirect()->route('admin.plans.index')->with('flash_message', '宿泊プランを編集しました');
    }

    public function destroy(string $id)
    {
        $plan = Plan::find($id);

        // 画像の削除処理
        foreach ($plan->images as $image) {
            Storage::delete($image->path);
            $image->delete();
        }
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('flash_delete', '宿泊プランを削除しました');
    }
}
