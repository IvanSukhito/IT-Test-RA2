<?php

namespace App\Logic;

use App\Models\User;
use App\Models\Ewallet;
use App\Models\Transaction;
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

    public function checkBalance(User $user){
        $data = $user->ewallet->first();

        $data = $data->only(['rupiah_balance']);

        return $data;
    }

    public function transfer(User $user, $receiver, $amount){

        // dd($receiver);
        $sender = $user;

        // $receiverEwallet = Ewallet::with(['user'])->where('user_id',$receiver->id)->first();
        $senderEwallet = $this->getOrCreateEwallet($user);
        $receiverEwallet = $this->getOrCreateEwallet($receiver);

        if(!$receiverEwallet){
          throw new \Exception('Receiver has no wallet');
        }
        if($receiverEwallet->id == $senderEwallet->id){
          throw new \Exception('You cannot transfer to the same wallet');
        }
        if ($senderEwallet->ewallet_balance < $amount) {
        throw new \Exception('Insufficient balance');
        }

        DB::beginTransaction();
        try {
            $senderEwallet->decrement('ewallet_balance', $amount);
            $receiverEwallet->increment('ewallet_balance', $amount);

            $senderEwallet->transactionSender()->create([
                'trx_code'            => 'TRF-OUT-' . time(),
                'amount'              => $amount,
                'direction'           => 'OUT',
                'status'              => 'success',
                'ewallet_sender_id'   => $senderEwallet->id,   // Tambahkan ini!
                'ewallet_receiver_id' => $receiverEwallet->id, // Kirim ke ID wallet penerima
            ]);

            $receiverEwallet->transactionReceiver()->create([
                'trx_code'            => 'TRF-IN-' . time(),
                'amount'              => $amount,
                'direction'           => 'IN',
                'status'              => 'success',
                'ewallet_sender_id'   => $senderEwallet->id,   // Tambahkan ini!
                'ewallet_receiver_id' => $receiverEwallet->id, // Masuk ke ID wallet penerima
            ]);

            DB::commit();
            $data = [
                'senderEwallet' => $senderEwallet,
                'receiverEwallet' => $receiverEwallet,
            ];
            return $data;

        } catch (\Throwable $th) {

            DB::rollback();
            throw $th;
        }

    }

    //next  bikin transfer
}

?>
