<?php

namespace App\BinList\ValueObject;

use App\Common\ValueObject\Country;

# CR: YAGNI: Зайвий код. Оскільки нам потрібна тільки країна, то в цьому ValueObject нема сенсу.
# CR: YAGNI: Не знаю які умови диктує Symfony, але простіри імен (директорії) з одним файлом виглядають зайвою абстракцією. Якщо позбавитись директорій BinList/Repository та BinList/ValueObject код нічого не встратить оскільки навряд чи коли небудь в BinList з'являться інші *Repository та *ValueObject.
class BinLookUp
{
    private function __construct(private readonly array $values)
    {
    }

    # CR: Encapsulation: Погана абстракція. Можна створити об'єкт з будь яким масивом - клас не котролює свою цілісність.
    public static function createFromArray(array $values): self
    {
        return new self($values);
    }

    public function getCountry(): Country
    {
        # CR: Leaky abstraction: Протікає абстракція - клас з рівня домену знає про формат JSON відповіді від стороннього сервісу.
        return Country::createFromAlpha2($this->values['country']['alpha2']);
    }
}