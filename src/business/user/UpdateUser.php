<?php

namespace app\business\user;

use app\exceptions\DataException;
use app\exceptions\ValidationException;
use app\interfaces\RepositoryInterface;
use app\interfaces\ValidatorInterface;

class UpdateUser
{
  private RepositoryInterface $repository;
  private ValidatorInterface $validator;

  public function __construct(RepositoryInterface $repository, ValidatorInterface $validator)
  {
    $this->repository = $repository;
    $this->validator = $validator;
  }

  public function update(string $id, array $data)
  {
    if (!$this->validator->validateUpdateUser($id)) {
      throw new ValidationException($this->validator->getError());
    }

    if (!$this->repository->exists($id)) {
      throw new DataException("El usuario no existe");
    }

    $this->repository->update($id, $data);
  }
}

?>