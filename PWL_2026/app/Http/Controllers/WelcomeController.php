<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello()
    {
        return ('hello world');
    }
    public function greeting()
    {
        return view('blog.hello')
        ->with('name', 'Muhammad Daniel Assaqovi')
        ->with('occupation', 'entrepreneur');
    }
}
