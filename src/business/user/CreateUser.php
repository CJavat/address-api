<?php

namespace app\business\user;

use app\exceptions\ValidationException;
use app\interfaces\RepositoryInterface;
use app\interfaces\ValidatorInterface;

class CreateUser
{
  private RepositoryInterface $repository;
  private ValidatorInterface $validator;

  public function __construct(RepositoryInterface $repository, ValidatorInterface $validator)
  {
    $this->repository = $repository;
    $this->validator = $validator;
  }

  public function create($data)
  {
    if (!$this->validator->validateCreateUser($data)) {
      throw new ValidationException($this->validator->getError());
    }

    $this->repository->create($data);
  }
}
?>