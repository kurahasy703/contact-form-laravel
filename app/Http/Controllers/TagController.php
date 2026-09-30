<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return view('admin.tags.index', compact('tags'));
    }

    public function store(StoreTagRequest $request)
    {
        Tag::create($request->validated());

        return redirect()->back()->with('success', 'タグを作成しました');
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return redirect()->back()->with('success', 'タグを更新しました');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->back()->with('success', 'タグを削除しました');
    }
}
