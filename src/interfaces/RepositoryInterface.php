<?php

namespace app\interfaces;

interface RepositoryInterface
{
  public function get(): array;
  public function exists(string $id): bool;
  public function create(array $data);
  public function update(string $id, array $data);
  public function delete(string $id);
  public function findById(string $id): array;
  public function login(string $email, string $password): bool;
}

?>