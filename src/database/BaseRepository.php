<?php

namespace app\database;

use PDO;

abstract class BaseRepository
{
  protected $pdo;

  public function __construct()
  {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8";
    $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
}

?>