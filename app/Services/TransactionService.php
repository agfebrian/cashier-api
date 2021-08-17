<?php

namespace App\Services;

use Exception;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionService
{
    protected $transaction, $transaction_detail;

    public function __construct(Transaction $transaction, TransactionDetail $transactionDetail)
    {
        $this->transaction = $transaction;
        $this->transaction_detail = $transactionDetail;
    }

    public function getTransactionAll()
    {
        $transactions = $this->transaction::all();
        return $transactions;
    }

    public function getTransactionWithRole()
    {
        $user = Auth::user();
        $user_roles = $user->roles->first();

        $transactions = $user_roles->name == 'admin' ?
            $this->transaction::with('user', 'transaction_details')->get() :
            $this->transaction::where('user_id', $user->id)->with('user', 'transaction_details')->get();
        
        return $transactions;
    }

    public function createTransaction($request)
    {
        $validator = Validator::make($request, [
            'transaction_unique' => 'required',
            'transaction_total' => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $id = $this->getTransactionAll()->last();
        $date_now = Carbon::now()->format('Y-m-d');
        $explode_date = explode('-', $date_now);
        $uniq_code = implode('', $explode_date);
        $key = $id == null ? 1 : $id->id + 1;
        $trx = 'TRX' . substr($uniq_code, 2) . $key;
        
        $transaction = $this->transaction::create([
            'transaction_unique' => $trx,
            'transaction_discount' => 0,
            'transaction_total' => $request->total,
            'user_id' => Auth::user()->id
        ]);

        return $transaction;
    }

    public function createTransactionDetail($transaction, $request)
    {
        $carts = json_decode($request->carts, true);
        foreach ($carts as $key => $cart) {
            $product_id = (int) $cart['id'];
            $product_qty = (int) $cart['quantity'];
            $product_total = (int) $cart['subTotal'];
        
            $transaction_detail = $this->transaction_detail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product_id,
                'transaction_detail_qty' => $product_qty,
                'transaction_detail_total' => $product_total,
            ]);
        }

        return $transaction_detail;
    }
} 