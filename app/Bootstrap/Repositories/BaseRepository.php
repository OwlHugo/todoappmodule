<?php

namespace App\Bootstrap\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BaseRepository
{
    public function __construct(private Model $model) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 30): LengthAwarePaginator
    {
        return $this->model->orderByDesc('created_at')->paginate($perPage);
    }

    public function getById(string $id): Model|null
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function select(string $value = 'id', string $label = 'name', bool $prepend = true, string $prependLabel = 'Selecione')
    {
        $query = $this->model
            ->orderby($label, 'asc')
            ->selectRaw("{$value}, {$label}")
            ->pluck($label, $value);

        if ($prepend) {
            $query->prepend($prependLabel, '');
        }

        return $query;
    }
} 
 