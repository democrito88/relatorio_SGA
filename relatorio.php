<?php
include_once './util/conection.php';
include_once './util/corpo.php';

cabecalho();
$db = conecta();
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
  a.dt_cheg BETWEEN '2019-03-01' AND '2019-03-31' AND
  CAST(a.dt_cheg as time) <= '13:30:00'";
$result = pg_query($db, $query);
desconecta($db);
echo "<h1 style=\"text-align: center;\">Resultados da busca</h1><p>A pesquisa retornou ".pg_num_rows($result)." resultados</p><br>";
echo "<div class='div-tabela'>"
. "<table class='table table-bordered table-hover'>";
echo "<thead>"
        . "<tr><th>Atendente</th><th>Serviço</th><th>Data do Atend.</th><th>Chegada</th><th>Chamado</th><th>Inicio do Atendimento</th><th>Fim do Atendimento</th></tr>"
        . "</thead>";
while($row = pg_fetch_assoc($result)){
    echo "<tr>";
    echo "<td >" . $row['atendente'] . "</td>";
    echo "<td >" . $row['serviço'] . "</td>";
    echo "<td >" . $row['data_do_atendimento'] . "</td>";
    echo "<td >" . $row['hora_chegada'] . "</td>";
    echo "<td >" . $row['hora_chamado'] . "</td>";
    echo "<td >" . $row['inicio_do_atendimento'] . "</td>";
    echo "<td >" . $row['fim_do_atendimento'] . "</td>";
    echo "</tr>";
}
echo "</table></div>";
rodape();
?>
