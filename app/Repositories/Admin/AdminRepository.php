<?php

namespace App\Repositories\Admin;

use LaravelEasyRepository\Repository;

interface AdminRepository extends Repository{

    /**
     * 
     */
    public function getAll();
    public function getById($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}
