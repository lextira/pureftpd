<?php

namespace App\Http\Controllers;

use App\Features\ListDomainsFeature;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->serve(ListDomainsFeature::class);
    }
}
