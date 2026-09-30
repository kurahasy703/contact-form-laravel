<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportContactRequest;
use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    // お問い合わせ入力画面
    public function index()
    {
        $categories = Category::all();

        return view('contact.index', compact('categories'));
    }

    // 確認画面表示（入力値のバリデーション実行）
    public function confirm(StoreContactRequest $request)
    {
        $contact = $request->validated();
        $category = Category::find($contact['category_id']);

        return view('contact.confirm', compact('contact', 'category'));
    }

    // お問い合わせ送信処理（DB保存とPRGパターン）
    public function store(StoreContactRequest $request)
    {
        // 修正ボタンが押された場合
        if ($request->has('back')) {
            return redirect()->route('contact.index')->withInput();
        }

        $validated = $request->validated();

        // 姓と名を結合して保存する場合の処理、または個別に保存
        Contact::create($validated);

        return redirect()->route('contact.thanks');
    }

    // サンクス画面表示
    public function thanks()
    {
        return view('contact.thanks');
    }

    /**
     * お問い合わせデータのCSVエクスポート
     */
    public function export(ExportContactRequest $request)
    {
        $query = Contact::with('category');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('gender') && $request->gender != 0) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->latest()->get();

        return response()->streamDownload(function () use ($contacts) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOMを追加（Excel文字化け対策）
            fwrite($handle, "\xEF\xBB\xBF");

            // ヘッダー行を出力
            fputcsv($handle, ['ID', '氏名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', '詳細', '作成日時']);

            foreach ($contacts as $contact) {
                $genderText = match ($contact->gender) {
                    1 => '男性',
                    2 => '女性',
                    3 => 'その他',
                    default => '',
                };

                fputcsv($handle, [
                    $contact->id,
                    $contact->first_name.' '.$contact->last_name,
                    $genderText,
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building ?? '',
                    $contact->category->content ?? '',
                    $contact->detail,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 'contacts_'.now()->format('Ymd_His').'.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
