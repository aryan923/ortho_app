<?php

namespace App\Http\Controllers;

use App\Models\Blog;
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
