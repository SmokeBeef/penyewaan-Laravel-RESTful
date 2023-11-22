<?php

namespace App\Repositories\Admin;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Admin;

class AdminRepositoryImplement extends Eloquent implements AdminRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    public function create( $data)
    {
        return $this->model->create($data);
    }

    public function update( $id, $data) 
    {
        return $this->model->update($id, $data);
    }
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
    // Write something awesome :)
}
