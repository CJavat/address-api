<?php

namespace app\exceptions;

use Exception;

class DataException extends Exception
{
  public function __construct(string $message)
  {
    parent::__construct($message);
  }
}

?>