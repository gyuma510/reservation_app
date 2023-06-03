@extends('layouts.parent')
@section('title', '宿泊プラン詳細')
@section('content')
    <div class="container my-5">
        <div class="card mb-3">
            <div id="plan-carousel" class="carousel slide" data-ride="carousel">
                @if ($plan->images->isEmpty())
                    <img src="{{ asset('images/nopicture.png') }}" width="100" alt="No Picture">
                @else
                    @foreach($plan->images as $image)
                        <img src="{{ Storage::url($image->path) }}" width="100">
                    @endforeach
                @endif
            </div>
            <div class="card-body">
                <h2 class="card-title">{{ $plan->title }}</h2>
                <p class="card-text">{{ $plan->description }}</p>
                <p class="card-text">{{ $plan->min_price }}円~{{ $plan->max_price }}円</p>
                <p class="card-text">{{ $plan->start_date }}~{{ $plan->end_date }}</p>
                <a href="{{ route('availability.calendar', $plan->id) }}" class="btn btn-primary">空室カレンダーを見る</a>
            </div>
        </div>
    </div>
@endsection
