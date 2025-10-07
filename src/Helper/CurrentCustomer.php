<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Helper;

use Raketa\BackendTestTask\Entity\Customer;
use Raketa\BackendTestTask\Helper\Singleton;


class CurrentCustomer extends Singleton
{
    private Customer $customer;

    protected function __construct()
    {
        //ПРимер
        $this->customer = new Customer(1234, "firstname", "lastname", "middlename", "email");
    }

    public static function getCustomer()
    {
        $currentCustomer = self::getInstance();
        if (empty($currentCustomer->customer)) {
            //TODO: Получение пользователя из текущей сессии и отлов ошибок
        }
        return $currentCustomer->customer;
    }
}
