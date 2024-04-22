<?php

namespace App\Http\Controllers;

use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $authorizeService)
    {
        $this->registerService = $authorizeService;
    }

    public function registration(Request $request): JsonResponse
    {
        // Валидация
        $validation_result = $this->registerService->validate($request);
        if ($validation_result instanceof JsonResponse)
        {
            return $validation_result;
        }
        // Проверка на существование пользователя
        $user_exists_result = $this->registerService->check_user_exists($request);
        if ($user_exists_result instanceof JsonResponse)
        {
            return $user_exists_result;
        }
        // Регистрация нового пользователя
        return $this->registerService->register($request);
    }
}
