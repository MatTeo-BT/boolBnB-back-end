<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Lead;
use App\Models\Service;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class MyApartmentController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => ['required', 'min:5', 'max:255', 'string'],
            'user_id' => ['exists:users,id'],
            'no_rooms' => ['required', 'min:1', 'max:100', 'integer'],
            'no_beds' => ['required', 'min:1', 'max:100', 'integer'],
            'no_bathrooms' => ['required', 'min:1', 'max:10', 'integer'],
            'square_meters' => ['nullable', 'min:10', 'max:10000', 'integer'],
            'address' => [
                'required', 'min:5', 'max:255', 'string',
                // function ($attribute, $value, $fail) {
                //     // Verifica se 'latitude' e 'longitude' sono presenti
                //     if (!request()->has('latitude') || !request()->has('longitude')) {
                //         $fail('The address entered is incorrect');
                //     }
                // },
            ],
            'img' => 'required', 'image', 'url',
            'visible' => ['boolean'],
            'latitude' => ['min:4', 'max:6', 'numeric'],
            'longitude' => [ 'min:4', 'max:6', 'numeric'],
            'price' => ['required', 'min:10', 'max:100000', 'numeric'],
            'description' => ['nullable', 'min:10', 'string'],
            'services' => ['exists:services,id'],
        ];
    }
    

    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::id())->with('leads')->get();

        // dd($apartments);
        return view('admin.apartments.my_apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Apartment $apartment)
    {
        $apartment = new Apartment();
        $services = Service::all();
        return view('admin.apartments.my_apartments.create', compact('apartment', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // dd($request->all());
        $data = $request->validate($this->rules);
        $data['user_id'] = Auth::id();
        $apartment = new Apartment();

        // $imageSrc = Storage::put('uploads/apartments', $data['img']);
        // $data['img'] = $imageSrc;
        $imageSrc = Storage::put('uploads/Apartments', $data['img']);             
        $imageUrl = Storage::url($imageSrc);             
        $data['img'] = $imageUrl;
        
        //CHIAMATA API TOMTOM PER OTTENERE LATITUDINE E LONGITUDINE
        $apiKey = env('TOMTOM_API_KEY');
        $addressQuery = str_replace(' ', '+', $data['address']);

        $coordinate = "https://api.tomtom.com/search/2/geocode/{$addressQuery}.json?key={$apiKey}";

        $json = file_get_contents($coordinate);
        $obj = json_decode($json);
        // dd($obj);
        if (count($obj->results) === 1) {
            $lat = $obj->results[0]->position->lat;
            $lon = $obj->results[0]->position->lon;
            $data['latitude'] = $lat;
            $data['longitude'] = $lon;
            $apartment = Apartment::create($data);
            $apartment->services()->sync($data['services']);
            return redirect()->route('admin.my_apartments.show', $apartment);
        } else {
            return redirect()->back()->withErrors(['address' => 'L\'indirizzo inserito non è valido']);
        }
        // $errors = 'Non hai selezionato un\'indirizzo valido!!!'; 
        // return redirect()->route('admin.my_apartments.create', $errors);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        
        $services = Service::all();
        $sponsors = Sponsor::all();
        return view('admin.apartments.my_apartments.show', compact('apartment', 'services', 'sponsors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment){

        $services = Service::all();
      
        return view('admin.apartments.my_apartments.edit', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment )
    {
        
        
        // $apartment->services()->sync($data['services']);

        // VALIDATE
        $data = $request->validate($this->rules);
        $data['user_id'] = Auth::id();
        // $apartment->services()->sync($data['services']);
        // condizione dell'immagine in cui:
        // se l'immagine che gli mandiamo inizia con 'http', allora fa l'update normale
        if (str_starts_with($data['img'], 'http')) {
            $apartment->img = $data['img'];
        } else { //invece se l'immagine è un file, allora usiamo storage
            $imageSrc = Storage::put('uploads/Apartments', $data['img']);             
            $imageUrl = Storage::url($imageSrc);             
            $data['img'] = $imageUrl;
        }
        
        //CHIAMATA API TOMTOM PER OTTENERE LATITUDINE E LONGITUDINE
        if($data['address'] != $apartment->address) {
            $apiKey = env('TOMTOM_API_KEY');
            $addressQuery = str_replace(' ', '+', $data['address']);

            $coordinate = "https://api.tomtom.com/search/2/geocode/{$addressQuery}.json?key={$apiKey}";

            $json = file_get_contents($coordinate);
            $obj = json_decode($json);
            $lat = $obj->results[0]->position->lat;
            $lon = $obj->results[0]->position->lon;

            $data['latitude'] = $lat;
            $data['longitude'] = $lon;
        }
        if (!isset($data['services'])){
            $data['services'] = [];
        }
        $apartment->services()->sync($data['services']);
        $apartment->update($data);
        return redirect()->route('admin.my_apartments.show', $apartment);
        // $request->validate($this->rules);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        
        $apartment->delete();
        
        return redirect()->route('admin.my_apartments.index');
    }

    /**
     * Show the list of soft deleted resources
     */
    public function deletedAparments() 
    {
        $apartments = Apartment::onlyTrashed()->get();
        
        return view('admin.my_apartments.deleted', compact('apartments'));
    }

    public function deletedShow(string $id){
        $apartment = Apartment::withTrashed()->where('id', $id)->first();
        return view('admin.apartments.my_apartments.deleted-show', compact('apartment'));
    }

    public function deletedRestore(string $id){
        $apartment = Apartment::withTrashed()->where('id', $id)->first();
        $apartment->restore();
        return redirect()->route('admin.apartments.my_apartments.show', $apartment);
    }

    public function syncSponsor(Apartment $apartment,  Request $request) {
        // dump($request->all());
        
        $data = $request->all();
        $apartment->sponsors()->sync($data['sponsors']);
        
        $services = Service::all();
        $sponsors = Sponsor::all();

        return redirect()->route('admin.my_apartments.show', $apartment);
    }
    // public function deletedDestroy(string $id){

    //     $apartment = Apartment::withTrashed()->where('id', $id)->first();

       
    //     $apartment->forceDelete () ;
    //     return redirect () ->route ('admin.apartment.deleted.index') ;    

    // }

    public function messages(Apartment $apartment){
        
        return view('admin.apartments.my_apartments.messages.message', compact('apartment'));

    }
}
