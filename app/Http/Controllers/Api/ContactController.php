<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * お問い合わせ一覧の取得 (GET /api/contacts)
     */
    public function index()
    {
        $contacts = Contact::with('category')->latest()->paginate(10);

        return ContactResource::collection($contacts);
    }

    /**
     * お問い合わせの新規作成 (POST /api/contacts)
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        return response()->json(
            new ContactResource($contact->load('category')),
            201
        );
    }

    /**
     * お問い合わせ詳細の取得 (GET /api/contacts/{contact})
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact->load('category'));
    }
}
