@extends('layouts.parent')
@section('title', '宿泊プラン詳細')
@section('content')
<div class="container my-5">
    <div class="row">
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
                            <a href="{{ route('availability.calendar', $plan->id) }}" class="btn btn-outline-primary btn-block">空室カレンダーを見る</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleIndicators{{$plan->id}}" class="carousel slide" data-ride="carousel">
                            @if($plan->images->isEmpty())
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/nopicture.png') }}" class="d-block w-100" alt="No Picture">
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
                                            <img src="{{ Storage::url($image->path) }}" class="d-block w-100">
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
    </div>
</div>
@endsection
