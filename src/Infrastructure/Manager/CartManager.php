<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Manager;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Entity\Cart;
use Raketa\BackendTestTask\Entity\Customer;
use Raketa\BackendTestTask\Infrastructure\Facade\RedisFacade;

class CartManager
{
    protected $logger;
    protected $redisFacade;

    public function __construct()
    {
        $this->redisFacade = new RedisFacade();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Метод сохранения корзины, при успехе возвращает экземпляр корзины, при неудаче - null
     * @param \Raketa\BackendTestTask\Entity\Cart $cart
     * @param mixed $ex
     * @return Cart|null
     */
    public function saveCart(Cart $cart)
    {
        try {
            $this->redisFacade->set('cart:' . session_id(), $cart, 24 * 60 * 60);
        } catch (Exception $e) {
            $this->logger->error($e);
            return null;
        }
        return $cart;
    }

    /**
     * Метод получения корзины. При успехе возвращает экземпляр корзины, при неудаче - null
     * @param \Raketa\BackendTestTask\Entity\Customer $customer
     * @return \Raketa\BackendTestTask\Entity\Cart|null
     */
    public function getCart(Customer $customer) : Cart|null
    {
        $cart = null;
        try {
            $cart = $this->redisFacade->get('cart:' . session_id());
        } catch (Exception $e) {
            $this->logger->error($e);
            return null;
        }

        if (empty($cart)) {
            $cart = new Cart(
                session_id(),
                $customer,
                '',
                []
            );
        }
        return $cart;
    }
}
