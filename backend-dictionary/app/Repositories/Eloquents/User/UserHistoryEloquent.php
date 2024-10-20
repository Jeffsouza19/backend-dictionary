<?php

namespace App\Repositories\Eloquents\User;

use App\Repositories\Interfaces\User\UserHistoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserHistoryEloquent implements UserHistoryInterface
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

    public function store($user, $word)
    {
        return $this->model->newQuery()->updateOrCreate([
            'user_id' => $user->id,
            'word_id' => $word->id
        ]);
    }

    public function getHistory($user, $limit): array
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
