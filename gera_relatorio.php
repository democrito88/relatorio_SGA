<?php
include_once './util/conection.php';
include_once './util/corpo.php';
cabecalho();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conn = conecta();
    
    isset($_POST['atendente'])? $atendente = pg_escape_string($conn, $_POST['atendente']) : $atendente = null;
    isset($_POST['servico'])? $servico = pg_escape_string($conn, $_POST['servico']) : $servico = null;
    isset($_POST['dataInicial'])? $dataInicial = pg_escape_string($conn, $_POST['dataInicial']) : $dataInicial = null;
    isset($_POST['dataFinal'])? $dataFinal = pg_escape_string($conn, $_POST['dataFinal']) : $dataFinal = null;
    isset($_POST['horaInicial'])? $horaInicial = pg_escape_string($conn, $_POST['horaInicial']) : $horaInicial = null;
    isset($_POST['horaFinal'])? $horaFinal = pg_escape_string($conn, $_POST['horaFinal']) : $horaFinal = null;
    
    isset($_POST['atendente1'])? $atendente1 = pg_escape_string($conn, $_POST['atendente1']) : $atendente1 = null;
    isset($_POST['dataInicial1'])? $dataInicial1 = pg_escape_string($conn, $_POST['dataInicial1']) : $dataInicial1 = null;
    isset($_POST['dataFinal1'])? $dataFinal1 = pg_escape_string($conn, $_POST['dataFinal1']) : $dataFinal1 = null;
    
    $query = "SELECT concat(u.nm_usu, ' ', u.ult_nm_usu) Atendente,
    --s.desc_serv,
    s.nm_serv Serviço,
    to_char(a.dt_cheg, 'dd/MM/yyyy') Data_do_Atendimento,
    to_char(a.dt_cheg, 'HH24:MI:SS') Hora_Chegada,
    to_char(a.dt_cha, 'HH24:MI:SS') Hora_Chamado,
    to_char(a.dt_ini, 'HH24:MI:SS') Inicio_do_Atendimento,
    COALESCE(to_char(a.dt_fim, 'HH24:MI:SS'), 'Sem dados') Fim_do_Atendimento
   FROM historico_atendimentos a
   INNER JOIN usuarios u ON a.id_usu = u.id_usu
   INNER JOIN servicos s ON a.id_serv = s.id_serv
   WHERE
     TRUE ";
    
    $queryHorarioAtendente = "
SELECT 
entradas.usuario,
entradas.data_ dia,
entradas.hora_entrada,
COALESCE(saidas.hora_saida, 'Inconsistente') hora_saida
FROM 
    ( SELECT u.id_usu,
        to_char(l.dt_log, 'dd/MM/yyyy') data_,
        concat(nm_usu, ' ', ult_nm_usu) usuario,
        to_char(l.dt_log, 'HH24:MI:SS') hora_entrada,
        CASE l.in_out WHEN 'O' THEN to_char(l.dt_log, 'HH24:MI:SS')
            ELSE NULL
            END hora_saida
    FROM usu_log l
    INNER JOIN usuarios u ON u.id_usu = l.id_usu
    WHERE ".(!is_null($dataInicial1) && !is_null($dataFinal1) ? "l.dt_log BETWEEN '".$dataInicial1."' AND '".$dataFinal1."' AND" : "")."
        l.in_out = 'I' ) entradas
LEFT JOIN
    ( SELECT u.id_usu,
    to_char(l.dt_log, 'dd/MM/yyyy') data_,
    concat(nm_usu, ' ', ult_nm_usu) usuario,
    CASE l.in_out WHEN 'I' THEN to_char(l.dt_log, 'HH24:MI:SS')
        ELSE NULL
        END hora_entrada,
    to_char(l.dt_log, 'HH24:MI:SS') hora_saida
    FROM usu_log l
    INNER JOIN usuarios u ON u.id_usu = l.id_usu
    WHERE ".(!is_null($dataInicial1) && !is_null($dataFinal1) ? "l.dt_log BETWEEN '".$dataInicial1."' AND '".$dataFinal1."' AND" : "")."
        l.in_out = 'O') saidas
