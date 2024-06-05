<?php

namespace App\Helpers\Enums\Klp;

use App\Traits\EnumsToArray;

enum JenisLevel: string
{
    use EnumsToArray;

    case OPD = 'Pusat';
    case PEMDA = 'Pemda';
    case PERWAKILAN_BKP_WILAYAH = 'Perwakilan BPKP Wilayah';
    case KEMENTRIAN = 'Kementrian';
    case SATKER = 'Satker';
}
