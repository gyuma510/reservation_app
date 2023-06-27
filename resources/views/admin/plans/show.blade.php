@extends('layouts.app')
<style>
    #imageCarousel .carousel-item img {
        height: 300px;
        object-fit: cover;
    }
</style>
@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">{{ $plan->title }}</h3>
        <div class="row">
            <div class="col-md-6">
                @if ($plan->images->isEmpty())
                    <img src="{{ asset('images/nopicture.png') }}" width="100%" alt="No Picture">
                @else
                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($plan->images as $index => $image)
                                <div class="carousel-item @if($index === 0) active @endif">
                                    <img src="{{ Storage::url($image->path) }}" class="img-fluid mb-3">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <p>{{ $plan->description }}</p>
                <p>値段: {{$plan->min_price}}円~{{$plan->max_price}}円</p>
                <p>期間: {{ date('Y年m月d日', strtotime($plan->start_date)) }} ~ {{ date('Y年m月d日', strtotime($plan->end_date)) }}</p>
                
                <button class="btn btn-outline-success mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#framePriceCollapse" aria-expanded="false" aria-controls="framePriceCollapse">
                    予約枠ごとの価格を見る
                </button>

                <div class="collapse mt-3" id="framePriceCollapse">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>日付</th>
                                <th>予約枠ごとの値段</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plan->frames as $frame)
                                <tr>
                                    <td>{{ $frame->date }}</td>
                                    <td>{{ $frame->pivot->price }} 円</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('plans.index') }}" class="btn btn-secondary">宿泊プラン一覧へ戻る</a>
        </div>
    </div>
@endsection
