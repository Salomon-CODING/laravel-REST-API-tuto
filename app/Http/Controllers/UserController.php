<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        $users = User::all();

        if (count($users) <= 0) {
            return response(["Message" => "Aucun utilisateur dans la Base de Données"], 200);
        }

        return response($users, 200);

    }

    public function inscription(Request $Request){

        $utilisateurDonnee = $Request->validate([
            "name" => ["required", "string", "min:2", "max:255"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "string", "min:8", "max:30", "confirmed"]
        ]);

        $utilisateurs = User::create([
            "name" => $Request["name"],
            "email" => $Request["email"],
            "password" => bcrypt($Request["password"])
        ]);

        return response($utilisateurs, 201);
    }

    public function connexion(Request $Request) {

        $utilisateurDonnee = $Request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "string", "min:8", "max:30"]
        ]);

        $utilisateur = User::where("email", $utilisateurDonnee["email"])->first();
        if(!$utilisateur) {
            return response(["message" => "Personne n'a l'email $utilisateurDonnee[email]"], 401);
        }
        if(!Hash::check($utilisateurDonnee["password"], $utilisateur->password))
        {
            return response(["message" => "Mot de Passe Incorrect, try again"], 401);
        }
        $token = $utilisateur->createToken("CLE_SECRETE")->plainTextToken;
        return response( [
            "utilisateur" => $utilisateur,
            "token" => $token
        ], 200);
    }

    public function deconnexion() {
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return response(["message" => "Déconnexion réussie.."], 200);
    }
}
