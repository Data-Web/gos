<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UnitsController extends Controller
{
    public function index()
    {
        return view('backend.unit.index');
    }
}
