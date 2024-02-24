<?php

use Shilov\Shop\entities\Shop;

include __DIR__ . '/vendor/autoload.php';

$settings = json_decode(file_get_contents('settings.json'), true);

$shop = new Shop();

$hourWrite = intval(date("H")) + 5;

do {
    $shop->serviceBuyersOnCash();
    $shop->closeEmptyCash();

    $sleep = intensityOfArrivalOfBuyers();

    if (intensityOfArrivalOfBuyers() === -1) {
        sleep(60);
        continue;
    }

    $shop->addBuyerInQueue();

    if ($hourWrite !== intval(date("H"))) {
        writeReport($shop);
        writeLog($shop);
        $hourWrite = intval(date("H"));
    }

    sleep($sleep);

} while (true);

/**
 * Возвращает случайное количество секунд между приходами покупателей или -1, если магазин не работает
 * @return int - количество секунд или -1
 */
function intensityOfArrivalOfBuyers(): int
{
    $hour = intval(date("H"));

    if ($hour >= 8 && $hour < 10) {
        $sleep = rand(1, 21);
    } elseif ($hour >= 10 && $hour < 11) {
        $sleep = rand(1, 17);
    } elseif ($hour >= 11 && $hour < 13) {
        $sleep = rand(1, 16);
    } elseif ($hour >= 13 && $hour < 16) {
        $sleep = rand(1, 15);
    } elseif ($hour >= 16 && $hour < 17) {
        $sleep = rand(1, 13);
    } elseif ($hour >= 17 && $hour < 19) {
        $sleep = rand(1, 7);
    } elseif ($hour >= 19 && $hour < 20) {
        $sleep = rand(1, 13);
    } elseif ($hour >= 20 && $hour < 22) {
        $sleep = rand(1, 23);
    } else {
        $sleep = -1;
    }

    return $sleep;
}

/**
 * Выводит в консоль состояние касс
 * @param $shop - объект текущего магазина
 * @return void
 */
function writeReport($shop): void
{
    echo '------------------------------------------------|' . PHP_EOL;
    echo "\tРаботает касса (" . date("H:i:s") . "):\t" . $shop->getCountWorkingCash() . "\t|" . PHP_EOL;
    echo '------------------------------------------------|' . PHP_EOL;
    echo "     касса №\t|     статус\t|     очередь\t|" . PHP_EOL;
    echo '------------------------------------------------|' . PHP_EOL;

    foreach ($shop->getArrCash() as $cash) {
        if ($cash->getWork()) {
            $status = 'открыто.';
        } else {
            $status = 'закрыто.';
        }
        echo "\t" . $cash->getId() . "\t|    " . $status . "\t|\t" . $cash->getCountQueue() . "\t|" . PHP_EOL;
    }
    echo '------------------------------------------------|' . PHP_EOL;
}

/**
 * Записывает основные данные касс в файл log.txt
 * @param $shop
 * @return void
 */
function writeLog($shop): void
{
    $date = new DateTimeImmutable();
    $date = $date->format('Y-m-d H:i:s');

    $log = '|*******************************************************************|' . PHP_EOL;
    $log = $log . "\t" . $date  . PHP_EOL;
    $log = $log . '|-------------------------------------------------------------------|' . PHP_EOL;

    $strCash = '';
    foreach ($shop->getArrCash() as $cash) {
        if ($cash->getWork()) {
            $status = 'открыта';
        } else {
            $status = 'закрыта';
        }

        $strCash = $strCash . "\t" . "Касса №" . $cash->getId() . " сейчас " . $status . ", в очереди " . $cash->getCountQueue() . " чел." . PHP_EOL;

        $strBuyer = '';
        foreach ($cash->getQueue() as $key => $buyer) {

            $strBuyer = $strBuyer . "\t\t Покупатель №" . $key . ", в корзине " . $buyer->getCountProduct() . " продуктов" . PHP_EOL;

            $strProducts = '';
            foreach($buyer->getBasket() as $key2 => $product)
            {
                $strProducts = $strProducts . "\t\t\t" . $key2 . ". " . $product->getName() . PHP_EOL;
            }

            $strBuyer = $strBuyer . $strProducts;
        }

        $strCash = $strCash . $strBuyer;
    }

    $log = $log . $strCash . '|-------------------------------------------------------------------|' . PHP_EOL;
    $log = $log . PHP_EOL;

    file_put_contents('log.txt', $log, FILE_APPEND);
}