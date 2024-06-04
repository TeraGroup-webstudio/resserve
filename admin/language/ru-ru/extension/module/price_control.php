<?php
// Heading
$_['page_title'] = 'Массовое управление ценами';
$_['heading_title']    = '<strong style="color:#41637d">DEV-OPENCART.COM —</strong> Массовое управление ценами <a href="https://dev-opencart.com" target="_blank" title="Dev-opencart.com - Модули и шаблоны для Opencart"><img style="margin-left:15px;height:35px;margin-top:10px;margin-bottom:10px;" src="https://dev-opencart.com/logob.svg" alt="Dev-opencart.com - Модули и шаблоны для Opencart"/></a>';

// Text
$_['text_module'] = 'Модули';
$_['text_success'] = 'Операция выполнена успешно!';
$_['text_not_installed'] = 'Модуль управления ценами установлен неправильно! Для корректной работы переустановите модуль';
$_['text_confirm'] = 'Подтвердите действие';
$_['text_restore_changes_question'] = 'Откатить последние изменения?';
$_['text_confirm_action'] = 'Внимательно проверьте все параметры! Неправильное заполнение полей формы может привести к нежелательным последствиям! Выполнить задачу?';
$_['text_undo_last_changes'] = 'Отменить последние изменения?';
$_['text_filter'] = 'Фильтр';
$_['text_prices'] = 'Цены';
$_['text_add_settings'] = 'Дополнительно (Скидки/Акции)';
$_['text_create_if_not_exists'] = 'Создавать скидку/акцию, если такой не существует';
$_['text_discount_qty']='Кол-во товара для созданной скидки';
$_['text_delete_special']='Удалить Акции';
$_['text_delete_discount']='Удалить Скидки';
$_['text_special_discount_actions']='Действия с акциями/скидками';
$_['text_all_categories']='Все категории';
$_['text_formula_and_actions'] = 'Формула и действия';
$_['text_categories'] = 'Категории';
$_['text_include_subcategories']='Включая вложенные категории';
$_['text_manufacturers'] = 'Производители';
$_['text_customer_groups'] = 'Группы покупателей';
$_['text_percent'] = '%';
$_['text_number'] = 'число';
$_['text_main_price'] = 'Основная цена';
$_['text_options_price'] = 'Опции';
$_['text_discounts_price'] = 'Скидки';
$_['text_actions_price'] = 'Акции';
$_['text_addict']='<span class="hidden-xs hidden-sm hidden-md">Прибавить </span>( + )';
$_['text_deduct']='<span class="hidden-xs hidden-sm hidden-md">Вычесть </span>( - )';
$_['text_multiply']='<span class="hidden-xs hidden-sm hidden-md">Умножить на </span>( * )';
$_['text_divide']='<span class="hidden-xs hidden-sm hidden-md">Разделить на </span>( / )';
$_['text_author']='Автор модуля: <a href="https://opencart3x.ru">opencart3x.ru</a>';
$_['text_copyright']='Все права защищены.';
// Entry
$_['entry_value'] = 'Введите значение';


//Help
$_['help_filter'] = 'Если для какого-либо параметра фильтра не будет отмечено ни одного значения, в процессе изменения цен параметр не будет учитываться. Это равносильно выбору всех возможных значений параметра.';
$_['help_prices'] = "Выберите, какие значения цен товаров необходимо изменить. <b>Внимание!</b> Если не будет выбрано ни одного значения, изменение цен затронет основную цену товара! Будьте внимательны!";
$_['help_create_if_not_exists'] ='Если акция/скидка не задана для товара, она будет создана на основе цены товара и указанного мат. действия. Пример: стоит задача Уменьшить акции на 50%. У товара нет акции, его цена=100, тогда создается Акция со значением 100-50%=50.';
$_['help_delete_special_discount']='Удаление Акций/Скидок для товаров по выбранным параметрам фильтрации. <b>Внимание! Эти действия невозможно отменить!</b>';

// Error
$_['error_permission'] = 'У Вас нет прав для управления этим модулем!';
$_['error_data'] = 'Ошибка выполнения операции! Пожалуйста, правильно заполните все поля формы!';
$_['error_action'] = 'Не все обязательные поля заполнены корректно. Пожалуйста, проверьте введенные данные';

// Button
$_['button_run'] = 'Выполнить';
$_['button_rollback'] = 'Восстановить предыдущие значения';
$_['button_reinstall']='Переустановить';

?>