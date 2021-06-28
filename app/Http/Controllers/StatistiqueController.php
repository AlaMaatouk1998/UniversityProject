<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Domaine;
use App\Etablissement;
class StatistiqueController extends Controller
{
    public function get(Request $request){

        $specialite_labels = array();
        $specialite_values = array();
        $data = Domaine::where('is_active', true)->withCount('specialites')->get();
        foreach ($data as $value) {
           array_push($specialite_labels, $value['titre']);
           array_push($specialite_values, $value['specialites_count']);
        }
        $nb_publique =Etablissement::where('is_active', true)->where('type', 'publique')->count();
        $nb_prive = Etablissement::where('is_active', true)->where('type', 'prive')->count();
        return response()->json(['specialite_labels' => $specialite_labels, 'specialite_values' => $specialite_values,
                                    'nb_publique' => $nb_publique, 'nb_prive' => $nb_prive 
                                ], 200);  
    }
}
