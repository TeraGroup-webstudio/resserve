<?php


namespace product;


class product
{

    public function isProductNew($date_added, $days){
        echo 'test';
        echo $date_added;
        // Поточна дата
        $currentDate = new DateTime();

        // Дата додавання товару
        $productDate = new DateTime($date_added);

        // Обчислення різниці в днях
        $interval = $currentDate->diff($productDate);
        $daysDifference = $interval->days;

        // Перевірка, чи різниця в днях менша або дорівнює заданій кількості днів
        return $daysDifference <= $days;
    }

}