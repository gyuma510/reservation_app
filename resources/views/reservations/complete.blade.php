@extends('layouts.parent')
@section('title', '予約完了')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="text-center">予約完了</h2>
                </div>
                <div class="card-body">
                    <h5 class="card-title">予約が完了しました</h5>
                    <p class="card-text">
                        宿泊予約が正常に完了しました。<br>
                        フォームに入力されたメールアドレスに予約確定メールを送信しました。<br>
                        メールを確認してください。
                    </p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('reservations.top') }}" class="btn btn-primary">トップに戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
