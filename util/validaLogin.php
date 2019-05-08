<?php

include_once './conection.php';
include_once './antiInjection.php';

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $login = isset($_POST['login']) ? retirarInjecao($_POST['login']) : "";
    $senha = isset($_POST['senha']) ? retirarInjecao($_POST['senha']) : "";
    
    //verificar o nome da tabela e o nome dos campos
    $queryBuscaUsuario = "SELECT INITCAP(nm_usu) nm_usu FROM usuarios WHERE login_usu = '".$login."' AND senha_usu = MD5('".$senha."');";
    $conn = conecta();
    $resultados = pg_query($conn, $queryBuscaUsuario);
    desconecta($conn);
    
    if(pg_num_rows($resultados) == 0){
        header("Location: ../index.php");
    }else{
        session_id("1");
        while($resultado = pg_fetch_assoc($resultados)){
            $_SESSION['nome'] = $resultado['nm_usu'];
        }
        header("Location: ../formulario.php");
    }
}