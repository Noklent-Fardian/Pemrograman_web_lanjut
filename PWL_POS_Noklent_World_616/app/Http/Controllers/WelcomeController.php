<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $breadcrumb = [
            'title' => 'Dashboard',
            'list' => ['Home','Welcome']
        ];
        $activeMenu = 'dashboard';
        return view('welcome', compact('breadcrumb','activeMenu'));
    }
    
}
