<?php

namespace App\Repositories\Kategori;

use LaravelEasyRepository\Repository;

interface KategoriRepository extends Repository{

    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function findAll();
    public function findJoin($id);
    public function findOne($id);
    
}
