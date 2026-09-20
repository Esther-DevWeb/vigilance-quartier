<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlertRequest;
use App\Models\Alert;

class AlertController extends Controller
{
    public function index()
    {
        return Alert::with('user')->orderByDesc('created_at')->paginate(10);
    }

    public function store(StoreAlertRequest $request)
    {
        $alert = Alert::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'message' => $request->message,
            'urgency' => $request->urgency,
            'neighborhood' => $request->neighborhood,
        ]);

        return response()->json($alert, 201);
    }
}
