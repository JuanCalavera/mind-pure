<?php

header('Content-Type: application/json');

use Mind\Pdo\Infrastructure\Repository\PdoUserRepository;

$app = new PdoUserRepository;

return json_encode($app->userAddress($_POST["id"]));