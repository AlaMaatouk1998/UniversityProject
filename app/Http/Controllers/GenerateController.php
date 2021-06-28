<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Exports\UniversiteExport;
use App\Exports\UniversiteExportCSV;
use Excel;

class GenerateController extends Controller
{
    public function pdf(Request $request){
        $universites = $request->universites;
        $filtres = $request->filtres;
        $pdf = PDF::loadView('generate.pdf', compact('universites', 'filtres'));
        $path='aa.pdf';
        $pdf->save($path);
        return response()->download($path);
    }
    public function excel(Request $request) 
    {
        return Excel::download(new UniversiteExport($request->universites), 'etablissements.xlsx');
    }
    public function csv(Request $request) 
    {
        return Excel::download(new UniversiteExportCSV($request->universites), 'etablissements.csv');
    }
}
