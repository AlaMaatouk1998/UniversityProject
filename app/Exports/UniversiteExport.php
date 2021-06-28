<?php

namespace App\Exports;

use App\Universite;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UniversiteExport implements FromView
{
    protected $universites;
    function __construct($universites) {
        $this->universites = $universites;
    }
    public function view(): View
    {
        return view('generate.excel', [
            'universites' => $this->universites
        ]);
    }
}
