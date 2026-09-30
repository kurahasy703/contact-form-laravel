<x-guest-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Admin Dashboard</h2>
        <div class="flex gap-2">
            <!-- CSVエクスポートボタン (現在の検索パラメータをそのまま引き継ぐ) -->
            <a href="{{ route('admin.export', request()->query()) }}" class="text-sm bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 flex items-center gap-1">
                エクスポート
            </a>
            <a href="{{ route('admin.tags.index') }}" class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700">タグ管理</a>
        </div>
    </div>

    <!-- 検索フォーム -->
    <form action="{{ route('admin.index') }}" method="GET" class="grid grid-cols-5 gap-2 mb-6">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前・メール・内容" class="border p-2 rounded">
        <select name="gender" class="border p-2 rounded">
            <option value="0">性別（全て）</option>
            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
        </select>
        <select name="category_id" class="border p-2 rounded">
            <option value="">カテゴリ（全て）</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->content }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}" class="border p-2 rounded">
        <button type="submit" class="bg-gray-800 text-white p-2 rounded hover:bg-gray-700">検索</button>
    </form>

    <!-- 一覧表示 -->
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-3">お名前</th>
                <th class="p-3">性別</th>
                <th class="p-3">メール</th>
                <th class="p-3">カテゴリ</th>
                <th class="p-3">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $contact->first_name }} {{ $contact->last_name }}</td>
                <td class="p-3">{{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}</td>
                <td class="p-3">{{ $contact->email }}</td>
                <td class="p-3">{{ $contact->category->content ?? '-' }}</td>
                <td class="p-3">
                    <form action="{{ route('admin.destroy', $contact) }}" method="POST" onsubmit="return confirm('削除しますか？')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
    </div>
</x-guest-layout>