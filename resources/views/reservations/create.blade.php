@extends('layouts.parent')

@section('title', '予約作成')

@section('content')
    <div class="container my-5">
        <h1>{{ $plan->title }}</h1>
        <h2>{{ $plan->description }}</h2>
        <form method="POST" action="{{ route('reservations.confirm') }}">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="frame_id" value="{{ $frame->id }}">
            <div class="mb-3">
                <label for="start_date" class="form-label">開始日<span class="badge badge-danger ml-1">必須</span></label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', request('date', $frame->date) ) }}" readonly>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">終了日<span class="badge badge-danger ml-1">必須</span></label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">姓<span class="badge badge-danger ml-1">必須</span></label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" 
                        placeholder="山田" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">名<span class="badge badge-danger ml-1">必須</span></label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
                        placeholder="太郎" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス<span class="badge badge-danger ml-1">必須</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="admin@example.com" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">住所<span class="badge badge-danger ml-1">必須</span></label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                    placeholder="東京都墨田区緑３丁目１−１４ 外山ハイツ 502" value="{{ old('address') }}" required>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">電話番号<span class="badge badge-danger ml-1">必須</span></label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                    placeholder="03-6659-3529(ハイフンなしでも可/半角数字)" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">メッセージ</label>
                <textarea class="form-control" id="message" name="message"
                placeholder="(任意)当日は車で伺います。など" rows="3">{{ old('message') }}</textarea>
            </div>
            <div class="d-grid gap-2 text-center">
                <button class="btn btn-primary" type="submit">予約内容確認へ</button>
            </div>
        </form>        
    </div>
@endsection
