<?php

namespace App\Providers;

use App\Repositories\Eloquent\AnalyticsRepository;
use App\Repositories\Eloquent\CashBackRepository;
use App\Repositories\Eloquent\CountryRepository;
use App\Repositories\Eloquent\SendMoneyRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\WalletRepository;
use App\Repositories\Eloquent\AgentRepository;
use App\Repositories\Eloquent\FriendRepository;
use App\Repositories\Eloquent\TypeRepository;
use App\Repositories\Interfaces\AgentInterface;
use App\Repositories\Interfaces\AnalyticsInterface;
use App\Repositories\Interfaces\CashBackInterface;
use App\Repositories\Interfaces\CountriesInterface;
use App\Repositories\Interfaces\FriendInterface;
use App\Repositories\Interfaces\SendMoneyInterface;
use App\Repositories\Interfaces\TransactionInterface;
use App\Repositories\Interfaces\TypeInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\WalletInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(AgentInterface::class, AgentRepository::class);
        $this->app->bind(TypeInterface::class, TypeRepository::class);
        $this->app->bind(FriendInterface::class, FriendRepository::class);
        $this->app->bind(WalletInterface::class, WalletRepository::class);
        $this->app->bind(WalletInterface::class, WalletRepository::class);
        $this->app->bind(AnalyticsInterface::class, AnalyticsRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(CountriesInterface::class, CountryRepository::class);
        $this->app->bind(SendMoneyInterface::class, SendMoneyRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CashBackInterface::class, CashBackRepository::class);

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
