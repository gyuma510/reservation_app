@extends('layouts.app')

@section('title', 'メールアドレス変更')

@section('content')
<div class="container">
    <div class="text-center mt-4">
        <h3>メールアドレス変更</h3>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <form method="POST" action="{{ route('email.update') }}">
                @csrf

                <div class="mb-3">
                    <label for="current_email" class="form-label">現在のメールアドレス</label>
                    <input type="email" class="form-control @error('current_email') is-invalid @enderror" id="current_email" name="current_email" value="{{ old('current_email') }}" required>
                    @error('current_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_email" class="form-label">新しいメールアドレス</label>
                    <input type="email" class="form-control @error('new_email') is-invalid @enderror" id="new_email" name="new_email" value="{{ old('new_email') }}" required>
                    @error('new_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_email_confirmation" class="form-label">新しいメールアドレス（確認）</label>
                    <input type="email" class="form-control @error('new_email_confirmation') is-invalid @enderror" id="new_email_confirmation" name="new_email_confirmation" value="{{ old('new_email_confirmation') }}" required>
                    @error('new_email_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">メールアドレス変更</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">ダッシュボードへ戻る</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
