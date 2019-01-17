<?php

namespace App\Http\Controllers\Hom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('Hom/Index/index');
    }
}
