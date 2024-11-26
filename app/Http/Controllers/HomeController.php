<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index_admin(){
        return view('admin.dashboard');
    }
    public function index_librarian(){
        return view('librarian.dashboard');
    }
}
