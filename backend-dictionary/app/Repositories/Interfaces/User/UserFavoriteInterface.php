<?php

namespace App\Repositories\Interfaces\User;

use Illuminate\Database\Eloquent\Model;

interface UserFavoriteInterface
{
    public function __construct(Model $model);
    public function getAll();

    public function setFavorite($user, $word);
    public function getOne($id);

    public function update($id, array $data);

    public function destroy($user, $objWord);
}
