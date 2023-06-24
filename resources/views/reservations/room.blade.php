@extends('layouts.parent')

@section('title', '客室一覧')

@section('content')
<div class="container my-5">
    <h3 class="text-center mb-5">客室一覧</h3>

    <div class="card-deck">
        @foreach ($rooms as $room)
        <div class="card">
            <img src="{{ asset($room->path) }}" alt="{{ $room->room_name }}" class="card-img-top">

            <div class="card-body">
                <h5  class="card-title">{{ $room->room_name }}</h5>
                <p class="card-text">{{ $room->description }}</p>
                <p class="card-text">定員：{{ $room->capacity }}名</p>
                <p class="card-text">備品・設備：{{ $room->facility }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
