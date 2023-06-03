@extends('layouts.parent')
@section('title', 'お問合せ')
@section('content')
<div class="container">
    <div class="text-center mt-3">
        <h3>お問合せフォーム</h3>
    </div>
    <form action="{{ route('contacts.store') }}" method="post" class="mt-3">
        @csrf
        <div class="mb-3 text-center">
            <label class="form-label">名前</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 text-center">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 text-center">
            <label class="form-label">お問合せ内容</label>
            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="text-center">
            <input type="submit" value="送信" class="btn btn-primary">
        </div>
    </form>
</div>
@endsection