ON entradas.id_usu = saidas.id_usu
".(!is_null($atendente1) ? " WHERE entradas.id_usu = ".$atendente1 : " WHERE TRUE ").
"ORDER BY entradas.data_,
saidas.data_,
entradas.usuario LIMIT 1000;
";
    
    $filtro = "";
    if(!is_null($atendente)){$filtro .= " AND u.id_usu = ".$atendente;}
    if(!is_null($servico)){$filtro .= " AND s.id_serv = '".$servico."'";}
    if(!is_null($dataInicial)){$filtro .= " AND  a.dt_cheg BETWEEN '".$dataInicial."' ";}
    if(!is_null($dataFinal)){$filtro .= " AND '".$dataFinal."'";}
    if(!is_null($horaInicial)){$filtro .= " AND CAST(a.dt_cheg as time) BETWEEN '".$horaInicial."' ";}
    if(!is_null($horaFinal)){$filtro .= " AND '".$horaFinal ."'";}
    $filtro .= " LIMIT 1000;";
    
    $resultados = pg_query($conn, $query.$filtro);
    $resultados1 = pg_query($conn, $queryHorarioAtendente);
    desconecta($conn);
    
    if(!is_bool($resultados) && pg_num_rows($resultados) != 0 && pg_num_rows($resultados) != 1000){
        $i = 0;
        $data = array();
        while($resultado = pg_fetch_assoc($resultados)){
            $data[$i] = $resultado;
            $i++;
        }
        $_SESSION['data'] = $data;
        pg_result_seek($resultados, 0);
    }
    
    if(!is_bool($resultados1) && pg_num_rows($resultados1) != 0 && pg_num_rows($resultados1) != 1000){
        $i = 0;
        $data1 = array();
        while($resultado = pg_fetch_assoc($resultados1)){
            $data1[$i] = $resultado;
            $i++;
        }
        $_SESSION['data1'] = $data1;
        pg_result_seek($resultados1, 0);
    }
    ?>
<section>
    <button class="btn btn-primary" onclick="window.location.replace('formulario.php');"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Voltar</button>
    <button class="btn btn-danger" style="float: right;" onclick="window.location.replace('./fpdf/relatorioPDF.php')"><span class="icon icon-file-pdf"></span>&nbsp;Gerar PDF</button><br><br>
    
    <?php /*Se for requerido um relatório de atendimento*/
    if(strpos($filtro, "AND") != false){?>
    <h3 class="titulo-tabela">Tabela de atendimentos</h3>
    <table class="table table-hover">
        <thead>
            <tr><th>Atendente</th><th>Serviço</th><th>Data do Atend.</th><th>Chegada do Contribuinte</th><th>Chamado de Atendimento</th><th>Inicio do Atendimento</th><th>Fim do Atendimento</th></tr>
        </thead>
        <tbody>
<?php
        while($resultado = pg_fetch_assoc($resultados)){
            echo "<tr>";
            echo "<td >" . $resultado['atendente'] . "</td>";
            echo "<td >" . $resultado['serviço'] . "</td>";
            echo "<td >" . $resultado['data_do_atendimento'] . "</td>";
            echo "<td >" . $resultado['hora_chegada'] . "</td>";
            echo "<td >" . $resultado['hora_chamado'] . "</td>";
            echo "<td >" . $resultado['inicio_do_atendimento'] . "</td>";
            echo "<td >" . $resultado['fim_do_atendimento'] . "</td>";
            echo "</tr>";
        }
    
    }
    ?>
        </tbody>
    </table><br><br>
    <?php
    /*Se for requerido um relatório de atendente*/
    if(!is_null($atendente1) || !is_null($dataInicial1)){?>
    <h3 class="titulo-tabela">Tabela de atendente(s)</h3>
    <table class="table table-hover">
        <thead>
            <tr><th>Atendente</th><th>Data</th><th>Chegada</th><th>Saída</th></tr>
        </thead>
        <tbody>
    <?php
        while($resultado = pg_fetch_assoc($resultados1)){
            echo "<tr>";
            echo "<td >" . $resultado['usuario'] . "</td>";
            echo "<td >" . $resultado['dia'] . "</td>";
            echo "<td >" . $resultado['hora_entrada'] . "</td>";
            echo "<td >" . $resultado['hora_saida'] . "</td>";
            echo "</tr>";
        }
    }
    ?>
        </tbody>
    </table>
</section>
<?php
    rodape();
}