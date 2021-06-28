<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Universite;
use App\Etablissement;
use App\Mention;
use App\Domaine;
use App\Diplome;
use App\Specialite;
use App\Adresse;
use Exception;
use Log;
use Illuminate\Validation\Rule;
class UniversiteController extends Controller {
    public function create(Request $request) {


          $validatedData = $request->validate([
            'universite.titre' => [
                'required', 
                Rule::unique('universites', 'titre')->where(function ($query) use ($request) {
                    return $query
                        ->whereTitre($request->universite['titre'])
                        ->whereIsActive(true);
                }),
            ],
            'adresse.gouvernorat' => 'required'
        ]);      
        // $validatedData = $request->validate(
        //         ['universite.titre' => 'required|unique:universites,titre|max:255', 
        //         'adresse.gouvernorat' => 'required' ]);

        try {
            $universite = Universite::create((array)$request->universite);
            $adresse = Adresse::create((array)$request->adresse);
            $gouvernorat_ar = '';
            switch ($request->adresse['gouvernorat']) {
                case 'Ariana':  $gouvernorat_ar = 'أريانة'; break; case 'Beja': $gouvernorat_ar = 'باجة'; break; case 'Ben Arous': $gouvernorat_ar = 'بن عروس'; break; case 'Bizerte': $gouvernorat_ar = 'بنزرت'; break; case 'Gabes': $gouvernorat_ar = 'قابس'; break; case 'Gafsa': $gouvernorat_ar = 'قفصة'; break; 
                case 'Jendouba': $gouvernorat_ar = 'جندوبة'; break; case 'Kairouan': $gouvernorat_ar = 'القيروان'; break; case 'Kasserine': $gouvernorat_ar = 'القصرين'; break; case 'Kebili': $gouvernorat_ar = 'قبلي'; break; case 'Le Kef': $gouvernorat_ar = 'الكاف'; break; case 'Mahdia': $gouvernorat_ar = 'المهدية'; break;
                case 'La Manouba': $gouvernorat_ar = 'منوبة'; break; case 'Medenine': $gouvernorat_ar = 'مدنين'; break; case 'Monastir': $gouvernorat_ar = 'المنستير'; break; case 'Nabeul': $gouvernorat_ar = 'نابل'; break; case 'Sfax': $gouvernorat_ar = 'صفاقس'; break; case 'Sidi Bouzid': $gouvernorat_ar = 'سيدي بوزيد'; break;
                case 'Siliana': $gouvernorat_ar = 'سليانة'; break; case 'Sousse': $gouvernorat_ar = 'سوسة'; break; case 'Tataouine': $gouvernorat_ar = 'تطاوين'; break; case 'Tozeur': $gouvernorat_ar = 'توزر'; break; case 'Tunis': $gouvernorat_ar = 'تونس'; break; case 'Zaghouan': $gouvernorat_ar = 'زغوان'; break;
                default:
                    $gouvernorat_ar = 'أريانة'; break;
            }
            $adresse->gouvernorat_ar = $gouvernorat_ar;
            $adresse->save();
            $universite->adresse_id = $adresse->id;
            $universite->save();
            Log::info('Université crée!');
        }
        catch(Exception $e) {
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
        return response()->json('Nouvelle université ajoutée!', 200);
    }
    public function get(Request $request) {
        $universites = Universite::where('is_active', true);
        if ($request->has('is_active')) {
            $universites = Universite::where('is_active', $request->is_active);
        }

        if ($request->has('universite')) {
            $universites->where('id', $request->universite);
        }

        if ($request->has('gouvernorat')) {
            $universites->whereHas('adresse', function ($query) use ($request) {
                return $query->where('gouvernorat', $request->gouvernorat);
            });
        }

        if ($request->has('type')) {
            $universites->where('type', $request->type);
        }

        // $universites->whereHas('etablissements', function ($q) {
        //     return $q->where('etablissements.is_active', true);
        // });

        if ($request->has('etablissement')) {
            $SpecificID = $request->etablissement;
            $universites->whereHas('etablissements', function ($q) use ($SpecificID) {
                return $q->where('etablissements.id', $SpecificID);
            });
            $universites->with(['etablissements.specialites.mention.domaine','etablissements.specialites.diplome', 'etablissements' => function ($query) use ($SpecificID) {
            
                    return $query->where('etablissements.id', $SpecificID);
              
            }]);
            // $universites->with(['etablissements.specialites.mention.domaine', 'etablissements' => function ($query) use ($SpecificID) {
            //     $query->whereHas('specialites', function ($q) use ($SpecificID) {
            //         return $q->where('specialites.id', $SpecificID);
            //     });
            // }]);
            
        }

        
        if ($request->has('specialite')) {
            $SpecificID = $request->specialite;
            $universites->whereHas('etablissements.specialites', function ($q) use ($SpecificID) {
                return $q->where('specialites.id', $SpecificID);
            });
            $universites->with(['etablissements.specialites.mention.domaine','etablissements.specialites.diplome', 'etablissements.specialites' => function ($query) use ($SpecificID) {
            
                    return $query->where('specialites.id', $SpecificID);
              
            }]);
            // $universites->with(['etablissements.specialites.mention.domaine', 'etablissements' => function ($query) use ($SpecificID) {
            //     $query->whereHas('specialites', function ($q) use ($SpecificID) {
            //         return $q->where('specialites.id', $SpecificID);
            //     });
            // }]);
            
        }

        if ($request->has('diplome')) {
            $SpecificID = $request->diplome;
            $universites->whereHas('etablissements.specialites.diplome', function ($q) use ($SpecificID) {
                return $q->where('diplomes.id', $SpecificID);
            });
            $universites->with(['etablissements.specialites.mention.domaine','etablissements.specialites' => function ($query) use ($SpecificID) {
                $query->whereHas('diplome', function ($q) use ($SpecificID) {
                    return $q->where('diplomes.id', $SpecificID);
                });
            }
            ])->with(['etablissements' => function ($query) use ($SpecificID) {
                $query->whereHas('specialites.diplome', function ($q) use ($SpecificID) {
                    return $q->where('diplomes.id', $SpecificID);
                });
            }
            ]);
        }

        if ($request->has('formation') || $request->has('mention') || $request->has('diplome')) {
            $SpecificID = $request->formation;
            $universites->whereHas('etablissements.specialites.mention.domaine', function ($q) use ($SpecificID, $request) {
                if ($request->has('formation')) $q->where('domaines.id', $SpecificID);
                if ($request->has('mention')) $q->where('mentions.id', $request->mention);
            });
            $universites->with(['etablissements.specialites.diplome', 'etablissements.specialites.mention' => function ($query) use ($SpecificID, $request) {
                $query->whereHas('domaine', function ($q) use ($SpecificID, $request) {
                    if ($request->has('formation')) $q->where('domaines.id', $SpecificID);
                    if ($request->has('mention')) $q->where('mentions.id', $request->mention);
                });
            }
            ])->with(['etablissements.specialites' => function ($query) use ($SpecificID, $request) {
                $query->whereHas('mention.domaine', function ($q) use ($SpecificID, $request) {
                    if ($request->has('formation')) $q->where('domaines.id', $SpecificID);
                    if ($request->has('mention')) $q->where('mentions.id', $request->mention);
                });
                $query->whereHas('diplome', function ($q) use ($SpecificID, $request) {
                    if ($request->has('diplome')) return $q->where('diplomes.id', $request->diplome);
                });
            
                    if ($request->has('specialite')) return  $query->where('specialites.id', $request->specialite);
 
            }
            ])->with(['etablissements' => function ($query) use ($SpecificID, $request) {
                $query->whereHas('specialites.mention.domaine', function ($q) use ($SpecificID, $request) {
                    if ($request->has('formation')) $q->where('domaines.id', $SpecificID);
                    if ($request->has('mention')) $q->where('mentions.id', $request->mention);
                });
                $query->whereHas('specialites.diplome', function ($q) use ($SpecificID, $request) {
                    if ($request->has('diplome')) return  $q->where('diplomes.id', $request->diplome);
                });
                $query->whereHas('specialites', function ($q) use ($SpecificID, $request) {
                    if ($request->has('specialite')) return  $q->where('specialites.id', $request->specialite);
                });
                if ($request->has('etablissement')) 
                       $query->where('etablissements.id', $request->etablissement);
                
                $query->where('etablissements.is_active', true);       
                // if ($request->has('diplome'))
                // $universites->with(['etablissements.specialites.diplome' => function ($query) use ($SpecificID, $request) {
                //      $q->where('diplome.id', $request->diplome);
                // }]);
            }
            ]);
            // $universites->whereHas('etablissements.specialites.mention.domaine', function($q) use($SpecificID) {
            //                    return $q->where('domaines.id', $SpecificID);
            // });
            
        }
        if($request->has('etablissement') || $request->has('specialite') || $request->has('formation') || $request->has('mention') ||$request->has('diplome'))
                 return response()->json($universites->get(), 200);
        return response()->json($universites->get()->load('adresse', 'etablissements', 'etablissements.specialites', 'etablissements.specialites.mention', 'etablissements.specialites.diplome', 'etablissements.specialites.mention.domaine'), 200);
    }
    public function delete(Request $request, Universite $universite) {
        if ($universite->id) {
            try {
                $universite->is_active = false;
                $universite->save();
                return response()->json('Université supprimée', 200);
                Log::info('Université supprimée!');
            }
            catch(Exception $th) {
                Log::error($e);
                return response()->json('Une erreur est survenue', 500);
            }
        }
        return response()->json('Université non trouvée', 404);
    }
    public function update(Request $request, Universite $universite) {
        $validatedData = $request->validate(['universite*.titre' => 'required|max:255', 'adresse*.gouvernorat' => 'required', ]);
        if (!$universite->id) return response()->json('Université non trouvé', 404);
        //informations de base
        try {
            $universite->update((array)$request->universite);
            $adresse = null;
            if ($universite->adresse_id) $adresse = Adresse::find($universite->adresse_id);
            if ($adresse) {
                $adresse->gouvernorat = $request->adresse['gouvernorat'];
                $adresse->save();
            } else {
                $adresse = Adresse::create((array)$request->adresse);
                $universite->adresse_id = $adresse->id;
                $universite->save();
            }
            Log::info('Université modifée');
        }
        catch(Exception $e) {
            dd($e);
            Log::error($e);
            return response()->json('Une erreur est survenue', 500);
        }
    }
    // public function truncateAll(){
    //      Universite::truncate();
    //      Etablissement::truncate();
    //      Mention::truncate();
    //      Domaine::truncate();
    //      Diplome::truncate();
    //      Specialite::truncate();
    //      Adresse::truncate();
    // }
}
