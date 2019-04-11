<?php
include_once '../util/conection.php';

$conn = conecta();
$atendentes = pg_query($conn, "SELECT id_serv, nm_serv Servico FROM servicos ORDER BY nm_serv");
$retorno = "";
if(!is_bool($atendentes)){
    $retorno = "<select name='servico'>";
    while($atendente = pg_fetch_assoc($atendentes)){
        $retorno .= "<option value='".$atendente['id_serv']."'>".$atendente['servico']."</option>";
    }
    $retorno .= "</select>";
}else{
    $retorno = "<div class='alert alert-danger'><p>Não foi possível realizar consulta no banco de dados<p></div>";
}

desconecta($conn);
echo $retorno;