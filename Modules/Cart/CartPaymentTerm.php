<?php

namespace Modules\Cart;

use Modules\Support\Money;

class CartPaymentTerm
{
    private $cart;
    public $down_payment_percent;
    public $down_payment_amount;
    public $completion_payment_amount;


    public function __construct($cart, $down_payment_percent)
    {
        $this->cart = $cart;
        $this->down_payment_percent = $down_payment_percent;
        $this->down_payment_amount = $this->downPaymentAmount();
        $this->completion_payment_amount = $this->completionPaymentAmount();
    }


    public function downPaymentAmount()
    {
        return Money::inDefaultCurrency($this->calculateDownPayment());
    }

    public function completionPaymentAmount()
    {
        return Money::inDefaultCurrency($this->calculateCompletionPayment());
    }

    private function calculateDownPayment()
    {
        return $this->cart->total()->amount() * $this->down_payment_percent;
    }

    private function calculateCompletionPayment()
    {
        return $this->cart->total()->amount() * (1 - $this->down_payment_percent);
    }


}
