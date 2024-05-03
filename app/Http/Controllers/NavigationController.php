<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function showMenu()
    {
        // Define the menu structure in PHP
        $menuStructure = [
            'Home',
            'Kategorien',
            'Verkaufen',
            'Unternehmen' => [
                'Philosophie',
                'Karriere'
            ]
        ];
        return view('home', ['menuStructure' => $menuStructure]);
    }

}

