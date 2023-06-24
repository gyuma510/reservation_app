@extends('layouts.parent')
@section('title', 'TOP')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="carouselExample" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/hotel_img1.jpeg') }}" class="d-block w-100" alt="Image 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/hotel_img2.jpeg') }}" class="d-block w-100" alt="Image 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/hotel_img3.jpeg') }}" class="d-block w-100" alt="Image 3">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="card bg-light">
                <div class="card-header text-center">
                    <h2 class="m-0">Welcome to our Reservation Site</h2>
                </div>
                <div class="card-body text-center">
                    <p class="lead">宿泊プランを予約して素敵な旅行に</p>
                    <p class="lead">まずは<a href="/reservations">宿泊プランを探す</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#carouselExample').carousel();
    });
</script>
@endpush
