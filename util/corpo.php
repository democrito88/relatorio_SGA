<?php

function cabecalho(){
    echo "<!DOCTYPE html>
<html lang=\"pt-br\">
<head>
<meta charset=\"utf-8\">
<title>Exemplo da Tabela</title>

<!-- Bootstrap 4
<!-- <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\"/>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\"></script> -->
<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\"></script>
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
    <link rel=\"stylesheet\" href=\"http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css\" -->

<!-- Template pra data e hora -->
<link rel=\"stylesheet\" href=\"css/timePicker.css\">
<script src=\"http://code.jquery.com/jquery.min.js\"></script>
<script src=\"js/jquery-timepicker.js\"></script>
<script src=\"js/timepicker.js\"></script>

<!-- script css local -->
<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />
<!-- script js local-->
<script src=\"js/script.js\"></script>

<!-- biblioteca glyphicon -->
<link rel=\"stylesheet\" href=\"css/IcoMoon-Free-master/Font/demo-files/demo.css\"/>
<script src=\"css/IcoMoon-Free-master/Font/demo-files/liga.js\"></script>
<script src=\"css/IcoMoon-Free-master/Font/demo-files/demo.js\"></script>
</head>
<body>
    <header>
        <img src=\"Imagens/logo-sga.jpeg\" />
        <h1 style='text-align: center;'>
        <span class='icon icon-clipboard'></span>
        &nbsp;Relatório do SGA</h1>
    </header>";
}

function rodape(){
    echo "<footer><p>Relatório SGA. Versão 1.0 - Prefeitura Municipal de Olinda</p></footer>
</body>
</html>";
}?>
