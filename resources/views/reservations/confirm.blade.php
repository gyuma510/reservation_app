@extends('layouts.parent')
@section('title', '予約内容確認')
@section('content')
    <div class="container my-5">
        <h1 class="text-center">予約内容確認</h1>
        <p class="text-center">以下の内容で予約を確定しますか？</p>
        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="frame_id" value="{{ $frame->id }}">
            <div class="mb-3">
                <label for="start_date" class="form-label">開始日</label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                    name="start_date" value="{{ $data['start_date'] }}" readonly>
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">終了日</label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                    name="end_date" value="{{ $data['end_date'] }}" readonly>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">姓</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
                        value="{{ $data['first_name'] }}" readonly>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">名</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
                        value="{{ $data['last_name'] }}" readonly>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ $data['email'] }}" readonly>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">住所</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                    name="address" value="{{ $data['address'] }}" readonly>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">電話番号</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    name="phone" value="{{ $data['phone'] }}" readonly>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">メッセージ</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                    readonly>{{ $data['message'] }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="plan" class="form-label">宿泊プラン</label>
                <input type="text" class="form-control @error('plan') is-invalid @enderror" id="plan"
                    value="{{ $plan->title }}" readonly>
                @error('plan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="totalPrice" class="form-label">合計金額</label>
                <input type="text" class="form-control @error('totalPrice') is-invalid @enderror" id="totalPrice"
                    value="{{ $totalPrice }}円" readonly>
                @error('totalPrice')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" onclick="return confirm('予約を確定しますか？')">予約を確定する</button>
                <button type="button" class="btn btn-secondary" onclick="history.back()">戻る</button>
            </div>
        </form>
    </div>
@endsection
