<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Apartment;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request, Apartment $apartment){
        
        $data = $request->all();
        $data['apartment_id'] = $apartment->id;

        $validator = Validator::make($data, [
            'name' => 'required',
            'surname' => 'required',
            'email' => ['required', 'email'],
            'message' => 'required',
            'date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }

        $newLead = new Lead();
        $newLead->apartment_id = $data['apartment_id'];
        $newLead = $newLead->create($data);
        
        // dd(new NewContact($newLead));

        // # Invio la mail
        Mail::to("admin@boolbnb.com")->send(new NewContact($newLead));

        return response()->json([
            'success' => true,
        ]);
    }
}
