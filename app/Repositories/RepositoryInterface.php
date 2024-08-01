<?php 
namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function detail($id);
    public function update(array $data, $id);
    public function delete($id);
}