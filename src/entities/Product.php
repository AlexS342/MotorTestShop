<?php

namespace Shilov\Shop\entities;

class Product
{
    private string $name;

    public function __construct()
    {
        $this->createProduct();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Метод заполняет свойства $this->name случайным значением
     * @return void
     */
    private function createProduct():void
    {
        $products = [
            'Пирожное Воздушное (Меренги)',
            'Печенье Льдинка',
            'Печенье Желтковое',
            'Печенье Минутка',
            'Печенье Лысьвенское с шок.',
            'Печенье Творожное',
            'Печенье Белочка',
            'Печенье № 1 (курабье, лысьвенское, цветочек)',
            'Печенье № 2 (ореховое, маковое, прикамское)',
            'Хворост',
            'Кекс Столичный',
            'Кекс с фруктовой начинкой',
            'Печенье «Майское»',
            'Печенье «Нарезное»',
            'Печенье «Летнее»',
            'Печенье «Круглое»',
            'Печенье «Желтковое»',
            'Печенье «Популярное»',
            'Биточки картофельные п/ф',
            'Биточки манные п/ф',
            'Блинчики без начинки',
            'Блинчики со сгущ. молоком',
            'Вареники с творогом п/ф',
            'Голубцы ленивые п/ф',
            'Зразы картофельные с грибами п/ф',
            'Зразы мясо-картофельные п/ф',
            'Котлета «Вкусняшка» куриная п/ф',
            'Котлета «Воздушная» п/ф (картофель, морковь, капуста)',
            'Котлета «Городская» п/ф (свинина, кура)',
            'Котлета постная п/ф',
            'Котлета столовая п/ф (свинина, говядина, перловая крупа)',
            'Куриные шарики',
            'Пельмени Бабушкины п/ф (редька)',
            'Пельмени Бабушкины п/ф (редька)',
            'Пельмени Вкусняшки п/ф (кура,картофель)',
            'Пельмени Вкусняшки п/ф (кура,картофель)',
            'Пирожок капустный п/ф',
            'Пирожок картофельный п/ф',
            'Посикунчики «Домашние» п/ф',
            'Суповой набор (свиной) п/ф',
            'Тефтели с рисом п/ф',
            'Ёжики мясные «Вкусные»',
            'Фарш свиной п/ф',
            'Фрикадельки из горбуши п/ф',
            'Хинкали п/ф',
            'Хинкали «Грузинские»',
            'Чебурек мясной п/ф',
            'Чебурек Закусочный п/ф',
            'Чебурек картофельный п/ф',
            'Чебуреки «По-домашнему»',
            'Чебурек с печенью',
            'Колбаса п/к Липецкая',
            'Колбаса п/к Озерская',
            'Колбаса вареная Чайная',
            'Колбаса вареная Закусочная',
            'Колбаса вареная Молочная',
            'Ветчина Александровская',
            'Ветчина свиная',
            'Сардельки свиные',
            'Сардельки говяжьи',
            'Сосиски любительские',
            'Сосиски молочные',
            'Кинза',
            'Петрушка',
            'Роккола',
            'Укроп',
            'Лук зелёный',
            'Баклажан импортный',
            'Грибы шампиньоны',
            'Дайкон',
            'Кабачки',
            'Кабачки цукини',
            'Капуста цветная',
            'Капуста белокачанная',
            'Картофель',
            'Лук репка',
            'Лук репка красный',
            'Морковь',
            'Морковь мытая',
            'Огурец тепличный',
            'Огурец длинноплодный',
            'Перец чили',
            'Перец жёлтый',
            'Перец зелёный',
            'Перец красный',
            'Помидор',
            'Помидор Ташкент',
            'Помидор черри красный',
            'Редис',
            'Свекла',
            'Сельдерей черешковый',
            'Чеснок',
            'Авокадо',
            'Ананас',
            'Ананас голд',
            'Апельсин',
            'Банан',
            'Виноград белыый',
            'Виноград красный',
            'Виноград красный Ред Глоб',
            'Гранат',
            'Грейпфрут красный',
            'Груша пакхамс',
            'Груша конференс',
            'Имбирь',
            'Киви',
            'Клубника',
            'Лайм',
            'Лимон',
            'Манго',
            'Мандарин',
            'Яблоко айдарет',
            'Яблоко джаногоред',
            'Яблоко грени',
            'Яблоко гольден',
        ];
        $key = array_rand($products);
        $this->name = $products[$key];
    }



}
