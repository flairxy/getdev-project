<?php

namespace App\Http\Controllers\API\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function withdraw(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:1',
            'currency' => 'required|string',
            'address' => 'required|string'
        ]);


        $tutor = Tutor::whereUserId($request->user)->first();
        $amount = $request->amount;
        if ($tutor->balance >= $amount){

            $withdrawal = new Withdrawal();
            $withdrawal->user_id = $tutor->user_id;
            $withdrawal->amount = $request->amount;
            $withdrawal->currency = $request->currency;
            $withdrawal->address = $request->address;
            $withdrawal->save();

            $tutor->balance -= $request->amount;
            $tutor->save();

            return response([
                'status' => 'success',
                'message' => 'Withdrawal Successful'
            ]);
        }
         return response([
                'status' => 'error',
                'message' => 'Withdrawal Unsuccessful. Insufficient Funds'
            ]);
    }

    public function withdrawHistory($id){
        $withdrawals = Withdrawal::whereUserId($id)->get();
        $updatedWithdrawals = [];
        foreach($withdrawals as $withdrawal){
            $withdrawal->time = $withdrawal->created_at->toFormattedDateString();
            array_push($updatedWithdrawals, $withdrawal);
        }

        return $updatedWithdrawals;
    }
}
