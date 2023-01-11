<?php

namespace App\Http\Controllers;

use App\Temperature;
use Illuminate\Http\Request;
use Validator;
use Exception;

class TemperatureController extends Controller
{

    // Validation of information (Store) , unique time
    private function validatorStore(Request $request)
    {
         $rules = [
            'timee' => 'required|unique:Temperatures,time',
            'temperature' => 'required'
        ];
        $messages = array(
            'timee.required' => 'Le champ Temps est obligatoire.',
            'timee.unique' => 'Le champ Temps est déjà existe.',
            'temperature.required' => 'Le champ Temperature est obligatoire.',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        return $validator;
    }

    // Validation of information (Update) , unique time
    private function validatorUpdate(Request $request)
    {
         $rules = [
            'timee' => 'bail|required|unique:Temperatures,time,'.$request->id,
            'temperature' => 'required'
        ];
        $messages = array(
            'timee.required' => 'Le champ Temps est obligatoire.',
            'timee.unique' => 'Le champ Temps est déjà existe.',
            'temperature.required' => 'Le champ Temperature est obligatoire.',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        return $validator;
    }


    public function index()
    {
        //Display informations order by DESC
        $temperatures = Temperature::orderBy('id' , 'DESC')->get();
        return view('temperatures.index',[
            'temperatures' => $temperatures
        ]);
    }

    public function create()
    {
        return view('temperatures.create');
    }

    public function store(Request $request)
    {
        $validators = $this->validatorStore($request);  
        
        //Return validation errors
        if ($validators->fails()) {
            return response()->json(
                [
                    'errors' => $validators->errors()->all(),
                    'error'=>true
                ]
            );
        }

        try{
            //Store data
            $temperature = new Temperature();
            //Replace T to space for column datetime
            $temperature->time = str_replace('T', ' ', $request->timee);
            $temperature->temperature = $request->temperature;
            $temperature->save();

            return response()->json(
                [
                    'success' => true,
                ]
            );

        } catch (Exception $e) {
            // Return message if error in server
            return response()->json(
                [
                    'errors' => ['Erreur serveur, Merci de contacter l\'administrateur'],
                    'error' => 'error'
                ]
            );
        }
    }

    // public function edit(Temperature $Temperature)
    public function edit($id)
    {
        $temperature = Temperature::findOrFail($id);
        return view('temperatures.edit' , [
            'temperature' => $temperature
        ]);
    }

    public function update(Request $request)
    {
        $validators = $this->validatorUpdate($request);  
        
        //Return validation errors
        if ($validators->fails()) {
            return response()->json(
                [
                    'errors' => $validators->errors()->all(),
                    'error'=>true
                ]
            );
        }

        try{
            //Update Data
            $temperature = Temperature::findOrFail($request->id);
            //Replace T to space for column datetime
            $temperature->time = str_replace('T', ' ', $request->timee);
            $temperature->temperature = $request->temperature;
            $temperature->save();

            return response()->json(
                [
                    'success' => true,
                    
                ]
            );

        } catch (Exception $e) {
            // Return message if error in server
            return response()->json(
                [
                    'errors' => ['Erreur serveur, Merci de contacter l\'administrateur'],
                    'error' => 'error'
                ]
            );
        }
    }

    public function destroy($id)
    {
        try{
            //Delete temerature
            Temperature::find($id)->delete();

            $notification = array(
                'message' => 'Bien supprimé',
            );

            return redirect()->route('temperatures.index')->with($notification);
        } catch (Exception $e) {
            // Return message if error in server
            $notification = array(
                'message' => $e->getMessage(),
            );
            return redirect()->route('temperatures.index')->with($notification);
        }
    }
}
