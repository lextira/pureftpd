<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Lucid\Foundation\Http\Controller as LucidController;

class Controller extends LucidController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
