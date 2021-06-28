<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Universite;
use App\Etablissement;
use App\Domaine;
use App\Specialite;
use App\Diplome;
use App\Mention;
use App;
class RoutingController extends Controller
{

    public function testPDFhome(Request $request){
        $universites = Universite::where('is_active', true)->get()->load('etablissements.specialites.mention', 'etablissements.specialites.diplome');
        return view('generate.pdf', compact('universites')); 

    }
    public function home(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);

        $nb_etablissement = Etablissement::where('is_active', true)->count();
        $nb_universite = Universite::where('is_active', true)->count();
        $nb_specialite = Specialite::where('is_active', true)->count();

        $global_formations = Domaine::where('is_active', true)->get();

        $specialites = array();
        $collection = Specialite::where('is_active', true)->pluck('titre');
        if (!$collection->isEmpty()) {
            $nbToShow = 4;
            if(count($collection) < 4)
                $nbToShow = count($collection);
            $specialites = Specialite::where('is_active', true)->get()->random($nbToShow)->load('mention.domaine', 'diplome', 'etablissements.universite');
        }

        $gouvernorats = [ "Ariana", "Beja", "Ben Arous", "Bizerte", "Gabes", "Gafsa", "Jendouba", "Kairouan", "Kasserine", "Kebili", "Le Kef", "Mahdia", "La Manouba", "Medenine", "Monastir", "Nabeul", "Sfax", "Sidi Bouzid","Siliana", "Sousse", "Tataouine","Tozeur", "Tunis", "Zaghouan"];
       
