<?php

namespace App\Http\Controllers;

use Redirect;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\Client;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /* Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Transactions/Index',['transactions'=>Transaction::paginate(10)
        ->withQueryString()
        ->through(function ($transaction){
            return[
                'id' => $transaction->id,
                'transaction_date' => $transaction->transaction_date,
                'amount' => $transaction->amount,
                'client_id' => $transaction->client_id,
                'client_name' => $transaction->client_name
            ];
        })]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::All();

        return Inertia::render('Transactions/Create',['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'amount' => ['required'],
            'transaction_date' => ['required'],
            'client_id'=> ['required'],
        ]);

        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->client_id = $request->client_id;
       
        $transaction->save();

       return Redirect::route('transactions.index')->with('success', 'Transaction created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $clients = Client::All();

        return Inertia::render("Transactions/Edit",[
            'clients' => $clients,
            'transaction' => [
                'id' => $transaction->id,
                'transaction_date' => $transaction->transaction_date,
                'amount' => $transaction->amount,
                'client_id' => $transaction->client_id,
             ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->validate($request,[
            'amount' => ['required'],
            'client_id' => ['required'],
            'transaction_date'=>['required'],
        ]);

        $transaction->amount = $request->amount;
        $transaction->client_id = $request->client_id;
        $transaction->transaction_date = $request->transaction_date;

        $transaction->update();
       
       return Redirect::route('transactions.index')->with('success', 'Transaction updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return Redirect::back()->with('success', 'Transaction deleted.');
    }
}
