<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionService $transactionService)
    {
        $result = ['status' => 200];
        try {
            $result['transactions'] = $transactionService->getTransactionWithRole();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'transactions' => [],
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TransactionService $transactionService)
    {
        $result = ['status' => 200];
        try {
            $transaction = $transactionService->createTransaction($request);
            $transaction_detail = $transactionService->createTransactionDetail($transaction, $request);
            $result['transactions'] = $transaction;
            $result['success'] = 'Data transaction was stored';
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'transactions' => [],
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
