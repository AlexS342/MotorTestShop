<?php

namespace Shilov\Shop\entities;

class Buyer
{
    private int $minQuantityProduct = 2;
    private int $maxQuantityProduct = 11;
    private \DateTimeImmutable|null $timeTakeQueue = null;
    private array $basket = [];

    public function __construct()
    {
        $settings = json_decode(file_get_contents('settings.json'), true);

        $this->minQuantityProduct = ($settings['buyer']['minQuantityProduct']);
        $this->maxQuantityProduct = ($settings['buyer']['maxQuantityProduct']);

        $this->makePurchase();
    }

    public function setTimeTakeQueue(?\DateTimeImmutable $timeTakeQueue): void
    {
        $this->timeTakeQueue = $timeTakeQueue;
    }

    public function setBasket(array $basket): void
    {
        $this->basket = $basket;
    }

    public function getTimeTakeQueue(): ?\DateTimeImmutable
    {
        return $this->timeTakeQueue;
    }

    public function getCountProduct():int
    {
        return count($this->basket);
    }

    public function getBasket(): array
    {
        return $this->basket;
    }

    /**
     * Метод наполняет корзину покупателя случайным количеством случайных товаров
     * @return void
     */
    private function makePurchase():void
    {
        $quantityProduct = rand($this->minQuantityProduct, $this->maxQuantityProduct);
        for($i = 0; $i < $quantityProduct; $i++)
        {
            $this->basket[$i] = new Product();
        }
    }
}
