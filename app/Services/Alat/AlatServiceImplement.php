<?php

namespace App\Services\Alat;

use LaravelEasyRepository\Service;
use App\Repositories\Alat\AlatRepository;
use Illuminate\Support\Facades\Redis;

class AlatServiceImplement extends Service implements AlatService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;
  private string $keyRedis = "alatList";
  public function __construct(AlatRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;

  }

  public function getAll()
  {
    if (Redis::exists($this->keyRedis)) {
      return json_decode(Redis::get($this->keyRedis));
    }
    $alat = $this->mainRepository->findAll();
    Redis::set($this->keyRedis, json_encode($alat));
    return $alat;
  }

  public function getById($id)
  {
    return $this->mainRepository->find($id);
  }

  public function create($data)
  {
    Redis::del($this->keyRedis);
    return $this->mainRepository->create($data);
  }

  public function update($id, $data)
  {
    $dataExist = $this->mainRepository->find($id);
    if (!$dataExist) {
      return null;
    }
    Redis::del($this->keyRedis);
    return $this->mainRepository->update($id, $data);
  }

  public function delete($id)
  {
    $dataExisted = $this->mainRepository->find($id);
    if (!$dataExisted) {
      return null;
    }
    Redis::del($this->keyRedis);
    return $this->mainRepository->delete($id);
  }
  // Define your custom methods :)
}
