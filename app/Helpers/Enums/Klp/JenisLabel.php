<?php

namespace App\Helpers\Enums\Klp;

use App\Traits\EnumsToArray;

enum JenisLabel: string
{
    use EnumsToArray;

    case KL = 'KEMENTRIAN LEMBAGA';
    case PEMDA = 'PEMERINTAH DAERAH';
}
