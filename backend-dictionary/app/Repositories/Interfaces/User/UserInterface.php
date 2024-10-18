<?php

namespace App\Repositories\Interfaces\User;

use Illuminate\Database\Eloquent\Model;

interface UserInterface
{
    public function __construct(Model $model);
    public function getAll();

    public function store(array $data);
    public function getOne($id);

    public function update($id, array $data);

    public function destroy($id);
}
