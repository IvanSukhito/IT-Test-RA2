<?php

namespace App\Http\Controllers\API;

use App\Models\ewallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EwalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function test()
    {
        //
        $user = Auth::user();

        $checkUser = checkUsers($user);

        $data = $user;

        $message = 'Success';

        return responseSuccess($message, $data);
    }

    public function create(){

        $user = Auth::user();

    // cek ewallet gw
        // kalau ga ada ewallet bikin
        // kalau ada ewalletnya ga usah dibikin



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ewallet $ewallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ewallet $ewallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ewallet $ewallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ewallet $ewallet)
    {
        //
    }


}
