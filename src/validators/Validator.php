<?php

namespace app\validators;

use app\interfaces\ValidatorInterface;

class Validator implements ValidatorInterface
{
  private string $error;

  public function getError(): string
  {
    return $this->error;
  }
  public function validateCreateUser($data): bool
  {
    if (empty($data["first_name"])) {
      $this->error = "El nombre es obligatorio";
      return false;
    }

    if (empty($data["last_name"])) {
      $this->error = "El apellido es obligatorio";
      return false;
    }

    if (empty($data["email"])) {
      $this->error = "El email es obligatorio";
      return false;
    }

    if (empty($data["pass"])) {
      $this->error = "La contraseña es obligatoria";
      return false;
    }

    return true;
  }
  public function validateUpdateUser(string $id): bool
  {
    if (empty($id)) {
      $this->error = "Es necesario el ID para actualizar el usuario";
      return false;
    }

    return true;
  }
  public function validateDeleteUser(string $id): bool
  {
    if (empty($id)) {
      $this->error = "Es necesario el ID para eliminar el usuario";
      return false;
    }

    return true;
  }
  public function validateCreateAddress($data): bool
  {
    if (empty($data["first_name"])) {
      $this->error = "El nombre es obligatorio";
      return false;
    }

    if (empty($data["last_name"])) {
      $this->error = "El apellido es obligatorio";
      return false;
    }

    if (empty($data["email"])) {
      $this->error = "El email es obligatorio";
      return false;
    }

    if (empty($data["address"])) {
      $this->error = "La dirección es obligatoria";
      return false;
    }

    return true;
  }
  public function validateUpdateAddress(string $id): bool
  {
    if (empty($id)) {
      $this->error = "Es necesario el ID para actualizar la dirección";
      return false;
    }

    return true;
  }
  public function validateDeleteAddress(string $id): bool
  {
    if (empty($id)) {
      $this->error = "Es necesario el ID para eliminar la dirección";
      return false;
    }

    return true;
  }
  public function validateLogin(string $email, string $password): bool
  {
    if (empty($email)) {
      $this->error = "Ingresa un correo electrónico";
      return false;
    }

    if (empty($password)) {
      $this->error = "Ingresa la contraseña";
      return false;
    }

    return true;
  }
}

?>