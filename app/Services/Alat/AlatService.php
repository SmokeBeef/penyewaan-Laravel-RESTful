<?php

namespace App\Services\Alat;

use LaravelEasyRepository\BaseService;

interface AlatService extends BaseService{

    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function getById($id);
    public function getAll();
}
