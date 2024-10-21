<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWordResource;
use App\Services\UserService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @group User Routes
 */
class UserController extends Controller
{
    /**
     * Show User Profile Route
     *
     * @return UserResource
     * @throws GeneralJsonException
     */
    public function me(): UserResource
    {
        try {
            return new UserResource(auth()->user());
        }catch (\Exception $e){
            throw new GeneralJsonException($e->getMessage(), 400);
        }
    }

    /**
     * @param UserService $userService
     * @return UserWordResource
     * @throws GeneralJsonException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function history(UserService $userService): UserWordResource
    {
        try {
            return new UserWordResource($userService->getHistory());
        } catch (\Exception $exception){
            throw new GeneralJsonException($exception->getMessage(), 400);
        }
    }

    /**
     * @param UserService $userService
     * @return UserWordResource
     * @throws ContainerExceptionInterface
     * @throws GeneralJsonException
     * @throws NotFoundExceptionInterface
     */
    public function favorites(UserService $userService): UserWordResource
    {
        try {
            return new UserWordResource($userService->getFavorite(auth()->user()));
        } catch (\Exception $exception){
            throw new GeneralJsonException($exception->getMessage(), 400);
        }
    }
}
