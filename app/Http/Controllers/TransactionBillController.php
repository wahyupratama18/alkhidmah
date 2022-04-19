<?php

namespace App\Http\Controllers;

use App\Models\TransactionBill;
use App\Http\Requests\StoreTransactionBillRequest;
use App\Http\Requests\UpdateTransactionBillRequest;

class TransactionBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTransactionBillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionBillRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionBill  $transactionBill
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionBill $transactionBill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionBill  $transactionBill
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionBill $transactionBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionBillRequest  $request
     * @param  \App\Models\TransactionBill  $transactionBill
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionBillRequest $request, TransactionBill $transactionBill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionBill  $transactionBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionBill $transactionBill)
    {
        //
    }
}
