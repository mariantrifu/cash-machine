<?php

namespace App\Http\Controllers;

use App\Card\InvalidArgumentException;
use App\CashMachine\CashTransaction;
use App\CashMachine\Service;
use App\Money\BankNote;
use App\Money\BankNoteList;
use App\Money\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CashMachineController extends Controller
{
    public function __construct(
        private Service $cashMachine
    ) {
    }

    public function selectTransactionType(Request $request): View
    {
        $transactionType = $request->input('transactionType');
        return match ($transactionType) {
            'cash' => view('cash'),
            'card' => view('card'),
            'transfer' => view('transfer'),
        };
    }

    public function addCash(Request $request): View
    {
        try {
            $inputMoneys = $request->input('money');
            $bankNoteList = new BankNoteList([]);
            foreach ($inputMoneys as $inputMoney) {
                $bankNoteList->add(
                    bankNote: new BankNote(
                        money: new Money($inputMoney)
                    )
                );
            }
        } catch (InvalidArgumentException $e) {
            $errors = [];
            foreach ($e->getMessages() as $key => $message) {
                $errors[$key] = $message;
            }
            throw ValidationException::withMessages($errors);
        }
        $transaction = new CashTransaction($bankNoteList);
        $this->cashMachine->store($transaction);
        return view('cash-success', ['success' => 'nice work']);
    }
}
