<?php

namespace App\Repositories\Eloquents\User;

use App\Repositories\Interfaces\User\UserFavoriteInterface;
use Illuminate\Database\Eloquent\Model;

class UserFavoriteEloquent implements UserFavoriteInterface
{
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function setFavorite($user, $word)
    {
        return $this->model->newQuery()->updateOrCreate([
            'user_id' => $user->id,
            'word_id' => $word->id
        ]);
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

    public function destroy($user, $objWord)
    {
        return $this->model->newQuery()->where([
            'user_id' => $user->id,
            'word_id' => $objWord->id
        ])->delete();
    }

    public function getFavorite($user, $limit): array
    {
        $paginate = $this
            ->model
            ->newQuery()
            ->with(['word'])
            ->where('user_id', '=', $user->id)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate($limit);
        $count = $this->model->newQuery()->count();
        return compact('paginate', 'count');
    }

}
