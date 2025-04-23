<?php

namespace app\business\user;

use app\interfaces\RepositoryInterface;
use app\exceptions\DataException;

class DeleteUser
{

  private RepositoryInterface $repository;

  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function delete(string $id)
  {
    if (!$this->repository->exists($id)) {
      throw new DataException("El usuario no existe");
    }

    $this->repository->delete($id);
  }
}

?>