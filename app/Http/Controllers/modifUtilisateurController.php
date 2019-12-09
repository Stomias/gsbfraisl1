<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class modifUtilisateurController extends Controller
{
    public function voirDetailUtilisateur($id){
        $error= "";
        $gsbFrais = new GsbFrais();
        $detailsVisiteur = $gsbFrais->getInfosVisiteurID($id);
        $regions = $gsbFrais->getRegionSecteurVisiteurID($id);
        return view('formModifVisiteurDelegue', compact('detailsVisiteur','regions','error'));
    }
}
