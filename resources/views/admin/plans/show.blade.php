@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h3>{{ $plan->title }}</h3>
    <div class="row">
        <div class="col-md-4">
            @if ($plan->images->isEmpty())
                <img src="{{ asset('images/nopicture.png') }}" width="100" alt="No Picture">
            @else
                @foreach($plan->images as $image)
                    <img src="{{ Storage::url($image->path) }}" width="100">
                @endforeach
            @endif
        </div>
        <div class="col-md-8 mt-3">
            <p>{{ $plan->description }}</p>
            <p>値段: {{$plan->min_price}}円~{{$plan->max_price}}円</p>
            <p>期間: {{$plan->start_date}}~{{$plan->end_date}}</p>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>日付</th>
                        <th>予約枠ごとの値段</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plan->frames as $frame)
                        <tr>
                            <td>{{ $frame->date }}</td>
                            <td>{{ $frame->pivot->price }} 円</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('plans.index') }}" class="btn btn-secondary">{{ __('宿泊プラン一覧へ戻る') }}</a>
        </div>
    </div>
</div>
@endsection