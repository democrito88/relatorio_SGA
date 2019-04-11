<?php
include_once './util/conection.php';
include_once './util/corpo.php';

cabecalho();
?>
<section class="secaoForm">
    <form action="gera_relatorio.php" method="POST">
        <h2 style="color: #666; margin: 0 20% 6% 20%;">Selecione os itens no seu relatório</h2>
        
        <div class="row" style="min-height: 150px;">
            <h4>Pesquise por atendimento</h4>
            <div class="col-sm-3">
                <input type="checkbox" onclick="toggleDiv('atendente', 1);"> <strong>Atendente</strong>
                <div id="atendente" style="display: none;"></div>
            </div>
            <div class="col-sm-3">
                <input type="checkbox" onclick="toggleDiv('servico', 2);"> <strong>Serviço</strong>
                <div id="servico" style="display: none;"></div>
            </div>
            <div class="col-sm-3">
                <input type="checkbox" onclick="toggleDiv('data', 3);"> <strong>Data</strong>
                <div id="data" style="display: none;"></div>
            </div>
            <div class="col-sm-3">
                <input type="checkbox" onclick="toggleDiv('hora', 4);"> <strong>Hora do atendimento</strong>
                <div id="hora" style="display: none;"></div>
            </div>
        </div>
        <div class="row" style="min-height: 150px;">
            <h4>Pesquise por atendente</h4>
            <div class="col-sm-6">
                <input type="checkbox" onclick="toggleDiv('atendente1', 5);"> <strong>Atendente</strong>
                <div id="atendente1" style="display: none;"></div>
            </div>
            <div class="col-sm-6">
                <input type="checkbox" onclick="toggleDiv('data1', 6);"> <strong>Data</strong>
                <div id="data1" style="display: none;"></div>
            </div>
        </div>
        <button class="btn btn-success" type="submit">Gerar relatório</button>
    </form>
</section>
    <?php
rodape();