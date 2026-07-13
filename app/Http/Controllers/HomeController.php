<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Doctor;
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
        $doctors = Doctor::with('user')->paginate(4);
        return view('book-appointment', compact('doctors'));
    }

    public function doctors()
    {
        $doctors = Doctor::with('user')->paginate(6);
        return view('doctors', compact('doctors'));
    }

    public function blog()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(10);

        return view('blog', [
            'blogs' => $blogs,
        ]);
    }

    public function showBlog(Blog $blog)
    {
        return view('blog-show', [
            'blog' => $blog,
        ]);
    }
}
