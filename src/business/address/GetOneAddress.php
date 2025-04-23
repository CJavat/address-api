<?php

namespace app\business\address;

use app\exceptions\DataException;
use app\interfaces\RepositoryInterface;

class GetOneAddress
{
  private RepositoryInterface $repository;

  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function findById(string $id)
  {
    if (!$this->repository->exists($id)) {
      throw new DataException("La dirección no existe");
    }

    return $this->repository->findById($id);
  }
}

?>