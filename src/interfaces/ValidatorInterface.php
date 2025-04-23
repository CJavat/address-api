<?php

namespace app\interfaces;

interface ValidatorInterface
{
  public function getError(): string;
  public function validateCreateUser(array $data): bool;
  public function validateUpdateUser(string $id): bool;
  public function validateDeleteUser(string $id): bool;
  public function validateLogin(string $email, string $passowrd): bool;
  public function validateCreateAddress(array $data): bool;
  public function validateUpdateAddress(string $id): bool;
  public function validateDeleteAddress(string $id): bool;
}

?>