<?php
import('dotenv')->config();

$db = (function () {
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $database = $_ENV['DB_DATABASE'];

    return new mysqli($host, $user, $password, $database);
})();

$export = $db;