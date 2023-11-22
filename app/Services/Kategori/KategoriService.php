<?php

namespace App\Services\Kategori;

use LaravelEasyRepository\BaseService;

interface KategoriService extends BaseService
{
    public function create($data);
    public function getById($id);
    public function getByIdJoin($id);
    public function getAll();
    public function update($id, $data);
    public function delete($id);
}
