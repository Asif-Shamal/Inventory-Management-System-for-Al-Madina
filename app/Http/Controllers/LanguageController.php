<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        session()->put('locale', $lang);
        
        // Store direction of language
        $direction = $lang === 'fa' ? 'rtl' : 'ltr';
        session()->put('direction', $direction);

        return redirect()->back();
    }
}

