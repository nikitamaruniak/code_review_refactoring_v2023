<?php

namespace App\Common\Exception;

use Exception;


# CR: Exceptions, DRY: Не знаю який синтаксис в PHP, але мені не вистачає в цьому класі значення яке призвело до появи виключення `value` та метода `message` який однотипно форматує повідомлення.
class ValidationException extends Exception
{
}
