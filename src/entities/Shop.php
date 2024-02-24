<?php

namespace Shilov\Shop\entities;

use DateInterval;
use DateTimeImmutable;
use Exception;

class Shop
{
    private int $timeWaitingBuyers = 30;
    private string $name = 'Продукты';
    private int $quantityAllCash = 10;
    private array $arrCash = [];

    public function __construct()
    {
        $settings = json_decode(file_get_contents('settings.json'), true);

        $this->name = ($settings['shop']['shopName']);
        $this->quantityAllCash = ($settings['shop']['quantityCash']);
        $this->timeWaitingBuyers = ($settings['shop']['timeWaitingBuyers']);

        for($i = 1; $i <= $this->quantityAllCash; $i++)
        {
            $this->arrCash[$i] = new Cash($i);
        }
    }

    public function getArrCash(): array
    {
        return $this->arrCash;
    }

    public function getCountCash():int
    {
        return count($this->arrCash);
    }

    public function getCountWorkingCash():int
    {
        $i = 0;
        foreach ($this->arrCash as $cash)
        {
            !$cash->getWork() ? : $i++ ;
        }
        return $i;
    }

    /**
     * Добавляет покупателя в очередь на кассу в которой меньше очередь
     * @return void
     */
    public function addBuyerInQueue(): void
    {
        $workingKeyCash = [];
        foreach ($this->arrCash as $key => $item)
        {
            if($item->getWork()){
                $workingKeyCash[] = $key;
            }
        }

        if(count($workingKeyCash) === 0) {
            $firstKey = array_key_first($this->arrCash);
            $this->arrCash[$firstKey]->setWork(true);
            $this->arrCash[$firstKey]->addBuyerInQueue(new Buyer());
            return;
        }

        $notWorkingKeyCash = [];
        foreach ($this->arrCash as $key => $item)
        {
            if(!$item->getWork()){
                $notWorkingKeyCash[] = $key;
            }
        }

        if(count($workingKeyCash) === 1) {
            $firstKeyOpen = array_key_first($workingKeyCash);
            if($this->arrCash[$workingKeyCash[$firstKeyOpen]]->getCountQueue() < 5){
                $this->arrCash[$workingKeyCash[$firstKeyOpen]]->addBuyerInQueue(new Buyer());
            }else{
                $firstKeyClose = array_key_first($notWorkingKeyCash);
                $this->arrCash[$notWorkingKeyCash[$firstKeyClose]]->setWork(true);
                $this->arrCash[$notWorkingKeyCash[$firstKeyClose]]->addBuyerInQueue(new Buyer());
            }
            return;
        }

        if(count($workingKeyCash) <= $this->quantityAllCash){
                $keyMinQueueInCash = null;
                $minBuyersInQueue = null;

                foreach ($workingKeyCash as $key)
                {
                    if(is_null($keyMinQueueInCash)){
                        $keyMinQueueInCash = $key;
                        $minBuyersInQueue = $this->arrCash[$key]->getCountQueue();
                    }
                    if($minBuyersInQueue > $this->arrCash[$key]->getCountQueue()){
                        $keyMinQueueInCash = $key;
                        $minBuyersInQueue = $this->arrCash[$key]->getCountQueue();
                    }
                }

                if($minBuyersInQueue < 5 || $this->quantityAllCash === count($workingKeyCash)){
                    $this->arrCash[$keyMinQueueInCash]->addBuyerInQueue(new Buyer());
                }else{
                    $firstKeyClose = array_key_first($notWorkingKeyCash);
                    $this->arrCash[$notWorkingKeyCash[$firstKeyClose]]->setWork(true);
                    $this->arrCash[$notWorkingKeyCash[$firstKeyClose]]->addBuyerInQueue(new Buyer());
                }
            }
    }

    /**
     * Убирает из очереди покупателей, у которых вышло время обслуживания
     * @return void
     */
    public function serviceBuyersOnCash():void
    {
        foreach ($this->arrCash as $cash)
        {
            $cash->serviceBuyers();
        }
    }

    /**
     * Закрывает кассу у которой закончилось время ожидания покупателя
     * @return void
     * @throws Exception
     */
    public function closeEmptyCash():void
    {
        foreach ($this->arrCash as $cash)
        {
            if($cash->getCountQueue() === 0 && $cash->getWork()) {
                $interval = new DateInterval('PT' . $this->timeWaitingBuyers . 'S');
                $start = $cash->getTimeLastBuyer();
                $timeClose = $start->add($interval);

                $now = new DateTimeImmutable();

                if($timeClose < $now){
                    $cash->setWork(false);
                }
            }
        }
    }
}
