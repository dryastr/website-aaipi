<?php

namespace App\Helpers\Enums\Klp;

use App\Traits\EnumsToArray;

enum Jenis: string
{
    use EnumsToArray;

    case KL = 'KL';
    case PEMDA = 'PEMDA';
}
