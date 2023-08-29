<?php

namespace App\ExchangeRate\Exeption;

use Exception;

# CR: YAGNI: Не бачу щоб виключення цього класу хтось оброблював, також не бачу щоб це виключення додавало інформацію до "стектрейсу", тобто клас скоріш за все не потрібен.
# CR: Це виклюення варто перенести в Infrastructure/ExchangeRate. Виключення за своїм визначенням не можуть бути частиною інтерфейсу, тоє вони мають бути визначені поряд з реалізацією інтерфейса.
class ExchangeRateRepositoryException extends Exception
{
}
