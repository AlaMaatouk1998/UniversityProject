<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\User;
use App\Don;
use App\Adresse;
use App\Gouvernorat;
use Carbon\Carbon;   
class DonController extends Controller
{
    public function deleteAll(Request $request){
        Don::truncate();
    }
    public function getLastWeekDons(Request $request){
        $array = array();
        $days = array();
        $dons = Don::get()->groupBy('gouvernorat');
            foreach($dons as $key => $don){
                array_push ( $array, $don->count());
                array_push ( $days, $key);
            }

         return response()->json([
             'data' => $array,
             'days' => $days
         ], 200);
    }
    public function getDons(Request $request)
    {
        //
        $dons = null;
        if ($request->gouvernorat)
        {
            $dons = Don::where('gouvernorat', $request->gouvernorat)
                ->get()->load('adresse', 'user');
            if($request->type){
                $dons = Don::where('gouvernorat', $request->gouvernorat)->where('type_action', $request->type)
                ->get()->load('adresse', 'user');
            }
        }else
        {
            $dons = Don::orderBy('id', 'DESC')->get()->load('adresse', 'user');
        }
        return response()->json($dons, 200);
    }
    public function getDon(Request $request, Don $don){
        if($don->id)
            return response()->json($don->load('adresse'), 200);
        return response()->json('Don non trouve!', 400);  
    }
    public function createDon(Request $request)
    {
        try
        {

            $adresse = new Adresse();
            $adresse->adresse = $request->adresse;
            $adresse->gouvernorat = $request->gouvernorat;
            $adresse->gouvernorat_id = 1; //Gouvernorat::where('nom', $request->gouvernorat)->first()->id;
            $adresse->save();

            $don = new Don();
            $don->nom = $request->nom;
            // $don->prenom = $request->prenom; // peut etre null
            $don->description = $request->description;
            $don->type_action = $request->type_action; // Si partenaire ou Association
            $don->motorise = $request->motorise; // Boolean True / False
            $don->accord_utss = true; //  Boolean True / False
            $don->adresse_id = $adresse->id;
            $don->gouvernorat = $request->gouvernorat;
            $don->telephone = $request->telephone;
            $don->type_don = $request->type_don;
            //Type_Don: un don en nourriture -> Acteur UTSS | Si un don en materiel - Ressources Humaines - > Acteur CRRC
            $don->etat = "Non traite";
            //Fetch de l'acteur acteur adequat
            $roleActeur = 1;
            // if ($request->type_don != "Nourriture")
            // {
            //     $roleActeur = 2;
            // }
            $acteurs = User::where('role', $roleActeur)->where('gouvernorat', $request->gouvernorat)->get()->load('adresse');
            // $acteurRetour = null;
            // if($acteur && $request->accord_utss){
            //     $don->user_id = $acteur->id;
            //     $acteurRetour = $acteur->load('adresse');
            // }else{
            //     $don->user_id = 1;
            // }

            $don->save();
            // if($request->accord_utss == true)
                return response()
                ->json(["acteurs" => $acteurs, "don" => $don->id], 200);
            // return response()
            // ->json('Don enregistre', 200);
        }
        catch(Exception $e)
        {
            return response()->json($e->getMessage() , 400);
        }
        return response()
            ->json('Nouveau don ajouté!', 200);
    }
    public function updateDon(Request $request, Don $don)
    {
        try
        {
            if ($don->id)
            {
                $don->update(['etat' => $request->etat]);
                return response()
                    ->json('Don modifié!', 200);
            }
            return response()
                ->json('Don introuvable', 400);
        }
        catch(Exception $e)
        {
            return response()->json($e->getMessage(), $e->getHttpStatus());
        }

    }
    public function deleteDon(Request $request, Don $don)
    {
        if ($don->id)
        {
            $don->delete();
            return response()
                ->json('Don supprimé!', 200);
        }
        return response()
            ->json('Don introuvable', 400);
    }

    public function setActeur(Request $request, Don $don)
    {
        if ($don)
        {
            $don->update(['user_id' => $request->acteurId]);
            return response()
                ->json('Don modifié!', 200);
        }
        return response()
            ->json('Don introuvable', 400);
    }
}

// Formulaire Don (Création){
//     nom
//     prenom
//     description
//     type_action (Si "partenaire" ou "association" )
//     motorise (Boolean)
//     accord_utss (Boolean)
//     municipalite (id de la municipalite)
// }