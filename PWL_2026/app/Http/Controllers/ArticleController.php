<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function articles($id) {
        return 'Halaman Artikel dengan ID '.$id;
    }
}
