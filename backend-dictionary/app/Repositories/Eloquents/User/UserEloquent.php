<?php

namespace App\Repositories\Eloquents\User;

use App\Repositories\Interfaces\User\UserInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserEloquent implements UserInterface
{
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function store(array $data)
    {
        return $this->model->newQuery()->create($data);
    }

    public function getOne($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $result = $this->model->find($id);
        $result->update($data);

        return $result;
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }

}
