<?php

namespace App\Repositories\Eloquent;
use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relationships = [])
    {
        return $this->model->with($relationships)->get($columns);
    }

    public function getById($id, array $columns = ['*'], array $relationships = [])
    {
        return $this->model->select($columns)->with($relationships)->findorFail($id);
    }

    public function firstByWhere(array $wheres= [], array $columns = ['*'], array $relationships = [])
    {
        return $this->model->select($columns)->where($wheres)->with($relationships)->first();
    }

    public function store($payload)
    {
        return $this->model->create($payload);
    }

    public function update($model, $data)
    {
        return $model->update($data);
    }

    public function destroy($model)
    {
        return $model->delete();
    }
}
