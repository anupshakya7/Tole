<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class ActivitylogController extends BaseController
{
	public function index()
	{
		$activity = ActivityLog::latest()->get();
		$this->setPageTitle('Orders', 'List of all orders'); 
		dd($activity);
	}
}