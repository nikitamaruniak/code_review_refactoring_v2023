<?php

use App\TransactionCommissionController;
use App\ValueObject\Input;

require __DIR__ . '/vendor/autoload.php';

TransactionCommissionController::run(
    Input::createFromArgv($argv)
);