        return view('home', compact('nb_etablissement', 'nb_universite', 'nb_specialite', 'global_formations', 'specialites', 'gouvernorats', 'locale')); 



    }
    public function formation(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);
            return back()->with('error', 'Aucune formation est spécifiée');

        $formation = Domaine::find($request->domaine);
        if (!$formation)
            return back()->with('error', 'Formation non trouvée');

        // Diplomes associés à un domaine donné
        $diplomes = DB::table('domaines')
                        ->where('domaines.id', $request->domaine)
                        ->join('mentions', 'domaines.id', '=', 'mentions.domaine_id')
                        ->join('specialites', 'mentions.id', '=', 'specialites.mention_id')
                        ->join('diplomes', 'diplomes.id', '=', 'specialites.diplome_id')
                        ->select('diplomes.*')
                        ->distinct()
                        ->get();
        // Etablissements | Universite associées à un domaine donné
        $query = DB::table('domaines')
                    ->where('domaines.id', $request->domaine)
                    ->join('mentions', 'domaines.id', '=', 'mentions.domaine_id')
                    ->join('specialites', 'mentions.id', '=', 'specialites.mention_id')
                    ->join('etablissement_specialite', 'etablissement_specialite.specialite_id', '=', 'specialites.id')
                    ->join('etablissements', 'etablissement_specialite.etablissement_id', '=', 'etablissements.id');
        $etablissements = $query->select('etablissements.*')
                                ->distinct()
                                ->get();
        // Universites associées à un domaine donné
        $universites = $query->join('universites', 'etablissements.universite_id', '=', 'universites.id')
                                ->select('universites.*')
                                ->distinct()
                                ->get();

        
        $global_formations = Domaine::where('is_active', true)->get();
        return view('details.formation', compact('global_formations', 'formation', 'diplomes', 'etablissements', 'universites', 'locale'));
        
    }
    public function universite(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);

        if (!$request->has('type'))
        return back()->with('error', 'Aucun type est spécifié');

        $type = $request->type;
        if ($type != 'prive' && $type != 'publique')
            return back()->with('error', 'Type invalide');

        $universites = Universite::where('is_active', true);

        if ($request->has('gouvernorat')) {
            $universites->whereHas('adresse', function ($query) use ($request) {
                return $query->where('gouvernorat', $request->gouvernorat);
            });
        }
        if ($request->has('type')) {
            $universites->where('type', $request->type);
        }
        $universites = $universites->withCount(['etablissements' => function ($query) {
            $query->where('etablissements.is_active', true);
             }])->get();

        // Formations associés à les universités
        $query = DB::table('universites')
                    ->where('universites.type', $type)
                    ->join('etablissements', 'universites.id', '=', 'etablissements.universite_id')
                    ->join('etablissement_specialite', 'etablissement_specialite.etablissement_id', '=', 'etablissements.id')
                    ->join('specialites', 'etablissement_specialite.specialite_id', '=', 'specialites.id');

        $formations =   $query->join('mentions', 'mentions.id', '=', 'specialites.mention_id')
                        ->join('domaines', 'domaines.id', '=', 'mentions.domaine_id')
                        ->select('domaines.*')
                        ->distinct()
                        ->get();

        $diplomes = $query->join('diplomes', 'diplomes.id', '=', 'specialites.diplome_id')
                        ->select('diplomes.*')
                        ->distinct()
                        ->get();

        $type_ref = $type;
        $type = $type == 'prive' ? 'privées' : 'publiques'; 
        $global_formations = Domaine::where('is_active', true)->get();
        return view('pages.universite', compact('global_formations', 'formations', 'diplomes', 'universites', 'type', 'type_ref', 'locale'));


    }
    public function etablissement(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);

        if (!$request->has('universite'))
           return view('details.etablissements', compact('locale'));

        $universite = $request->universite;
        $univ = Universite::find($universite);
        if(!$univ)
            return back()->with('error', 'Université non trouvée');

        $etablissements = Etablissement::where('is_active', true);


        if ($request->has('universite')) {
            $etablissements->where('universite_id', $universite);
        }
        $etablissements = $etablissements->withCount(['specialites' => function ($query) {
            $query->where('specialites.is_active', true);
             }])->get();

        // Formations associés à les universités
        $query = DB::table('etablissements')
                    ->where('etablissements.universite_id', $universite)
                    ->join('etablissement_specialite', 'etablissement_specialite.etablissement_id', '=', 'etablissements.id')
                    ->join('specialites', 'etablissement_specialite.specialite_id', '=', 'specialites.id');

        $specialites = $query->select('specialites.*')
                        ->distinct()
                        ->get();

        $formations =   $query->join('mentions', 'mentions.id', '=', 'specialites.mention_id')
                        ->join('domaines', 'domaines.id', '=', 'mentions.domaine_id')
                        ->select('domaines.*')
                        ->distinct()
                        ->get();

        $diplomes = $query->join('diplomes', 'diplomes.id', '=', 'specialites.diplome_id')
                        ->select('diplomes.*')
                        ->distinct()
                        ->get();

     
        $type = 'publiques';
        $type = $univ->type == 'prive' ? 'privées' : 'publiques';   
        $type_ref = $univ->type;
        $global_formations = Domaine::where('is_active', true)->get();
        return view('pages.etablissement', compact('global_formations', 'formations', 'diplomes', 'etablissements', 'specialites', 'type', 'univ', 'type_ref', 'locale'));        
    }
    public function statistique(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);

        $nb_etablissement_publique = Etablissement::where('is_active', true)->where('type', 'publique')->count();
        $nb_etablissement_prive = Etablissement::where('is_active', true)->where('type', 'prive')->count();
        $nb_diplomes = Diplome::where('is_active', true)->count();
        $nb_mentions = Mention::where('is_active', true)->count();
        $nb_domaines = Domaine::where('is_active', true)->count();

        return view('pages.statistique', compact('nb_etablissement_publique', 'nb_etablissement_prive', 'nb_diplomes', 'nb_mentions', 'nb_domaines', 'locale')); 
    }
    public function contact(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);

        $global_formations = Domaine::where('is_active', true)->get();

        return view('pages.contact', compact('global_formations', 'locale')); 
    }

    public function pageFormation(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);
   
        $formations = Domaine::where('is_active', true)->get();
        $diplomes = Diplome::where('is_active', true)->get();
        return view('details.formation', compact('formations', 'diplomes', 'locale'));
        
    }
    public function pageEtablissement(Request $request, $locale = null){
        if(!$locale)
            $locale = App::getLocale() ? App::getLocale() : 'fr';
        else
            App::setLocale($locale);

            return view('details.etablissements', compact('locale'));
        
    }
}

