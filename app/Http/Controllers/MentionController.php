<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mention;
use Exception;
use Log;
use Illuminate\Validation\Rule;
class MentionController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'mention.titre' => [
                'required', 
                Rule::unique('mentions', 'titre')->where(function ($query) use ($request) {
                    return $query
                        ->whereTitre($request->mention['titre'])
                        ->whereIsActive(true);
                }),
            ],
            'mention.domaine_id' => 'required'
        ]);
        try
        {
            $mention = Mention::create(
                (array) $request->mention
            );
            Log::info('Spécialité crée!');
        }
        catch(Exception $e)
        {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
        return response()
            ->json('Nouvelle Mention ajouté!', 200);
    }
    public function get(Request $request){
        $mentions = Mention::where('is_active', true);
    
        if ($request->has('is_active')) {
            $mentions = Mention::where('is_active', $request->is_active);
        }
        if ($request->has('gouvernorat')) {
            $mentions->whereHas('adresse', function ($query) use($request){
                return $query->where('gouvernorat', $request->gouvernorat);
            });
        }
        if ($request->has('universite')) {
            $mentions->where('universite_id', $request->universite);
        }  
        
    
        return response()
               ->json($mentions->get()->load('domaine'), 200);
    }
    public function delete(Request $request, Mention $mention){
        if($mention->id){
            try {
                $mention->is_active = false;
                $mention->save();
                return response()
                ->json('Mention supprimée', 200);
                Log::info('Mention supprimée!');
            } catch (Exception $th) {
                Log::error($e);
                return response()->json('Une erreur est survenue', 500);
            }
    
        }
        return response()
        ->json('Etablissment non trouvée', 404);
    }
    public function update(Request $request, Mention $mention){
        $validatedData = $request->validate([
            'mention*.titre' => 'required|max:255'
        ]);
    
        if(!$mention->id)
             return response()->json('Mention non trouvé', 404);
    
       //informations de base
        try {
            $mention->update(
                (array) $request->mention
            );
            Log::info('Mention modifée');
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
    
    }
}
