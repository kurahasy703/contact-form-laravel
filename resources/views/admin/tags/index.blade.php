<x-guest-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg my-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">タグ管理</h2>
            <a href="{{ route('admin.index') }}" class="text-sm text-gray-600 hover:underline">← 管理画面へ戻る</a>
        </div>

        <!-- タグ作成フォーム -->
        <form action="{{ route('admin.tags.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="name" placeholder="新しいタグ名" class="border p-2 rounded flex-1">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">追加</button>
        </form>
        @error('name') <p class="text-red-500 text-xs mb-4">{{ $message }}</p> @enderror

        <!-- タグ一覧 -->
        <ul class="divide-y">
            @foreach($tags as $tag)
            <li class="py-2 flex justify-between items-center">
                <span>{{ $tag->name }}</span>
                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('削除しますか？')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 text-sm hover:underline">削除</button>
                </form>
            </li>
            @endforeach
        </ul>
    </div>
</x-guest-layout>