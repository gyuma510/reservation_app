@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="my-5">宿泊プラン一覧</h3>
        <a class="btn btn-primary mb-3" href="{{ route('plans.create') }}">宿泊プラン作成</a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>タイトル</th>
                        <th>値段</th>
                        <th>期間</th>
                        <th>写真</th>
                        <th>詳細</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr style="max-height: 100px; overflow: hidden;">
                            <td>{{ $plan->id }}</td>
                            <td>{{ $plan->title }}</td>
                            <td>{{ $plan->min_price }}~{{ $plan->max_price }}</td>
                            <td>{{ $plan->start_date }}~{{ $plan->end_date }}</td>
                            <td>
                                @if ($plan->images->isEmpty())
                                    <img src="{{ asset('images/nopicture.png') }}" width="100" alt="No Picture">
                                @else
                                    @foreach($plan->images as $image)
                                        <img src="{{ Storage::url($image->path) }}" width="100">
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('plans.show', $plan->id) }}">詳細</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('plans.edit', $plan->id) }}">編集</a>
                            </td>
                            <td>
                                <form style="display: inline-block" action="{{ route('plans.destroy', $plan->id) }}"
                                    method="post" onsubmit="return confirm('本当にキャンセルしますか？')">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
