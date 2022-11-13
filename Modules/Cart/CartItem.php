<?php

namespace Modules\Cart;

use Modules\Support\Money;

class CartItem
{
    public $id;
    public $qty;
    public $product;
    public $options;
    public $total;
    public $total_vendor;
    public $details;


    public function __construct($item)
    {
        $this->id = $item->id;
        $this->qty = $item->quantity;
        $this->product = $item->attributes['product'];
        $this->options = $item->attributes['options'];
        $this->details = $item->attributes['details'];
        $this->total =  $this->qty * $this->product->price->amount();
        $this->total_vendor =  $this->qty * $this->product->vendor_price->amount();
    }

    public function unitPrice()
    {
        return $this->product->selling_price->add($this->optionsPrice());
    }

    public function total()
    {
        return $this->unitPrice()->multiply($this->qty);
    }

    public function company()
    {
        return $this->product->company;
    }

    public function optionsPrice()
    {
        return Money::inDefaultCurrency($this->calculateOptionsPrice());
    }

    public function calculateOptionsPrice()
    {
        return $this->options->sum(function ($option) {
            return $this->valuesSum($option->values);
        });
    }

    private function valuesSum($values)
    {
        return $values->sum(function ($value) {
            if ($value->price_type === 'fixed') {
                return $value->price->amount();
            }

            return ($value->price / 100) * $this->product->selling_price->amount();
        });
    }

    public function isAvailable()
    {
        return $this->fresh()->product->hasStockFor($this->qty);
    }

    public function isNotAvailable()
    {
        return ! $this->isAvailable();
    }

    public function fresh()
    {
        $this->product = $this->product->refresh();

        return $this;
    }

    public function findTax($addresses)
    {
        return $this->product->taxClass->findTaxRate($addresses);
    }
}
