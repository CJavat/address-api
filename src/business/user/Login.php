<?php

namespace app\business\user;

use app\exceptions\DataException;
use app\exceptions\ValidationException;
use app\interfaces\RepositoryInterface;
use app\interfaces\ValidatorInterface;

class Login
{
  private RepositoryInterface $repository;
  private ValidatorInterface $validator;

  public function __construct(RepositoryInterface $repository, ValidatorInterface $validator)
  {
    $this->repository = $repository;
    $this->validator = $validator;
  }

  public function login(string $email, string $password)
  {
    if (!$this->validator->validateLogin($email, $password)) {
      throw new ValidationException($this->validator->getError());
    }

    if (!$this->repository->login($email, $password)) {
      throw new ValidationException("Error al iniciar sesión, escribe los datos correctamente");
    }


    return true;
  }
}

?>