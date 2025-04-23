<?php

use app\business\user\UpdateUser;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../vendor/autoload.php";

use Bramus\Router\Router;

use app\database\RepositoryDB;
use app\validators\Validator;

use app\business\user\GetOneUser;
use app\business\user\DeleteUser;
use app\business\user\CreateUser;
use app\business\user\GetUser;
use app\business\user\Login;

use app\business\address\CreateAddress;
use app\business\address\DeleteAddress;
use app\business\address\GetAddress;
use app\business\address\GetOneAddress;
use app\business\address\UpdateAddress;

use app\exceptions\DataException;
use app\exceptions\ValidationException;



$router = new Router();

$validator = new Validator();
$user_repository = new RepositoryDB("user");
$address_repository = new RepositoryDB("address");

function safeHandler(callable $callback): callable
{
  return function (...$args) use ($callback) {
    try {
      $callback(...$args);
    } catch (ValidationException $e) {
      http_response_code(400);
      echo json_encode(["validationError" => $e->getMessage()]);
    } catch (DataException $e) {
      http_response_code(404);
      echo json_encode(["dataError" => $e->getMessage()]);
    } catch (PDOException $e) {
      http_response_code(404);
      echo json_encode(["pdoError" => $e->getMessage()]);
    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode(["exceptionError" => $e->getMessage()]);
    } catch (TypeError $e) {
      http_response_code(400);
      echo json_encode(["typeError" => $e->getMessage()]);
    }
  };
}

$router->options(".*", function () {
  header("Content-Type: application/json");
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Alloww-Headers: Content-Type, Authorization, X-Request-with");
});

//? Rutas de usuario
$router->get("/users", safeHandler(
  function () use ($user_repository) {
    $users = new GetUser($user_repository);
    http_response_code(200);
    echo json_encode($users->get());
  }
));

$router->get("/user/id/{id}", safeHandler(
  function ($id) use ($user_repository) {
    $users = new GetOneUser($user_repository);
    http_response_code(200);
    echo json_encode($users->findById($id));
  }
));

$router->post("/user", safeHandler(
  function () use ($user_repository, $validator) {
    $body = json_decode(file_get_contents("php://input"), true);
    $post = new CreateUser($user_repository, $validator);
    $post->create($body);

    http_response_code(200);
    echo json_encode(["message" => "Usuario Creado"]);
  }
));
$router->post("/login", safeHandler(
  function () use ($user_repository, $validator) {
    $body = json_decode(file_get_contents("php://input"), true);
    $login = new Login($user_repository, $validator);
    $login->login($body["email"], $body["password"]);

    http_response_code(200);
    echo json_encode(["ok" => true]);
  }
));
$router->put("/user/{id}", safeHandler(
  function ($id) use ($user_repository, $validator) {
    $put = new UpdateUser($user_repository, $validator);
    $body = json_decode(file_get_contents("php://input"), true);
    $put->update($id, $body);

    echo json_encode(["message" => "Usuario actualizada correctamente"]);
  }
));
$router->delete("/user/id/{id}", safeHandler(
  function ($id) use ($user_repository) {
    $delete = new DeleteUser($user_repository);
    $delete->delete($id);

    echo json_encode(["message" => "Usuario eliminado correctamente"]);
  }
));

//? Rutas de dirección
$router->get("/address", safeHandler(
  function () use ($address_repository) {
    $users = new GetAddress($address_repository);
    http_response_code(200);
    echo json_encode($users->get());
  }
));

$router->get("/address/id/{id}", safeHandler(
  function ($id) use ($address_repository) {
    $users = new GetOneAddress($address_repository);
    http_response_code(200);
    echo json_encode($users->findById($id));
  }
));

$router->post("/address", safeHandler(
  function () use ($address_repository, $validator) {
    $body = json_decode(file_get_contents("php://input"), true);
    $post = new CreateAddress($address_repository, $validator);
    $post->create($body);

    http_response_code(200);
    echo json_encode(["message" => "Usuario Creado"]);
  }
));
$router->put("/address/{id}", safeHandler(
  function ($id) use ($address_repository, $validator) {
    $put = new UpdateAddress($address_repository, $validator);
    $body = json_decode(file_get_contents("php://input"), true);
    $put->update($id, $body);

    echo json_encode(["message" => "Usuario actualizada correctamente"]);
  }
));
$router->delete("/address/id/{id}", safeHandler(
  function ($id) use ($address_repository) {
    $delete = new DeleteAddress($address_repository);
    $delete->delete($id);

    echo json_encode(["message" => "Usuario eliminado correctamente"]);
  }
));

$router->set404(function () {
  http_response_code(405);
  echo json_encode(["message" => "La ruta no existe"]);
});


//! Iniciar el router.
$router->run();
?>