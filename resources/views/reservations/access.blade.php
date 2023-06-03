@extends('layouts.parent')

@section('title', 'アクセス')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">アクセス案内</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>所在地</h2>
            <p>〒130-0021 東京都墨田区緑３丁目１−１４ 外山ハイツ 502</p>

            <h2>電話番号</h2>
            <p>03-6659-3529</p>

            <h2>アクセス</h2>
            <p>最寄り駅から徒歩約10分の場所にあります。</p>
            <p>お車でお越しの方は、近隣に駐車場がございます。</p>
            <p>詳細なルートや交通手段については、お気軽にお問い合わせください。</p>
        </div>

        <div class="col-md-6">
            <h2>地図</h2>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.359773004589!2d139.80268417637575!3d35.69276327258349!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018892f89315f1d%3A0x8eb58cdb3a6fdf5e!2z5qCq5byP5Lya56S-44G_44KT44Gq44K344K544OG44Og44K6!5e0!3m2!1sja!2sjp!4v1685346408379!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
