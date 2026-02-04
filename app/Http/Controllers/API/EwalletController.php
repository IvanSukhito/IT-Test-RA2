<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Ewallet;
use App\Logic\EwalletLogic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EwalletController extends Controller
{
    protected $EwalletLogic;

    public function __construct(EwalletLogic $EwalletLogic)
    {
        $this->EwalletLogic = $EwalletLogic;
    }
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

        $ewallet = $this->EwalletLogic->getOrCreateEwallet($user);
        // $checkEwallet = User::with(['ewallet'])->find($user->id);

        $message = 'Ewallet has already created';
        $data = $ewallet;
        return responseSuccess($message, $data);

    }

    public  function topup(Request $request){

        $user = Auth::user();
        $validate = Validator::make($request->all(),[
            'ewallet_balance' => 'required|gt:0',
        ]);

        if($validate->fails()){
            return responseFailed($validate->errors()->first());
        }

        try {
            //code...
            $topupEwallet = $this->EwalletLogic->topup($user, intval($request->ewallet_balance));
            $data = $topupEwallet;
            $message = 'Success top up ewallet';

            return responseSuccess($message, $data);

        } catch (\Throwable $th) {
            //throw $th;
            $message = $th->getMessage();
            return responseFailed($message);
        }



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
