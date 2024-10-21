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
     * @response 200 {"id":1,"name":"Jeferson","email":"example@example.com","created_at":"2024-10-21T11:05:40.000000Z","updated_at":"2024-10-21T11:05:40.000000Z"}
     * @response 400 { "errors": { "message": "An error occurred while retrieving user information." } }
     */
    public function me(): UserResource
    {
        try {
            return new UserResource(auth()->user());
        }catch (\Exception $e){
            throw new GeneralJsonException('An error occurred while retrieving user information.');
        }
    }

    /**
     * @param UserService $userService
     * @return UserWordResource
     * @throws GeneralJsonException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @response 200 {"results":[{"word":"man","added":"2024-10-21T11:12:20.000000Z"},{"word":"hi","added":"2024-10-21T11:11:44.000000Z"}],"totalDocs":2,"previous":null,"next":null,"hasNext":false,"hasPrev":false}
     * @response 400 { "errors": { "message": "An error occurred while retrieving user history information." } }
     */
    public function history(UserService $userService): UserWordResource
    {
        try {
            return new UserWordResource($userService->getHistory());
        } catch (\Exception $exception){
            throw new GeneralJsonException('An error occurred while retrieving user history information.');
        }
    }

    /**
     * @param UserService $userService
     * @return UserWordResource
     * @throws ContainerExceptionInterface
     * @throws GeneralJsonException
     * @throws NotFoundExceptionInterface
     * @response 200 {"results":[{"word":"man","added":"2024-10-21T11:12:20.000000Z"},{"word":"hi","added":"2024-10-21T11:11:44.000000Z"}],"totalDocs":2,"previous":null,"next":null,"hasNext":false,"hasPrev":false}
     * @response 400 { "errors": { "message": "An error occurred while retrieving user history information." } }
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
