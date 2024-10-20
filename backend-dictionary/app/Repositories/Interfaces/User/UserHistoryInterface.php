<?php

namespace App\Repositories\Interfaces\User;

use Illuminate\Database\Eloquent\Model;

interface UserHistoryInterface
{
    public function __construct(Model $model);
    public function getAll();

    public function store($user, $word);
    public function getHistory($user, $limit);

    public function update($id, array $data);

    public function destroy($id);
}
