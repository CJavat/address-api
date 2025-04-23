<?php

namespace app\business\user;

use app\exceptions\DataException;
use app\interfaces\RepositoryInterface;

class GetOneUser
{
  private RepositoryInterface $repository;

  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function findById(string $id)
  {
    if (!$this->repository->exists($id)) {
      throw new DataException("El usuario no existe");
    }

    return $this->repository->findById($id);
  }
}

?>