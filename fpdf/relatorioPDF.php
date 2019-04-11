<?php
include_once './corpoPDF.php';
include_once '../util/conection.php';

$cabecalho = array('Atendente',utf8_decode('Serviço'),'Data','Chegada','Chamado as',utf8_decode('Início'), 'Fim');

//consulta dados no banco
$conn = conecta();
    
isset($_POST['atendente'])? $atendente = pg_escape_string($conn, $_POST['atendente']) : $atendente = null;
isset($_POST['servico'])? $servico = pg_escape_string($conn, $_POST['servico']) : $servico = null;
isset($_POST['dataInicial'])? $dataInicial = pg_escape_string($conn, $_POST['dataInicial']) : $dataInicial = null;
isset($_POST['dataFinal'])? $dataFinal = pg_escape_string($conn, $_POST['dataFinal']) : $dataFinal = null;
isset($_POST['horaInicial'])? $horaInicial = pg_escape_string($conn, $_POST['horaInicial']) : $horaInicial = null;
isset($_POST['horaFinal'])? $horaFinal = pg_escape_string($conn, $_POST['horaFinal']) : $horaFinal = null;

$query = "SELECT initcap(concat(u.nm_usu, ' ', u.ult_nm_usu)) Atendente,
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

$filtro = "";
if(!is_null($atendente)){$filtro .= " AND u.id_usu = ".$atendente;}
if(!is_null($servico)){$filtro .= " AND s.id_serv = '".$servico."'";}
if(!is_null($dataInicial)){$filtro .= " AND  a.dt_cheg BETWEEN '".$dataInicial."' ";}
if(!is_null($dataFinal)){$filtro .= " AND '".$dataFinal."'";}
if(!is_null($horaInicial)){$filtro .= " AND CAST(a.dt_cheg as time) BETWEEN '".$horaInicial."' ";}
if(!is_null($horaFinal)){$filtro .= " AND '".$horaFinal ."'";}
$filtro .= " LIMIT 100;";

$resultados = pg_query($conn, $query.$filtro);
desconecta($conn);

// Instanciando classe herdada
$pdf = new corpoPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->TabelaAtendimento($cabecalho, $resultados);
$pdf->Output();