<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/utilisateurs", [UserController::class, "index"]);
Route::post("/utilisateur/inscription", [UserController::class, "inscription"]);
Route::post("/utilisateur/connexion", [UserController::class, "connexion"]);

Route::get("/cars", [CarController::class, "index"]);
Route::get("/cars/{id}", [CarController::class, "show"]);

Route::get("/", function() { 
    return ["Hello" => "world.."]; 
});

Route::group(["middleware" => ["auth:sanctum"]], function() {
    Route::post("/cars", [CarController::class, "store"]);
    Route::put("/cars/{id}", [CarController::class, "update"]);
    Route::delete("/cars/{id}", [CarController::class, "destroy"]);
    Route::post("/utilisateur/deconnexion", [UserController::class, "deconnexion"]);
});

// pour gerer l'authentification, il faut aller dans le fichier kernel.php dans (app/http) pour decommenter
// la ligne qui permettra à "sanctum" de pouvoir travailler avec les tokens (c'est la ligne qui comporte ceci : "\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class," )
//c'est la ligne 42
