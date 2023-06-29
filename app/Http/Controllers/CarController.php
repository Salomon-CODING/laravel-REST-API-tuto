<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();

        if (count($cars) <= 0) {
            return response(["message" => "Aucune voiture de disponible"], 200);
        }

        return response($cars, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carsValidation = $request->validate([
            "model" => ["required", "string"],
            "price" => ["required", "numeric"],
            "description" => ["required", "string", "min:3"],
            "user_id" => ["required", "numeric"]
        ]);

        $car = Car::create([
            "model" => $carsValidation["model"],
            "price" => $carsValidation["price"],
            "description" => $carsValidation["description"],
            "user_id" => $carsValidation["user_id"]
        ]);

        return response([
            "voiture" => $car,
            "message" => "voiture ajoutee.."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $car = Car::find($id);
        // return $car = Car::find($id)->first(); //avec ->first() on a un objet au lieu d'un tableau d'objet

        $car = DB::table("cars")
        ->join("users", "cars.user_id", "=", "users.id")
        ->select("cars.*", "users.name", "users.email")
        ->where("cars.id", "=", $id)
        ->first();

        return $car;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carsValidation = $request->validate([
            "model" => ["string"],
            "price" => ["numeric"],
            "description" => ["string", "min:3"],
            "user_id" => ["required", "numeric"]
        ]);

        $car = Car::find($id);
        
        if (!$car) {
            return response(["message" => "Aucune voiture trouvée avec l'id $id"], 404);
        }

        if (!($car->user_id == $carsValidation["user_id"])) {
            return response(["message" => "Action interdite"], 403);
        }

        $car->update($carsValidation);

        return response(["message" => "Voiture mise à jour"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        
        if (!$car) {
            return response(["message" => "Aucune voiture trouvée avec l'id $id"], 404);
        }

        Car::destroy($id);

        return response(["message" => "Voiture supprimée"], 200);
    }
}
