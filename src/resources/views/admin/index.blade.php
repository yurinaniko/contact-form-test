@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')

<h2 class="admin-title">Admin</h2>
<div class="admin-area">
    <div class="search-area">
        <form action="{{ route('admin.search') }}" method="GET" class="search-form">
            <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください">
            <select name="gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <select name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->content }}</option>
                @endforeach
            </select>
            <input type="date" name="date">
                <button type="submit" class="search-btn">検索</button>
                    @if ($contacts->isEmpty())
                        <tr>
                            <td colspan="5">検索結果がありません</td>
                        </tr>
                    @endif
                <button type="reset" class="reset-btn">リセット</button>
        </form>
        <div class="export-pagination">
            <a href="{{ route('admin.export') }}" class="export-btn">エクスポート</a>
            <div class="pagination">
            {{ $contacts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th>お名前</th>
            <th>性別</th>
            <th>メールアドレス</th>
            <th>お問い合わせの種類</th>
            <th>詳細</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($contacts as $contact)
        <tr>
            <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
            <td>
                @if ($contact->gender == 1)
                    男性
                @elseif ($contact->gender == 2)
                    女性
                @else
                    その他
                @endif
            </td>

            <td>{{ $contact->email }}</td>
            <td>{{ $contact->category->content }}</td>
            <td>
                <label for="modal-{{ $contact->id }}" class="detail-btn">詳細</label>
                    <input type="checkbox" id="modal-{{ $contact->id }}" class="modal-toggle" hidden>
                        <div class="modal-overlay">
                            <div class="modal-content">
                                <label for="modal-{{ $contact->id }}" class="close">&times;</label>
                                <h3>お問い合わせ詳細</h3>
                                <p>お名前：{{ $contact->last_name }} {{ $contact->first_name }}</p>
                                <p>性別：
                                    @if ($contact->gender == 1) 男性
                                    @elseif ($contact->gender == 2) 女性
                                    @else その他
                                    @endif
                                </p>
                                <p>メール：{{ $contact->email }}</p>
                                <p>電話番号：{{ $contact->tell }}</p>
                                <p>住所：{{ $contact->address }}</p>
                                <p>建物名：{{ $contact->building }}</p>
                                <p>種類：{{ $contact->category->content }}</p>
                                <p>内容：{{ $contact->detail }}</p>
                                <form action="{{ route('admin.destroy', $contact->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="delete-btn">削除</button>
                                </form>
                            </div>
                        </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection