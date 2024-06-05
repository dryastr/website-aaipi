<?php

use App\Models\FungsiUnitKerja;

if(!function_exists("submenus")){
    function submenus(){
        $data = FungsiUnitKerja::orderBy('id', 'desc')->get();
        return $data;
    }
}

?>