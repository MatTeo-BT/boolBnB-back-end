<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(){
        // ? EAGER LOADING con il nome del metodo presente all'interno del model
        $apartments = Apartment::with('user', 'sponsors', 'services')->get()->toArray();
        $sponsoredApartment = [];
        
        foreach ($apartments as $index => $apartment) {
            if ($apartment['sponsors'] != []) {
                unset($apartments[$index]);
                array_push($sponsoredApartment, $apartment);
            }
        }

        foreach($sponsoredApartment as $sa) {
            array_unshift($apartments, $sa);
        }
        return response()->json(
            [
                "success" => true,
                "results" => $apartments
            ]);
    }

    public function show(Apartment $apartment){
        $apartment->load('user');
        return response()->json([
            "success" => true,
            "results" => $apartment
        ]);
    }

    public function search(Request $request){
        $query = Apartment::query();

        if($request->has('beds') && $request['beds'] != 0) {
            $query->where('no_beds', '>=', $request['beds']);
        }

        if($request->has('rooms') && $request['rooms'] != 0) {
            $query->where('no_rooms', '>=', $request['rooms']);
        }

        if($request->has('bathrooms') && $request['bathrooms'] != 0) {
            $query->where('no_bathrooms', '>=', $request['bathrooms']);
        }

        if($request->has('services') && $request['services'] != []) {
            $services = $request['services'];
            $query->whereHas('services', function ($q) use ($services) {
                $q->whereIn('service_id', $services);
            }, '=', count($services));
        }


        if($request->has('address') && $request['address'] != "") {
            $apiKey = env('TOMTOM_API_KEY');
            $addressQuery = str_replace(' ', '+', $request['address']);

            $coordinate = "https://api.tomtom.com/search/2/geocode/{$addressQuery}.json?key={$apiKey}";
            $json = file_get_contents($coordinate);
            $obj = json_decode($json);

            $lat = $obj->results[0]->position->lat;
            $lon = $obj->results[0]->position->lon;

            $query->whereRaw('ST_Distance( POINT(apartments.longitude, apartments.latitude),POINT(' . $lon . ',' . $lat . ')) < ' . $request['range'] / 100);
        }
        
        $apartments = $query->with('user', 'services', 'sponsors')->get()->toArray();

        $sponsoredApartment = [];
        
        foreach ($apartments as $index => $apartment) {
            if ($apartment['sponsors'] != []) {
                unset($apartments[$index]);
                array_push($sponsoredApartment, $apartment);
            }
        }

        foreach($sponsoredApartment as $sa) {
            array_unshift($apartments, $sa);
        }
        
        return response()->json([
            "success" => true,
            "results" => $apartments,
        ]);
    }

    public function services(){
        $services = Service::all();
        return response()->json([
            "success" => true,
            "results" => $services,
        ]);

    }
}

