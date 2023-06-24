@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <a href="{{ route('reservations.top') }}" class="text-dark">
                        <i class="fas fa-users"></i>
                        顧客用サイトトップへ
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h4 class="text-center mb-4">{{ \Carbon\Carbon::now()->format('Y年m月d日 (D)') }}の業務</h4>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3"><i class="fas fa-bed"></i> 本日の宿泊予約情報</h5>
                            <div class="text-center">
                                <a href="{{ route('managements.index') }}" class="btn btn-dark btn-sm">
                                    今すぐ確認
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3"><i class="fas fa-comments"></i> 未対応のお問合せ</h5>
                            <div class="text-center">
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-dark btn-sm">
                                    今すぐ確認
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
