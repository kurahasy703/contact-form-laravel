<x-guest-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg my-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">お問い合わせ</h2>

        <form action="{{ route('contact.confirm') }}" method="POST" class="space-y-4">
            @csrf

            <!-- お名前 -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">姓 <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">名 <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                    @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 性別 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">性別 <span class="text-red-500">*</span></label>
                <div class="mt-2 space-x-4">
                    <label><input type="radio" name="gender" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }}> 男性</label>
                    <label><input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}> 女性</label>
                    <label><input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}> その他</label>
                </div>
                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- メールアドレス -->
            <div>
                <label class="block text-sm font-medium text-gray-700">メールアドレス <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 電話番号 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">電話番号 (ハイフンなし) <span class="text-red-500">*</span></label>
                <input type="text" name="tel" value="{{ old('tel') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                @error('tel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 住所 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">住所 <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="{{ old('address') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 建物名 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">建物名</label>
                <input type="text" name="building" value="{{ old('building') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
            </div>

            <!-- お問い合わせの種類 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">お問い合わせの種類 <span class="text-red-500">*</span></label>
                <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                    <option value="">選択してください</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                    </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 内容 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">お問い合わせ内容 <span class="text-red-500">*</span></label>
                <textarea name="detail" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">{{ old('detail') }}</textarea>
                @error('detail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="text-center pt-4">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-700">確認画面へ</button>
            </div>
        </form>
    </div>
</x-guest-layout>