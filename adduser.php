<?php

header('Content-Type: application/json');

use Mind\Pdo\Domain\Model\User;
use Mind\Pdo\Infrastructure\Repository\PdoUserRepository;

$required["user"] = $_POST["user"];
$required["addres"] = $_POST["address"];
$required["city"] = $_POST["city"];
$required["state"] = $_POST["state"];
$required["id"] = null;

$app = new PdoUserRepository();
$user = new User($required["id"], $required["user"], $required["address"], $required["city"], $required["state"]);

return json_encode($app->insertUser($user));