<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator, Auth, Session, Hash;


class SaleEntryItemController extends Controller
{
    //
    public function __construct()
    {
         $this->middleware('auth');
    }
}
