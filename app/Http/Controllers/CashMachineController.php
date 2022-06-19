<?php

namespace App\Http\Controllers;

use App\Card\Card;
use App\CashMachine\TransferTransaction;
use App\Exceptions\InvalidArgumentException;
use App\CashMachine\CardTransaction;
use App\CashMachine\CashTransaction;
use App\CashMachine\Inputs;
use App\CashMachine\Service;
use App\CashMachine\TransactionAmountExceededException;
use App\CashMachine\TransactionFactory;
use App\Money\BankNote;
use App\Money\BankNoteList;
use App\Money\Money;
use App\Transfer\BankTransfer;
use DateTime;
use Illuminate\Http\Request;
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
            $inputsData = new Inputs([
                'banknotes' => $bankNoteList
            ]);
            $transaction = TransactionFactory::make(CashTransaction::class, $inputsData);
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
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'card_holder' => 'required|string',
            'card_date' => 'required|date_format:m/y',
            'card_cvv' => 'required|digits:3',
            'amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->validate());
        }
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
            $inputsData = new Inputs($data);
            $transaction = TransactionFactory::make(CardTransaction::class, $inputsData);
            $transactionView = $this->cashMachine->store($transaction);
            return view('machine-success', ['transaction' => $transactionView]);
        } catch (InvalidArgumentException | TransactionAmountExceededException $e) {
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
    public function addTransfer(Request $request): View
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'transfer_date' => 'required|date_format:Y-m-d',
            'account_number' => 'required|alpha_num|size:6',
            'amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->validate());
        }
        try {
            $data = [
                'amount' => (int) $request->get('amount'),
                'inputs' => new BankTransfer(
                    account: $request->get('account_number'),
                    customer: $request->get('customer_name'),
                    date: new DateTime($request->get('transfer_date')),
                ),
            ];
            $inputsData = new Inputs($data);
            $transaction = TransactionFactory::make(TransferTransaction::class, $inputsData);
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
}
