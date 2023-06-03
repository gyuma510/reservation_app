@extends('layouts.parent')

@section('title', '予約作成')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="container my-5">
        <h1>{{ $plan->title }}</h1>
        <h2>{{ $plan->description }}</h2>
        <form method="POST" action="{{ route('reservations.confirm') }}">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="frame_id" value="{{ $frame->id }}">
            <div class="mb-3">
                <label for="start_date" class="form-label">開始日</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', request('date', $frame->date) ) }}" readonly>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">終了日</label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">氏名</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">住所</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">電話番号</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">メッセージ</label>
                <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">予約する</button>
            </div>
        </form>        
    </div>
@endsection