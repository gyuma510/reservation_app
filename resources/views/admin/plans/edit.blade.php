@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h3 class="mt-5 text-center">宿泊プラン編集</h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('plans.update', $plan->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('タイトル') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', $plan->title) }}" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('詳細') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                        name="description" required autocomplete="description">{{ old('description', $plan->description) }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="images"
                                    class="col-md-4 col-form-label text-md-right">{{ __('画像') }}</label>

                                <div class="col-md-6">
                                    <input id="images" type="file"
                                        class="form-control-file @error('images.*') is-invalid @enderror" name="images[]"
                                        multiple>

                                    @error('images.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="images"
                                    class="col-md-4 col-form-label text-md-right">{{ __('画像') }}</label>

                                <div class="col-md-6">
                                    <input id="images" type="file"
                                        class="form-control-file @error('images.*') is-invalid @enderror" name="images[]"
                                        multiple>

                                    @error('images.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="images"
                                    class="col-md-4 col-form-label text-md-right">{{ __('画像') }}</label>

                                <div class="col-md-6">
                                    <input id="images" type="file"
                                        class="form-control-file @error('images.*') is-invalid @enderror" name="images[]"
                                        multiple>

                                    @error('images.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="min_price"
                                    class="col-md-4 col-form-label text-md-right">{{ __('プランの最小の値段') }}</label>

                                <div class="col-md-6">
                                    <input id="min_price" type="number"
                                        class="form-control @error('min_price') is-invalid @enderror"
                                        name="min_price" value="{{ old('min_price', $plan->min_price) }}"
                                        required autocomplete="min_price">

                                    @error('min_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="max_price"
                                    class="col-md-4 col-form-label text-md-right">{{ __('プランの最大の値段') }}</label>

                                <div class="col-md-6">
                                    <input id="max_price" type="number"
                                        class="form-control @error('max_price') is-invalid @enderror"
                                        name="max_price" value="{{ old('max_price', $plan->max_price) }}"
                                        required autocomplete="max_price">

                                    @error('max_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="start_date">{{ __('開始日') }}</label>
                                <input id="start_date" type="date"
                                    class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                    value="{{ old('start_date', $plan->start_date) }}" autocomplete="start_date">
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="end_date">{{ __('終了日') }}</label>
                                <input id="end_date" type="date"
                                    class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                    value="{{ old('end_date', $plan->end_date) }}" autocomplete="end_date">
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @foreach ($frames as $frame)
                                <div class="form-group row">
                                    <label for="frame_price_{{ $frame->id }}"
                                        class="col-md-4 col-form-label text-md-right">{{ __('予約枠ごとの値段') }}
                                        {{ $frame->date }}</label>

                                    <div class="col-md-6">
                                        <input id="frame_price_{{ $frame->id }}" type="number"
                                            class="form-control @error('frame_prices.' . $frame->id) is-invalid @enderror"
                                            name="frame_prices[{{ $frame->id }}]"
                                            value="{{ old('frame_prices.' . $frame->id) }}" required
                                            autocomplete="frame_prices.{{ $frame->id }}">

                                        @error('frame_prices.' . $frame->id)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <a href="{{ route('plans.index') }}" class="btn btn-secondary">{{ __('宿泊プラン一覧へ戻る') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
