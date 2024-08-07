<?php

namespace App\Repositories;


abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    public function __construct()
    {
        $this->model = app()->make($this->getModel());
    }
    abstract public function getModel();


    public function getNameAndIds()
    {
        return $this->model->pluck('name', 'id');
    }
    public function getAll($data)
    {
        return $this->model->paginate($data['size'] ?? 10);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $student = $this->model->findOrFail($id);
        return $student->update($data);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
