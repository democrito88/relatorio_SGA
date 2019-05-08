<?php
?>
<!DOCTYPE html>
<html lang=\"pt-br\">
<head>
<meta charset=\"utf-8\">
<title>Relatório SGA</title>
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <section class="secaoLogin">
        <div class="painel-login">
            <div class="painel-login-esquerda">
                <img src="Imagens/logo-sga.jpeg">
            </div>
            <canvas width="1" height="220" style="background-color: lightgrey;"></canvas>
            <div class="painel-login-direita">
                <form action="util/validaLogin.php" method="POST">
                    <h4>Sistema de Relatórios do SGA</h4><br>
                    <label>Login</label>
                    <input type="text" name="login" required=""><br><br>
                    <label>Senha</label>
                    <input type="password" name="senha" required=""><br><br>
                    <button type="submit" class="btn btn-success">Entrar</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>