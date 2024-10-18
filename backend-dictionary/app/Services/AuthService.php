<?php

namespace App\Services;

use App\Exceptions\GeneralJsonException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\User\UserInterface;

class AuthService
{
    protected UserInterface $repo;
    public function __construct(UserInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param $credentials
     * @return Authenticatable
     * @throws GeneralJsonException
     */
    public function authenticate($credentials): Authenticatable
    {
        if (Auth::attempt($credentials)) {
            $user = \auth()->user();
            $user->tokens()->delete();
            $token = $user->createToken(env('APP_NAME'))->plainTextToken;

            $user['token'] = $token;
            return $user;
        }

        throw new GeneralJsonException('Não Foi possível realizar o Login, favor verificar se o email e/ou senha estão corretos', 401);

    }

    /**
     * @throws GeneralJsonException
     */
    public function register($data): Authenticatable
    {
        $user =  $this->repo->store($data);
        if($user){
            $credentials = array("email" => $data["email"], "password" => $data["password"]);
            return $this->authenticate($credentials);
        }
        throw new GeneralJsonException('Ocorreu um erro ao cadastrar, tente novamente', 500);
    }
}
