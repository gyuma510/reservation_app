<form method="POST" action="{{ route('managements.store_memo', $reservation->id) }}">
    @csrf
    <label for="memo">メモ</label>
    <textarea name="memo" class="form-control">{{ old('memo') }}</textarea>
        @error('memo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </textarea>
    <input type="submit" value="送信" class="btn btn-primary">
</form>
