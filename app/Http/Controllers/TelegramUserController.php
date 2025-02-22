<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TelegramUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $telegramUsers = TelegramUser::all();
        return response()->json($telegramUsers, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_name' => 'string',
            'telegram_name' => 'required|string',
            'telegram_id' => 'required|string',
            'is_employee' => 'required|boolean',
        ]);
        $telegramUser = TelegramUser::create($fields);
        return response()->json($telegramUser, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $telegramUser = TelegramUser::findOrFail($id);
            return response()->json($telegramUser, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegramUser $telegramUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TelegramUser $telegramUser)
    {
        $fields = $request->validate([
            'user_name' => 'string',
            'telegram_name' => 'required|string',
            'telegram_id' => 'required|string',
            'is_employee' => 'required|boolean',
        ]);
        $telegramUser->update($fields);
        return response()->json($telegramUser, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegramUser $telegramUser)
    {
        $telegramUser->delete();
        return response()->json(['message' => 'User deleted'], 200);
    }
}
