<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Adresse;
use App\Etablissement;
use App\Universite;

use Exception;
use Log;
use Illuminate\Validation\Rule;
class EtablissementController extends Controller
{
    public function create(Request $request)
    {


        $validatedData = $request->validate([
            'etablissement.type' => [
                'required',
                Rule::in(['prive', 'publique']),
            ],            
            'etablissement.titre' => [
                'required', 
                Rule::unique('etablissements', 'titre')->where(function ($query) use ($request) {
                    return $query
                        ->whereTitre($request->etablissement['titre'])
                        ->whereIsActive(true);
                }),
            ],
            'etablissement.universite_id' => [Rule::requiredIf(function () use ($request) {
                return $request->etablissement['type'] == 'publique';
            })],
            'adresse.gouvernorat' => 'required',
        ]);
        try
        {   
            $etablissement = Etablissement::create(
                (array) $request->etablissement
            );
            $adresse = Adresse::create(
                (array) $request->adresse
            );
            $etablissement->adresse_id = $adresse->id;
            if($request->etablissement['type'] == 'prive'){
                $universite = new Universite();
                $universite->titre = $request->etablissement['titre'];
                if(array_key_exists ('titre_ar', $request->etablissement))
                  $universite->titre_ar = $request->etablissement['titre_ar'];
                if(array_key_exists ('telephone', $request->etablissement))
                  $universite->telephone = $request->etablissement['telephone'];
                if(array_key_exists ('fax', $request->etablissement))
                  $universite->fax = $request->etablissement['fax'];   
                if(array_key_exists ('url', $request->etablissement))
                  $universite->url = $request->etablissement['url'];  
                if(array_key_exists ('presentation', $request->etablissement))
                  $universite->presentation = $request->etablissement['presentation'];  
                $universite->type = 'prive';
                $universite->save();
                $etablissement->universite_id = $universite->id;
                $etablissement->save();
            }
            $etablissement->save();
            Log::info('Etablissement crée!');
            return response()
            ->json('Nouvelle etablissement ajoutée!', 200);
        }
        catch(Exception $e)
        {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }

    }
    public function getOne(Request $request, Etablissement $etablissement){
        if($etablissement->id)
            return response()
            ->json($etablissement, 200);
         return response()
            ->json('Etablissement non trouvé', 404);   
    }

    public function get(Request $request){
        $etablissements = Etablissement::where('is_active', true);
    
        if ($request->has('is_active')) {
            $etablissements = Etablissement::where('is_active', $request->is_active);
        }
        if ($request->has('gouvernorat')) {
            $etablissements->whereHas('adresse', function ($query) use($request){
                return $query->where('gouvernorat', $request->gouvernorat);
            });
        }
        if ($request->has('universite')) {
            $etablissements->where('universite_id', $request->universite);
        }  
        return response()
               ->json($etablissements->get()->load('adresse', 'universite'), 200);
    }

    public function delete(Request $request, Etablissement $etablissement){
        if($etablissement->id){
            try {
                $etablissement->is_active = false;
                $etablissement->save();
                return response()
                ->json('Etablissment supprimée', 200);
                Log::info('Etablissment supprimée!');
            } catch (Exception $th) {
                Log::error($e);
                return response()->json('Une erreur est survenue', 500);
            }
        }
        return response()
        ->json('Etablissment non trouvée', 404);
    }

    public function update(Request $request, Etablissement $etablissement){
        $validatedData = $request->validate([
            'etablissement.titre' => 'required|max:255',
            'adresse.gouvernorat' => 'required',
        ]);
    
        if(!$etablissement->id)
             return response()->json('Etablissment non trouvé', 404);
    
       //informations de base
        try {
            $etablissement->update(
                (array) $request->etablissement
            );
            $adresse = null;
            if($etablissement->adresse_id)
                $adresse = Adresse::find($etablissement->adresse_id);
            if($adresse){
                $adresse->update(
                    (array) $request->adresse
                );
            }
            else{
                $adresse = Adresse::create(
                    (array) $request->adresse
                );
                $etablissement->adresse_id = $adresse->id;
                $etablissement->save();
            }
            Log::info('Etablissment modifée');
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
    }

    public function affectSpecialite(Request $request, Etablissement $etablissement){
        $validatedData = $request->validate([
            'nbr_orient' => 'numeric',
        ]);

        if(!$etablissement->id)
             return response()->json('Etablissment non trouvé', 404);

        try {
            $etablissement->specialites()->attach($request->specialite_id, ['habilitation_debut' => $request->habilitation_debut, 'habilitation_fin' => $request->habilitation_fin, 'code_dossier' => $request->code_dossier]);
            return response()->json('Spécialité affectée', 200);
        } catch (Exception $e) {
            dd($e);
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }    
    }

    public function desaffectSpecialite(Request $request, Etablissement $etablissement){
        if(!$etablissement->id)
             return response()->json('Etablissment non trouvé', 404);
        
        try {
            $etablissement->specialites()->detach($request->specialite_id);
            return response()->json('Spécialité désaffectée', 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }    
    }
}
