<?php

if (!function_exists('clean_cpf_cnpj')) {
    function clean_cpf_cnpj($valor): array|string
    {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        return str_replace("/", "", $valor);
    }
}
