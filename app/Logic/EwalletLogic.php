<?php

namespace App\Logic;

use App\Models\User;
use App\Models\Ewallet;
use Illuminate\Support\Facades\DB;

class EwalletLogic
{
    /**
     * Check Ewallet dulu saat pertama kali, kemudian buat ewalletnya
     */
    public function getOrCreateEwallet(User $user)
    {
        $ewallet = Ewallet::firstOrCreate(
            ['user_id' => $user->id],
            [
               'ewallet_name' => 'DANA-'.$user->name,
               'ewallet_balance' => 0,
               'ewallet_code' => $user->phone,
            ]);

        return $ewallet;
    }

    public function topup(User $user, $amount){

        if(!$amount || $amount < 0){
            $message = 'Top up tidak boleh 0';
            return  responseFailed($message);
        }
        try {
            DB::beginTransaction();
            $wallet = $this->getOrCreateEwallet($user);
            //dd($amount);
            $wallet->increment('ewallet_balance', $amount);

            $wallet->transactionSender()->create([
                'trx_code' => 'TOPUP-'.time(),
                'amount' => $amount,
                'direction' => 'IN',
                'status' => 'success',
                'ewallet_receiver_id' => 0,
            ]);

            DB::commit();
            return $wallet;

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            throw $th;
        }
    }

    //next  bikin transfer
}

?>
