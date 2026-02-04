<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // jaga jaga buat nanti jika 1 user punya banyak ewallet
        // ambil semua id wallet yang di punya user ini
        // pluck id ngambil semua id dan dijadikan array
        $userWalletIDS = auth()->user()->ewallet->pluck('id')->toArray();

        // dd($myWalletID);
        // cek apakah pengirim transaksi ini adalah salah satu dompet punya saya
        $senderID = in_array($this->ewallet_sender_id, $userWalletIDS);

        $data = [
            'id' => $this->id,
            'trx_code' => $this->trx_code,
            'sender' => $this->ewalletSender->user->name,
            'receiver' => $this->ewalletReceiver->user->name ?? null,
            'amount' => $this->amount,
            'rupiah_amount' => 'Rp.' . number_format($this->amount,0,',','.'),
            'type' => $senderID ? 'OUT' : 'IN',
            'status' => $this->status,
            'date' => $this->created_at->format('d M Y, H:i'),
        ];

        return $data;
    }
}
