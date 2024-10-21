<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Exception;

/**
 * @group Auth Routes
 */
class AuthController extends Controller
{
    /**
     * SignIn Route
     *
     * @unauthenticated
     * @param SignInRequest $request
     * @param AuthService $authService
     * @return AuthResource
     * @throws GeneralJsonException
     * @response 400 { "errors": { "message": { "email": [ "The email has already been taken." ] } } }
     * @response 200 { "id": 2, "name": "Jeferson", "token": "Bearer *token*" }
     */
    public function signin(SigninRequest $request, AuthService $authService): AuthResource
    {
        try {
           return new AuthResource($authService->authenticate($request->validated()));
        }catch (Exception $exception){
            throw new GeneralJsonException($exception->getMessage(), min($exception->getCode(), 500));
        }
    }

    /**
     * SignUp Route
     *
     * @unauthenticated
     * @param SignUpRequest $request
     * @param AuthService $authService
     * @return AuthResource
     * @throws GeneralJsonException
     * @response 400 { "errors": { "message": "Não Foi possível realizar o Login, favor verificar se o email e/ou senha estão corretos" } }
     * @response 200 { "id": 2, "name": "Jeferson", "token": "Bearer *token*" }
     */
    public function signup(SignupRequest $request, AuthService $authService): AuthResource
    {
        try {
            return new AuthResource($authService->register($request->validated()));
        }catch (Exception $exception){
            throw new GeneralJsonException($exception->getMessage(), min($exception->getCode(), 500));
        }
    }
}
