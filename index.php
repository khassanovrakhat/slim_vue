<?php
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface;


define('ROOT', realpath('..'). "/slimapi/uploads/");

require_once './controllers/users.php';
require_once './controllers/admin.php';

require_once './config/db.php';

require './vendor/autoload.php';
$config = ['settings' => ['displayErrorDetails' => true]];

$app = new \Slim\App($config);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->group('/users', function() use ($app){
    $app->post('/register', 'Controllers\UsersController:register');
    $app->post('/login', 'Controllers\UsersController:login');
    $app->post('/addCV', 'Controllers\UsersController:addCV');
    $app->post('/getCV', 'Controllers\UsersController:getCV');
});

$app->group('/admin', function() use ($app){
    $app->post('/register', 'Controllers\AdminController:register');
    $app->post('/login', 'Controllers\AdminController:login');
    $app->post('/addVacancy', 'Controllers\AdminController:addVacancy');
    $app->post('/getViewVacancy', 'Controllers\AdminController:getViewVacancy');
    $app->post('/getCV', 'Controllers\AdminController:getCV');
});

$app->run();
            