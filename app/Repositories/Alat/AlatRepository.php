<?php

namespace App\Repositories\Alat;

use LaravelEasyRepository\Repository;

interface AlatRepository extends Repository{

    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function find($id);
    public function findAll();
}
