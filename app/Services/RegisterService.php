<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterService
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $users = Cache::get('users');
        try {
            $new_user = [
                'id' => last($users)['id'] + 1,
                'name' => $request->input('name'),
                'email' => $request->input('email')
            ];
        } catch (\Exception) {
            return response()->json(["error" => \Exception::class], 400);
        }
        Log::notice('Пользователь успешно зарегистрирован. ' . "Пользователь: " . $request->input('email'));

        $users[] = $new_user;
        Cache::put('users', $users);

        return response()->json(["data" => ["Пользователь успешно зарегистрирован!"]], 200);
    }

    public function checkUserExists(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        $users = Cache::get('users');
        foreach ($users as $user) {
            if ($user['email'] === $request->input('email')) {
                Log::error('Ошибка: пользователь уже зарегистрирован. ' . "Пользователь: " . $request->input('email'));
                return response()->json(["error" => ["Пользователь уже зарегистрирован."]], 401);
            }
        }
        return false;
    }

    public function validate(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        try {
            Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|confirmed',
                'name' => 'required'
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            Log::error('Ошибка:' . $e->getMessage() . " Пользователь: " . $request->input('email'));
            return response()->json(["error" => $errors], 422);
        }
        return true;
    }
}
