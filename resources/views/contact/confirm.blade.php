<x-guest-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg my-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">お問い合わせ内容の確認</h2>

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
            @csrf

            <table class="w-full border-collapse">
                <tr class="border-b">
                    <th class="text-left py-2 w-1/3">お名前</th>
                    <td>{{ $contact['first_name'] }} {{ $contact['last_name'] }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">性別</th>
                    <td>{{ $contact['gender'] == 1 ? '男性' : ($contact['gender'] == 2 ? '女性' : 'その他') }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">メール</th>
                    <td>{{ $contact['email'] }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">電話番号</th>
                    <td>{{ $contact['tel'] }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">住所</th>
                    <td>{{ $contact['address'] }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">建物名</th>
                    <td>{{ $contact['building'] ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">種類</th>
                    <td>{{ $category->content ?? '' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left py-2">内容</th>
                    <td>{!! nl2br(e($contact['detail'])) !!}</td>
                </tr>
            </table>

            <!-- hiddenで送信データを保持 -->
            @foreach($contact as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <div class="flex justify-center space-x-4 pt-4">
                <button type="submit" name="back" value="1" class="bg-gray-400 text-white px-6 py-2 rounded-md hover:bg-gray-500">修正</button>
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-700">送信</button>
            </div>
        </form>
    </div>
</x-guest-layout>