<?php

namespace app\business\address;

use app\interfaces\RepositoryInterface;
use app\exceptions\DataException;

class DeleteAddress
{
  private RepositoryInterface $repository;

  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function delete(string $id)
  {
    if (!$this->repository->exists($id)) {
      throw new DataException("La dirección no existe");
    }

    $this->repository->delete($id);
  }
}
?>