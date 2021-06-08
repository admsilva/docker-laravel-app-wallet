<?php

if (!function_exists('clean_cpf_cnpj')) {
    function clean_cpf_cnpj($valor)
    {
        $valor = trim($valor);

        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);

        return $valor;
    }
}
