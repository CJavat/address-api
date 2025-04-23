<?php

namespace app\database;

use PDO;
use Ramsey\Uuid\Uuid;
use app\database\BaseRepository;
use app\interfaces\RepositoryInterface;


class RepositoryDB extends BaseRepository implements RepositoryInterface
{
  private string $table;

  public function __construct(string $table)
  {
    parent::__construct();
    $this->table = $table;
  }

  public function get(): array
  {
    $query = "SELECT * FROM " . $this->table;
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
  }
  public function exists(string $id): bool
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["id" => $id]);
    $exists = $stmt->rowCount() > 0;

    return $exists;
  }
  public function create(array $data)
  {
    $uuid = Uuid::uuid4();
    $data["id"] = $uuid->toString();
    $query = "";

    if ($this->table === "user") {
      $data["pass"] = password_hash($data["pass"], PASSWORD_DEFAULT);
      $query = "INSERT INTO " . $this->table . " (id, first_name, last_name, email, pass) VALUES (:id, :first_name, :last_name, :email, :pass)";
    } else if ($this->table === "address") {
      $query = "INSERT INTO " . $this->table . " (id, first_name, last_name, email, address) VALUES (:id, :first_name, :last_name, :email, :address)";
    }

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($data);
  }
  public function update(string $id, array $data)
  {
    $query = "";
    $user = $this->findById($id);
    $data["id"] = $id;

    if ($this->table === "user") {
      $data["first_name"] = isset($data["first_name"]) ? $data["first_name"] : $user["first_name"];
      $data["last_name"] = isset($data["last_name"]) ? $data["last_name"] : $user["last_name"];
      $data["email"] = isset($data["email"]) ? $data["email"] : $user["email"];
      $data["pass"] = isset($data["pass"]) ? $data["pass"] : $user["pass"];

      $query = "UPDATE " . $this->table
        . " SET first_name = :first_name, last_name = :last_name, email = :email, pass = :pass"
        . " WHERE id = :id";

    } else if ($this->table === "address") {
      $data["first_name"] = isset($data["first_name"]) ? $data["first_name"] : $user["first_name"];
      $data["last_name"] = isset($data["last_name"]) ? $data["last_name"] : $user["last_name"];
      $data["address"] = isset($data["address"]) ? $data["address"] : $user["address"];
      $data["email"] = isset($data["email"]) ? $data["email"] : $user["email"];

      $query = "UPDATE " . $this->table
        . " SET first_name = :first_name, last_name = :last_name, email = :email, address = :address"
        . " WHERE id = :id";
    }

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($data);
  }
  public function delete(string $id)
  {
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["id" => $id]);
  }
  public function findById(string $id): array
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["id" => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data;
  }

  public function findByEmail(string $email): array
  {
    $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(["email" => $email]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data;
  }

  public function login(string $email, string $password): bool
  {
    $user = $this->findByEmail($email);

    if (password_verify($password, $user["pass"])) {
      return true;
    } else {
      return false;
    }
  }
}
?>