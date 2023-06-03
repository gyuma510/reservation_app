@extends('layouts.app')
@section('title', 'お問合せ一覧')
@section('content')
<div class = "text-center"><br>
    <h3>お問合せ一覧</h3><br>
</div>
<table class = "table table-sm table-hover">
    <thead>
        <tr class = "text-center bg-light">
            <th>名前</th>
            <th>メールアドレス</th>
            <th>お問合せ内容</th>
            <th>投稿日</th>
            <th>ステータス</th>
            <th>詳細</th>
        </tr>
    </thead>
    @foreach ($contacts as $contact)
        <tbody>
            <tr class = "text-center table-cell">
                <td class = "align-middle">{{ $contact->name }}</td>
                <td class = "align-middle">{{ $contact->email }}</td>
                <td class = "align-middle">
                        @if (mb_strlen($contact->content) > 8)
                            {{ mb_substr($contact->content, 0, 8) }}
                        @else
                            {{ $contact->content }}
                        @endif
                </td>
                <td class = "align-middle">{{ date('Y/m/d  H:m', strtotime($contact->created_at)) }}</td>
                @if ($contact->status)
                    <form action = "{{ route('contacts.status', $contact->id) }}" method = "post">
                        @csrf
                        @method('DELETE')
                        <td class = "align-middle"><input type = "submit" value = "対応済み" class = "btn btn-success" onclick="return confirm('未対応に変更しますか？')"></td>
                    </form>
                @else
                    <form action = "{{ route('contacts.status', $contact->id) }}" method = "post">
                        @csrf
                        <td class = "align-middle"><input type = "submit" value = "未対応" class = "btn btn-outline-success" onclick="return confirm('対応済みに変更しますか？')"></td>
                    </form>
                @endif
                <td class = "align-middle"><a class = "btn btn btn-outline-primary" href = "{{ route('admin.contacts.show', $contact->id) }}">詳細</a></td>
            </tr>
        </tbody>
    @endforeach
</table>
<div class = "text-center">
    {{ $contacts->links() }}
</div>
@endsection
