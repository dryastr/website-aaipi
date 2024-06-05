<?php

namespace App\Helpers\Enums\Klp;

use App\Traits\EnumsToArray;

enum Level: string
{
    use EnumsToArray;

    case PUSAT = 'PUSAT';
    case NON_PUSAT = 'NON-PUSAT';
}
