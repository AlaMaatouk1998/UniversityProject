<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialite;
use Exception;
use Log;
use Illuminate\Validation\Rule;
class SpecialiteController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'specialite.titre' => [
                'required', 
            ],
            'specialite.diplome_id' => 'required',
            'specialite.mention_id' => 'required'
        ]);
        try
        {
            $specialite = Specialite::create(
                (array) $request->specialite
            );
            Log::info('Spécialité crée!');
        }
        catch(Exception $e)
        {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
        return response()
            ->json('Nouvelle Spécialité ajouté!', 200);
    }
    public function get(Request $request){
        $specialites = Specialite::where('is_active', true);
    
        if ($request->has('is_active')) {
            $specialites = Specialite::where('is_active', $request->is_active);
        }
        
        
        if ($request->has('diplome')) {
            $specialites->where('diplome_id', $request->diplome);
        }  
        if ($request->has('mention')) {
            $specialites->where('mention_id', $request->mention);
        }  

        if ($request->has('etablissement')) {
            $specialites->whereHas('etablissements', function ($query) use($request){
                return $query->where('etablissements.id', $request->etablissement);
            });
        }
        if ($request->has('not_affected')) {
            $specialites->whereDoesntHave('etablissements', function ($query) use($request){
                $query->where('etablissements.id', $request->not_affected);
            });
        }
        
        if ($request->has('universite')) {
            $specialites->where('universite_id', $request->universite);
        }  
        
    
        return response()
               ->json($specialites->get()->load('diplome', 'mention', 'mention.domaine'), 200);
    }
    public function delete(Request $request, Specialite $specialite){
        if($specialite->id){
            try {
                $specialite->is_active = false;
                $specialite->save();
                return response()
                ->json('Specialite supprimée', 200);
                Log::info('Specialite supprimée!');
            } catch (Exception $th) {
                Log::error($e);
                return response()->json('Une erreur est survenue', 500);
            }
    
        }
        return response()
        ->json('Etablissment non trouvée', 404);
    }
    public function update(Request $request, Specialite $specialite){
        $validatedData = $request->validate([
            'specialite.titre' => 'required|max:255'
        ]);
    
        if(!$specialite->id)
             return response()->json('Specialite non trouvé', 404);
    
       //informations de base
        try {
            $specialite->update(
                (array) $request->specialite
            );
            Log::info('Specialite modifée');
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
    
    }
}
