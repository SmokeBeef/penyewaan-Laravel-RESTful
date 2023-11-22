<?php

namespace App\Services\Admin;

use LaravelEasyRepository\BaseService;

interface AdminService extends BaseService{

    public function getAll();
    public function getById($id);
    public function create($data);
}
