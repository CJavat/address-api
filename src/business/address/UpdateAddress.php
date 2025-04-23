<?php

namespace app\business\address;

use app\exceptions\DataException;
use app\exceptions\ValidationException;
use app\interfaces\RepositoryInterface;
use app\interfaces\ValidatorInterface;

class UpdateAddress
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
    if (!$this->validator->validateUpdateAddress($id)) {
      throw new ValidationException($this->validator->getError());
    }

    if (!$this->repository->exists($id)) {
      throw new DataException("La dirección no existe");
    }

    $this->repository->update($id, $data);
  }
}
?>