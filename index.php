<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'Models/Database.php';
require_once 'Models/BaseModel.php';
require_once 'Models/Post.php';
require_once 'Controllers/PostController.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($route) {
    case '/posts':
        $controller = new PostController();
        if ($method === 'GET') {
            $postId = $_GET['id'] ?? 0;
            $controller->read((int) $postId);
        } else if ($method === 'POST') {
            $requestBody = file_get_contents('php://input');
            $data = json_decode($requestBody, true);
            $controller->create($data);
        } else if ($method === 'PUT') {
            $postId = $_GET['id'] ?? 0;
            $requestBody = file_get_contents('php://input');
            $data = json_decode($requestBody, true);
            $controller->update((int) $postId, $data);
        } else if ($method === 'DELETE') {
            $postId = $_GET['id'] ?? 0;
            $controller->delete((int) $postId);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo 'Method not allowed';
        }
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo 'Page not found';
        break;
}