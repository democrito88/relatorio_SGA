<?php
require('fpdf.php');

class corpoPDF extends FPDF{
// Cabeçalho
    function Header(){
        // Logo
        $this->Image('../Imagens/logo-sga.jpeg',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',18);
        // Move to the right
        $this->Cell(60);
        // Title
        $this->Cell(60,10,utf8_decode('Relatório do SGA'),1,0,'C');
        // Line break
        $this->Ln(20);
        //Espaçamento a esquerda
        $this->Cell(50);
        //Data e hora
        $this->SetFont('Arial','',12);
        date_default_timezone_set("America/Recife");
        $this->Cell(70,10,"Olinda, ".date("H:i d/m/Y"),0,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Rodapé das páginas
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
    
    // Tabela
    function TabelaAtendimento($header, $data){
        
        $this->Cell(60);
        $this->SetFont('Arial','B',20);
        $this->Cell(60,5, "Tabela de Atendimento",'',0,'C');
        $this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(0,0,139);
        $this->SetTextColor(255);
        $this->SetDrawColor(224,224,224);
        $this->SetLineWidth(.3);
        $this->SetFont('','B',10);
        // Array de largura das células
        $w = array(50, 43, 21, 18, 23, 17, 17);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],5,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(221,255,221);
        $this->SetTextColor(0);
        $this->SetFont('','',8);
        // Data
        $preencherAmarelo = false;
        $preencher = true;
        while($row = pg_fetch_assoc($data)){
            $this->Cell($w[0],4, utf8_decode($row['atendente']),'LR',0,'L',$preencher);
            $this->Cell($w[1],4, utf8_decode($row['serviço']),'LR',0,'L',$preencher);
            $this->Cell($w[2],4, $row['data_do_atendimento'],'LR',0,'L',$preencher);
            $this->Cell($w[3],4, $row['hora_chegada'],'LR',0,'L',$preencher);
            $this->Cell($w[4],4, $row['hora_chamado'],'LR',0,'L',$preencher);
            if($row['inicio_do_atendimento'] === "Sem dados" || $row['inicio_do_atendimento'] === NULL){
                $this->Cell($w[5],4, " - ",'LR',0,'C',$preencher);
            }else{
                $this->Cell($w[5],4, $row['inicio_do_atendimento'],'LR',0,'L',$preencher);
            }
            if($row['fim_do_atendimento'] === "Sem dados" || $row['fim_do_atendimento'] === NULL){
                $this->Cell($w[6],4, " - ",'LR',0,'C',$preencher);
            }else{
                $this->Cell($w[6],4, $row['fim_do_atendimento'],'LR',0,'L',$preencher);
            }
            
            $this->Ln();
            $preencherAmarelo = !$preencherAmarelo;
            //Altera as cores das células de amarelo p/ verde
            $preencherAmarelo ? $this->SetFillColor(255,255,221) : $this->SetFillColor(221,255,221);
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
}
?>