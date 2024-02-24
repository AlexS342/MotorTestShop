<?php

namespace Shilov\Shop\entities;

use DateInterval;
use DateTimeImmutable;
use Exception;

class Cash
{
    private int $timeProduct = 3;
    private int $timePayment = 5;

    private int $id;
    private bool $work;
    private DateTimeImmutable|null $timeLastBuyer = null;
    private array $queue;

    /**
     * @param int $id - id а так же номер кассы
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->work = false;
        $this->queue = [];

        $settings = json_decode(file_get_contents('settings.json'), true);

        $this->timeProduct = ($settings['cash']['timeProduct']);
        $this->timePayment = ($settings['cash']['timePayment']);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setWork(bool $work): void
    {
        $this->work = $work;
    }

    public function setTimeLastBuyer(?DateTimeImmutable $timeLastBuyer): void
    {
        $this->timeLastBuyer = $timeLastBuyer;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWork(): bool
    {
        return $this->work;
    }

    public function getQueue(): array
    {
        return $this->queue;
    }

    public function getTimeLastBuyer(): ?DateTimeImmutable
    {
        return $this->timeLastBuyer;
    }

    /**
     * Возвращает количество покупателей в очереди
     * @return int
     */
    public function getCountQueue(): int
    {
        return count($this->queue);
    }

    /**
     * Добавляет покупателю время постановки в очередь и ставит его в очередь
     * @param Buyer $buyer
     * @return void
     * @throws Exception
     */
    public function addBuyerInQueue(Buyer $buyer): void
    {
        $this->queue[] = $buyer;
    }

    /**
     * Возвращает количество секунд на обслуживание покупателя
     * @param $key - ключ в массиве очереди
     * @return int - количество секунд на обслуживание
     */
    public function serviceTime($key):int
    {
        return count($this->queue[$key]->getBasket()) * $this->timeProduct + $this->timePayment;
    }

    /**
     * Удаляет покупателей из очереди если у них истекло время
     * @return void
     * @throws Exception
     */
    public function serviceBuyers():void
    {
        if(isset($this->queue) && count($this->queue) > 0 && $this->work){
            $key = array_key_first($this->queue);

            if($this->queue[$key]->getTimeTakeQueue() === null){
                $this->queue[$key]->setTimeTakeQueue(new DateTimeImmutable());
            }

            $startTime = $this->queue[$key]->getTimeTakeQueue();

            $fillSecond = $this->serviceTime($key);

            $interval = new DateInterval('PT' . $fillSecond . 'S');

            $finishTime = $startTime->add($interval);

            if($finishTime < new DateTimeImmutable()){
                array_shift ($this->queue);
            }

            if($this->getCountQueue()){
                $this->setTimeLastBuyer(new DateTimeImmutable());
            }
        }

    }
}
