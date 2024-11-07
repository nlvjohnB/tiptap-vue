<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TipTapController extends Controller
{
    public function index()
    {
        return Inertia::render('TipTap/DragAndDrop/Index');
    }
}
