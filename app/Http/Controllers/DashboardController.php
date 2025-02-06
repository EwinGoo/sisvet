<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $this->title = 'Panel Principal';
        $this->page = 'dashboard';
        $this->pageURL = 'dashboard';
        $this->area = 'Dashboard';
        return $this->render('dashboard');
    }
}
