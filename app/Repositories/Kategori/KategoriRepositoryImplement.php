<?php

namespace App\Repositories\Kategori;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Kategori;

class KategoriRepositoryImplement extends Eloquent implements KategoriRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Kategori $model)
    {
        $this->model = $model;
    }
    public function create($data)
    {
        return $this->model->create($data);
    }
    public function update($id, $data)
    {
        return $this->model->update($id, $data);
    }
    public function delete($id)
    {
        $this->model->find($id);
        return $this->model->delete();
        
    }
    public function findAll()
    {
        return $this->model->all();
    }
    public function findOne($id)
    {
        return $this->model->find($id);
    }
    public function findJoin($id)
    {
        return $this->model->with("alat")->find($id);
    }
    // Write something awesome :)
}
