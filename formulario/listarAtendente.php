<?php
include_once '../util/conection.php';

$conn = conecta();
$atendentes = pg_query($conn, "SELECT id_usu, initcap(concat(nm_usu, ' ', ult_nm_usu)) Atendente FROM usuarios ORDER BY Atendente");
$retorno = "";
if(!is_bool($atendentes)){
    $retorno = "";
    while($atendente = pg_fetch_assoc($atendentes)){
        $retorno .= "<option value='".$atendente['id_usu']."'>".$atendente['atendente']."</option>";
    }
}else{
    $retorno = "<div class='alert alert-danger'><p>Não foi possível realizar consulta no banco de dados<p></div>";
}

desconecta($conn);
echo $retorno;