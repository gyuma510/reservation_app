@extends('layouts.parent')

@section('title', '宿泊プラン一覧')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h1 class="display-4">宿泊プラン一覧</h1>
            </div>

            <form class="mb-3" method="GET" action="{{ route('reservations.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword">{{ __('キーワード') }}</label>
                            <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword"
                                value="{{ $keyword }}" autocomplete="keyword">
                            @error('keyword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">{{ __('開始日時') }}</label>
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                value="{{ $start_date ?? '' }}" autocomplete="start_date">
                            @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">{{ __('終了日時') }}</label>
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                value="{{ $end_date ?? '' }}" autocomplete="end_date">
                            @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('検索') }}</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">{{ __('検索リセット') }}</a>
                </div>
            </form>

            <div class="row">
                @foreach ($plans as $plan)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        @if ($plan->images->isEmpty())
                            <img src="{{ asset('images/nopicture.png') }}" width="100" alt="No Picture">
                        @else
                            @foreach($plan->images as $image)
                                <img src="{{ Storage::url($image->path) }}" width="100">
                            @endforeach
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->title }}</h5>
                            <p class="card-text">{{ $plan->description }}</p>
                            <p class="card-text">{{ $plan->min_price }}円 ~ {{ $plan->max_price }}円</p>
                            <p class="card-text">{{ $plan->start_date }} ~ {{ $plan->end_date }}</p>
                            <a href="{{ route('reservations.show', $plan->id) }}" class="btn btn-primary btn-block">{{ __('詳細を見る') }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $plans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
