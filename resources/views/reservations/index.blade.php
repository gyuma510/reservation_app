@extends('layouts.parent')

@section('title', '宿泊プラン一覧')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h3>宿泊プラン一覧</h3>
            </div>

            <form class="mb-3" method="GET" action="{{ route('reservations.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword">{{ __('キーワード') }}</label>
                            <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword"
                                placeholder="プラン名/プラン説明" value="{{ $keyword }}" autocomplete="keyword">
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
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center bg-light">
                            <h5 class="card-title">{{ $plan->title }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <p class="card-text">--プラン内容--<br>{{ $plan->description }}</p>
                                    <p class="card-text">--料金--<br>{{ $plan->min_price }}円 ~ {{ $plan->max_price }}円</p>
                                    <p class="card-text">--期間--<br>{{ date('Y年m月d日', strtotime($plan->start_date)) }} ~ {{ date('Y年m月d日', strtotime($plan->end_date)) }}</p>
                                    <a href="{{ route('reservations.show', $plan->id) }}" class="btn btn-outline-secondary btn-block">{{ __('詳細を見る') }}</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="carouselExampleIndicators{{$plan->id}}" class="carousel slide" data-ride="carousel">
                                    @if($plan->images->isEmpty())
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="{{ asset('images/nopicture.png') }}" class="d-block w-50" alt="No Picture">
                                            </div>
                                        </div>
                                    @else
                                        <ol class="carousel-indicators">
                                            @foreach($plan->images as $key => $image)
                                                <li data-target="#carouselExampleIndicators{{$plan->id}}" data-slide-to="{{$key}}" class="{{$loop->first ? 'active' : ''}}"></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach($plan->images as $image)
                                                <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                    <img src="{{ Storage::url($image->path) }}" class="d-block w-50">
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators{{$plan->id}}" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators{{$plan->id}}" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
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
