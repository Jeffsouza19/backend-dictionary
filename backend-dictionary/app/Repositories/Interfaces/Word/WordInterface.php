<?php

namespace App\Repositories\Interfaces\Word;

use Illuminate\Database\Eloquent\Model;

interface WordInterface
{
    public function __construct(Model $model);
    public function getAll($search, $limit);

    public function createWord($word, $newWord);
    public function getOne(string $word);

    public function update($id, array $data);

    public function destroy($id);
}
