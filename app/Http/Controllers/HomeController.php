<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }

    public function BookAppointment()
    {
        return view('book-appointment');
    }

    public function doctors()
    {
        return view('doctors');
    }

    public function blog()
    {
        return view('blog');
    }
    
    
}
