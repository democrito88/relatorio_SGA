<?php

function conecta(){
    return pg_connect("host=192.168.10.75 port=5432 dbname=sgalivre user=postgres password=0l1nd@pe");
}

function desconecta($conn){
    pg_close($conn);
}