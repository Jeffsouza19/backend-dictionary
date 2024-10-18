<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;


class AuthController extends Controller
{
    /**
     * @param SignInRequest $request
     * @param AuthService $authService
     * @return AuthResource
     * @throws GeneralJsonException
     */
    public function signin(SigninRequest $request, AuthService $authService): AuthResource
    {
        try {
           return new AuthResource($authService->authenticate($request->validated()));
        }catch (\Exception $exception){
            throw new GeneralJsonException($exception->getMessage(), min($exception->getCode(), 500));
        }
    }

    /**
     * @throws GeneralJsonException
     */
    public function signup(SignupRequest $request, AuthService $authService): AuthResource
    {
        try {
            return new AuthResource($authService->register($request->validated()));
        }catch (\Exception $exception){
            throw new GeneralJsonException($exception->getMessage(), min($exception->getCode(), 500));
        }
    }
}
