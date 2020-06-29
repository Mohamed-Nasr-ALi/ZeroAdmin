<?php
namespace App\Repositories\Interfaces;

interface AnalyticsInterface{

    public function countCustomers($column = null,$value = null);
    public function countAgents($column = null,$value = null);
    public function countTransactions();
    public function topUsers($take);
    public function topAgents($take);

}
