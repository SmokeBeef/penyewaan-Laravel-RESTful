<?php

namespace App\Services\Kategori;

use LaravelEasyRepository\Service;
use App\Repositories\Kategori\KategoriRepository;

class KategoriServiceImplement extends Service implements KategoriService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(KategoriRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }
  public function create($data)
  {
    return $this->mainRepository->create($data);
  }

  public function update($id, $data)
  {
    $idCheckExist = $this->mainRepository->findOne($id);
    if (!$idCheckExist) {
      return null;
    }
    return $this->mainRepository->update($id, $data);
  }
  public function destroy($id)
  {
    $idCheckExist = $this->mainRepository->findOne($id);
    if (!$idCheckExist) {
      return null;
    }
    return $this->mainRepository->destroy($id);
  }
  public function getById($id)
  {
    return $this->mainRepository->findOne($id);
  }
  public function getAll()
  {
    return $this->mainRepository->findAll();
  }
  public function getByIdJoin($id)
  {
    return $this->mainRepository->findJoin($id);
  }

  // Define your custom methods :)
}
