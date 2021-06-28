<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domaine;
use Exception;
use Log;
use Illuminate\Validation\Rule;
class DomaineController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'domaine.titre' => [
                'required', 
                Rule::unique('domaines', 'titre')->where(function ($query) use ($request) {
                    return $query
                        ->whereTitre($request->domaine['titre'])
                        ->whereIsActive(true);
                }),
            ],
        ]);
        try
        {
            $domaine = Domaine::create(
                (array) $request->domaine
            );
            Log::info('Domaine crée!');
            return response()
            ->json('Nouveau domaine ajouté!', 200);
        }
        catch(Exception $e)
        {   
            dd($e);
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }

    }
    public function get(Request $request){
        $domaines = Domaine::where('is_active', true);
    
        if ($request->has('is_active')) {
            $domaines = Domaine::where('is_active', $request->is_active);
        }
        if ($request->has('gouvernorat')) {
            $domaines->whereHas('adresse', function ($query) use($request){
                return $query->where('gouvernorat', $request->gouvernorat);
            });
        }
        if ($request->has('universite')) {
            $domaines->where('universite_id', $request->universite);
        }  
                // Diplomes associés à un domaine donné
        // $diplomes = DB::table('domaines')
        //     ->where('domaines.id', 4)
        //     ->join('mentions', 'domaines.id', '=', 'mentions.domaine_id')
        //     ->join('specialites', 'mentions.id', '=', 'specialites.mention_id')
        //     ->join('diplomes', 'diplomes.id', '=', 'specialites.diplome_id')
        //     ->select('diplomes.*')
        //     ->distinct()
        //     ->get();

        // Etablissements associées à un domaine donné
        // $diplomes = DB::table('domaines')
        // ->where('domaines.id', 2)
        // ->join('mentions', 'domaines.id', '=', 'mentions.domaine_id')
        // ->join('specialites', 'mentions.id', '=', 'specialites.mention_id')
        // ->join('etablissement_specialite', 'etablissement_specialite.specialite_id', '=', 'specialites.id')
        // ->join('etablissements', 'etablissement_specialite.etablissement_id', '=', 'etablissements.id')
        // ->select('etablissements.*')
        // ->distinct()
        // ->get();

        // Universites associées à un domaine donné
        // $diplomes = DB::table('domaines')
        // ->where('domaines.id', 3)
        // ->join('mentions', 'domaines.id', '=', 'mentions.domaine_id')
        // ->join('specialites', 'mentions.id', '=', 'specialites.mention_id')
        // ->join('etablissement_specialite', 'etablissement_specialite.specialite_id', '=', 'specialites.id')
        // ->join('etablissements', 'etablissement_specialite.etablissement_id', '=', 'etablissements.id')
        // ->join('universites', 'etablissements.universite_id', '=', 'universites.id')
        // ->select('universites.*')
        // ->distinct()
        // ->get();
    
    
        return response()
               ->json($domaines->get(), 200);
    }
    public function delete(Request $request, Domaine $domaine){
        if($domaine->id){
            try {
                $domaine->is_active = false;
                $domaine->save();
                return response()
                ->json('Domaine supprimé', 200);
                Log::info('Domaine supprimée!');
            } catch (Exception $th) {
                Log::error($e);
                return response()->json('Une erreur est survenue', 500);
            }
    
        }
        return response()
        ->json('Etablissment non trouvée', 404);
    }
    public function update(Request $request, Domaine $domaine){
        $validatedData = $request->validate([
            'domaine.titre' => 'required|max:255'
        ]);
    
        if(!$domaine->id)
             return response()->json('Domaine non trouvé', 404);
    
       //informations de base
        try {
            $domaine->update(
                (array) $request->domaine
            );
            Log::info('Domaine modifée');
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
    }
}
