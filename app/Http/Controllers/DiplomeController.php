<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diplome;
use Exception;
use Log;
use Illuminate\Validation\Rule;
class DiplomeController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'diplome.titre' => [
                'required', 
                Rule::unique('diplomes', 'titre')->where(function ($query) use ($request) {
                    return $query
                        ->whereTitre($request->diplome['titre'])
                        ->whereIsActive(true);
                }),
            ],
        ]);
        try
        {
            $Diplome = Diplome::create(
                (array) $request->diplome
            );
            Log::info('Diplome crée!');
        }
        catch(Exception $e)
        {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
        return response()
            ->json('Nouveau diplome ajoutée!', 200);
    }
    public function get(Request $request){
        $diplomes = Diplome::where('is_active', true);
    
        if ($request->has('is_active')) {
            $diplomes = Diplome::where('is_active', $request->is_active);
        }
        if ($request->has('gouvernorat')) {
            $diplomes->whereHas('adresse', function ($query) use($request){
                return $query->where('gouvernorat', $request->gouvernorat);
            });
        }
        if ($request->has('universite')) {
            $diplomes->where('universite_id', $request->universite);
        }  
        
    
        return response()
               ->json($diplomes->get(), 200);
    }
    public function delete(Request $request, Diplome $diplome){
        if($diplome->id){
            try {
                $diplome->is_active = false;
                $diplome->save();
                return response()
                ->json('Diplome supprimé', 200);
                Log::info('Diplome supprimée!');
            } catch (Exception $th) {
                Log::error($e);
                return response()->json('Une erreur est survenue', 500);
            }
    
        }
        return response()
        ->json('Etablissment non trouvée', 404);
    }
    public function update(Request $request, Diplome $diplome){
        $validatedData = $request->validate([
            'diplome.titre' => 'required|max:255'
        ]);
    
        if(!$diplome->id)
             return response()->json('Diplome non trouvé', 404);
    
       //informations de base
        try {
            $diplome->update(
                (array) $request->diplome
            );
            Log::info('Diplome modifée');
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
    }
}
