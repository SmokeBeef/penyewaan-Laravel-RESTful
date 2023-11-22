<?php

namespace App\Repositories\Alat;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Alat;

class AlatRepositoryImplement extends Eloquent implements AlatRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Alat $model)
    {
        $this->model = $model;
    }


    public function create($data)
    {
        $alat = Alat::create($data);
        return $alat;
    }

    public function update($id, $data)
    {
        $alat = Alat::find($id);
        $alat->update($data);
        return $alat;
    }

    public function delete($id)
    {
        Alat::destroy($id);
        return true;
    }

    public function find($id)
    {
        return Alat::find($id);
    }

    public function findAll()
    {
        return Alat::all();
    }


    // Write something awesome :)
}
