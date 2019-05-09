<?php
include_once './corpoPDF.php';
include_once '../util/conection.php';
session_start();

$data = isset($_SESSION['data'])? $_SESSION['data'] : null;
$data1 = isset($_SESSION['data1'])? $_SESSION['data1'] : null;

// Instanciando classe herdada
$pdf = new corpoPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
if(!is_null($data)){
    $pdf->TabelaAtendimento($data);
    $pdf->Ln(50);
    
    //Se não, acumula em cache
    $_SESSION['data'] = null;
}
if(!is_null($data1) && sizeof($data1) > 0){
    $pdf->TabelaAtendente($data1);
    //Se não, acumula em cache
    $_SESSION['data1'] = null;
}
$pdf->Output();