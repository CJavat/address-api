<?php

namespace app\business\user;

use app\interfaces\RepositoryInterface;

class GetUser
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