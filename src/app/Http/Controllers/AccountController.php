<?php

namespace App\Http\Controllers;

use App\Features\CreateAccountFeature;
use App\Features\DeleteAccountFeature;
use App\Features\ListAccountsFeature;
use App\Features\ShowAccountFeature;
use App\Features\UpdateAccountFeature;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->serve(ListAccountsFeature::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return $this->serve(CreateAccountFeature::class);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return $this->serve(ShowAccountFeature::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        return $this->serve(UpdateAccountFeature::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return $this->serve(DeleteAccountFeature::class);
    }
}
