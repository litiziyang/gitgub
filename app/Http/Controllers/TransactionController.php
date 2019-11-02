<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Services\TransactionService;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->middleware('jwt', ['except' => []]);
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'token'  => 'required|string',
            'number' => 'required|integer',
            'price'  => 'required'
        ]);
        if ($validator->failed()) {
            return $this->validate('');
        }
        $transaction = $this->transactionService->create($data['token'], $data['number'], $data['price'], $request->user_id);
        return $this->success($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     *
     * @return Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request     $request
     * @param Transaction $transaction
     *
     * @return Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     *
     * @return Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
