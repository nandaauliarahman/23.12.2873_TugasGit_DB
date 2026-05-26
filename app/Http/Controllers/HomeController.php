<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Category;

class HomeController extends Controller
{
    function index()
    {
        $partners   = Partner::all();
        $categories = Category::all();

        return view('welcome', compact('partners', 'categories'));
    }
}