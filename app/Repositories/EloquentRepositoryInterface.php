<?php

namespace App\Repositories;

interface EloquentRepositoryInterface
{
    public function all(array $columns = ['*'], array $relationships = []);

    public function getById(int $id, array $columns = ['*'], array $relationships = []);

    public function firstByWhere(array $wheres = ['*'], array $columns = [], array $relationships = []);

    public function store($payload);

    public function update($model, $data);

    public function destroy($model);
}
