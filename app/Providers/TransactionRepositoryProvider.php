<?php

namespace App\Providers;

use App\CashMachine\TransactionRepository;
use App\Models\Transaction;
use App\Repository\Transaction\EloquentRepository as EloquentTransactionRepository;
use Illuminate\Support\ServiceProvider;

class TransactionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TransactionRepository::class, function () {
            return new EloquentTransactionRepository($this->app->make(Transaction::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
