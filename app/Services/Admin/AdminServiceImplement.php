<?php

namespace App\Services\Admin;

use LaravelEasyRepository\Service;
use App\Repositories\Admin\AdminRepository;

class AdminServiceImplement extends Service implements AdminService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(AdminRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAll()
  {
    return $this->mainRepository->getAll();
  }
  public function getById($id)
  {
    return $this->mainRepository->getById($id);
  }
  // Define your custom methods :)
}
