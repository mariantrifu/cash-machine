<?php

namespace App\Http\Controllers;

use App\Card\Card;
use App\Card\InvalidArgumentException;
use App\CashMachine\CardTransaction;
use App\CashMachine\CashTransaction;
use App\CashMachine\Service;
use App\CashMachine\TransactionAmountExceededException;
use App\CashMachine\TransactionFactory;
use App\Money\BankNote;
use App\Money\BankNoteList;
use App\Money\Money;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
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

    /**
     * @throws ValidationException
     */
    public function addCash(Request $request): View
    {
        $validator = Validator::make($request->all(), [
            'money' => 'required|array',
            'money.*' => 'required|integer',
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->validate());
        }
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
            $transaction = TransactionFactory::make(CashTransaction::class, ['banknotes' => $bankNoteList]);
            $transactionView = $this->cashMachine->store($transaction);
            return view('machine-success', ['transaction' => $transactionView]);
        } catch (InvalidArgumentException $e) {
            $errors = [];
            foreach ($e->getMessages() as $key => $message) {
                $errors[$key] = $message;
            }
            throw ValidationException::withMessages($errors);
        }
    }

    /**
     * @throws ValidationException
     */
    public function addCard(Request $request): View
    {
        try {
            $date = explode('/', $request->get('card_date'));
            $expiration = new DateTime(
                sprintf('%s-%s-01', $date[1], $date[0]),
            );
            $data = [
                'amount' => (int) $request->get('amount'),
                'inputs' => new Card(
                    number: $request->get('card_number'),
                    expiration: $expiration,
                    holder: $request->get('card_holder'),
                    cvv: $request->get('card_cvv'),
                ),
            ];
            $transaction = TransactionFactory::make(CardTransaction::class, $data);
            $this->cashMachine->store($transaction);
            return view('machine-success', ['transaction' => $transaction]);
        } catch (InvalidArgumentException | TransactionAmountExceededException $e) {
            $errors = [];
            foreach ($e->getMessages() as $key => $message) {
                $errors[$key] = $message;
            }
            throw ValidationException::withMessages($errors);
        }
    }
}
