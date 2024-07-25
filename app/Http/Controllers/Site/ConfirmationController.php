<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class ConfirmationController extends Controller
{
  /**
   * Display a listing of the resource
   *
   * @return \Illuminate\Http\Response
   **/

  public function index()
  {
    //dd("test");
    return view("site.thankyou");
  }
}
