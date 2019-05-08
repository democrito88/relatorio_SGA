<?php

function retirarInjecao($string) {
    $string = preg_replace("/(from|select|insert|delete|where|drop|drop table|show|show tables|FROM|SELECT|INSERT|DELETE|WHERE|DROP|SHOW|;|#|\*|--|\\\\)/", "", $string);
    $string = trim($string);
    $string = strip_tags($string); //verifica se foram passadas tags HTML, inclusive <script>
    $string = (get_magic_quotes_gpc()) ? $string : addslashes($string);
    return $string;
}