@extends('layouts.app')
@section('title', '予約枠一括作成')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h1>予約枠一括作成</h1>
                <form method="POST" action="{{ route('frames.storeBulk') }}">
                    @csrf
                    <div class="form-group">
                        <label for="room_id">部屋名</label>
                        <select id="room_id" name="room_id" class="form-control">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_date">開始日</label>
                        <input id="start_date" name="start_date" class="form-control" type="date">
                        @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_date">終了日</label>
                        <input id="end_date" name="end_date" class="form-control" type="date">
                        @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="number">予約枠の数</label>
                        <input id="number" type="number" max="10"
                            class="form-control @error('number') is-invalid @enderror" name="number"
                            value="{{ old('number') }}" required autocomplete="number" autofocus>
                        @error('number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary">一括作成</button>　
                        <a href="{{ route('frames.index') }}" class="btn btn-secondary">{{ __('予約枠一覧へ戻る') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
