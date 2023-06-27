@extends('layouts.app')
@section('title', '宿泊予約一覧')
@section('content')
    <div class = "text-center"><br>
        <h3>宿泊予約一覧</h3><br>
    </div>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card px-3">
                        <div class="card-body">
                            <form class="form-inline mb-3" method="GET" action="{{ route('managements.index') }}">
                                <div class="form-group">
                                    <label for="start_date_input" class="mr-2">{{ __('開始日時') }}</label>
                                    <input id="start_date_input" type="date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        name="start_date_input" value="{{ $start_date ?? '' }}" autocomplete="start_date">
                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="end_date" class="mr-2">{{ __('終了日時') }}</label>
                                    <input id="end_date" type="date"
                                        class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                        value="{{ $end_date ?? '' }}" autocomplete="end_date">
                                    @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="start_date_shortcut" class="mr-2">{{ __('日付ショートカット検索') }}</label>
                                    <select id="start_date_shortcut" class="form-control" name="start_date_shortcut">
                                        <option value=""></option>
                                        @foreach ($date_shortcut as $key => $value)
                                            <option value="{{ $value }}"
                                                @if ($value == $start_date_shortcut) selected @endif>
                                                {{ $key }}({{ $value }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary ml-2">{{ __('検索') }}</button>
                                    <a href="{{ route('managements.index') }}" class="btn btn-primary">検索リセット</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive p-5">
            <table class = "table table-sm table-hover">
                <thead>
                    <tr class = "text-center bg-light">
                        <th class="text-nowrap">名前</th>
                        <th class="text-nowrap">メールアドレス</th>
                        <th class="text-nowrap">電話番号</th>
                        <th class="text-nowrap">住所</th>
                        <th class="text-nowrap">メッセージ</th>
                        <th class="text-nowrap">宿泊プラン</th>
                        <th class="text-nowrap">宿泊開始日</th>
                        <th class="text-nowrap">宿泊終了日</th>
                        <th class="text-nowrap">予約日</th>
                        <th class="text-nowrap">管理者メモ</th>
                        <th class="text-nowrap">ステータス</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                @foreach ($reservations as $reservation)
                    <tbody>
                        <tr class = "text-center table-cell">
                            <td class = "text-nowrap align-middle" style="width: 100px;">{{ $reservation->first_name }}{{ $reservation->last_name }}</td>
                            <td class = "text-nowrap align-middle" style="width: 150px;">{{ $reservation->email }}</td>
                            <td class = "text-nowrap align-middle" style="width: 150px;">{{ $reservation->phone }}</td>
                            <td class = "text-nowrap align-middle" style="width: 300px;">{{ $reservation->address }}</td>
                            <td class = "text-nowrap align-middle" style="width: 300px;">{{ $reservation->message }}</td>
                            <td class = "text-nowrap align-middle" style="width: 100px;">{{ $reservation->framePlan->plan->title ?? '' }}</td>
                            <td class = "text-nowrap align-middle" style="width: 100px;">{{ date('Y/m/d', strtotime($reservation->start_date)) }}</td>
                            <td class = "text-nowrap align-middle" style="width: 100px;">{{ date('Y/m/d', strtotime($reservation->end_date)) }}</td>
                            <td class = "text-nowrap align-middle" style="width: 100px;">{{ date('Y/m/d  H:m', strtotime($reservation->created_at)) }}</td>
                            <td class = "text-nowrap align-middle" style="width: 300px;">{{ $reservation->memo }}</td>
                            @if ($reservation->cancel == 1)
                                <td class="text-nowrap align-middle text-danger" style="width: 100px;">キャンセル済み</td>
                            @else
                                <td class="text-nowrap align-middle text-success" style="width: 100px;">予約済み</td>
                            @endif
                            <td class="text-nowrap align-middle" style="width: 100px;">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#memoModal{{ $reservation->id }}">メモ作成</button>
                            </td>

                            <!-- 予約ごとのモーダル -->
                            <div class="modal fade" id="memoModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="memoModalLabel{{ $reservation->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="memoModalLabel{{ $reservation->id }}">作成</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('managements.store_memo', $reservation->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <textarea name="memo" class="form-control" rows="5">{{ old('memo', $reservation->memo) }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">保存</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <td class = "text-nowrap align-middle"><a class = "btn btn btn-outline-primary" href = "{{ route('managements.show', $reservation->id) }}">詳細</a></td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
            <div class = "text-center">
                {{ $reservations->links() }}
            </div>
        </div>
@endsection
