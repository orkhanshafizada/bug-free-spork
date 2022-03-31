<?php

define('BASE_DIR', str_replace("\\", "/", __DIR__));
define('APP',  BASE_DIR . "/app/");

require_once("vendor/autoload.php");


use Dotenv\Dotenv;
use App\Core\Route;
use App\Controllers\UserController;
use App\Controllers\HomeController;


$dotenv = Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

Route::get( '/', [ HomeController::class,  'index' ] );
Route::get( '/api/v1/users', [ UserController::class,  'index' ] );
Route::post( '/api/v1/user/store', [ UserController::class,  'store' ] );


Route::dispatch();
