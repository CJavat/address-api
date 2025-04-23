<?php

namespace app\business\address;

use app\interfaces\RepositoryInterface;

class GetAddress
{
  private RepositoryInterface $repository;

  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function get(): array
  {
    return $this->repository->get();
  }
}
?>