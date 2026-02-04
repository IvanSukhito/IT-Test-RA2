<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Ewallet;
use App\Logic\EwalletLogic;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransactionResource;

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
     * Undocumented function
     *
     * @return void
     */
    public function checkBalance(){
        $user = Auth::user();

        $data = $this->EwalletLogic->checkBalance($user);

        $message = 'Success Check Balance';

        return responseSuccess($message, $data);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function transfer(Request $request){
        $user = Auth::user();

        $validate = Validator::make($request->all(),[
            'amount' => 'required|gt:10000',
            'receiver' => 'required|email',
        ]);

        if($validate->fails()){
            return responseFailed($validate->errors()->first());
        }

        $sender = $user;
        $receiver = User::where('email', $request->receiver)->first();

        if(!$receiver){
            $message = 'Receiver not found';
            return responseFailed($message);
        }
        if($user->id == $receiver->id){
            $message = 'You cannot transfer to the same account';
            return responseFailed($message);
        }

        try {

            $data = $this->EwalletLogic->transfer($user, $receiver, $request->amount);

            $message = 'Success Trasnfer';
            return responseSuccess($message, $data);

        } catch (\Throwable $th) {

            //throw $th;
            $message = $th->getMessage();
            return responseFailed($message);
        }
    }

    public function checkHistory(){
        $user = Auth::user();

        $wallet = $user->ewallet->first();

        $data = Transaction::where(function($query) use ($wallet) {
            $query->where('ewallet_sender_id', $wallet->id)
                  ->orWhere('ewallet_receiver_id', $wallet->id);
        })
        ->with(['ewalletSender.user']) // <--- TAMBAHKAN INI
        ->latest()
        ->get();

        $message = 'Success Check History';
        $getData = TransactionResource::collection($data);
        // dd($getData);

    return responseSuccess($message, $getData);

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
