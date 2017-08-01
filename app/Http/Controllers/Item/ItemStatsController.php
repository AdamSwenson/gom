<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemStatsController extends Controller
{

    public $student;
    public $exam;
    public $item;

    public function __construct()
    {
        $this->middleware('auth');
    }

}
