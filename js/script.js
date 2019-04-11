function toggleDiv(div, num){
    $("#"+div).toggle();
    var elemento = document.getElementById(""+div);
    
    if(elemento.style.display !== "none"){
        switch(num){
            case 1:
                mostraAtendentes(0);
                break;
            case 2:
                mostraServico();
                break;
            case 3:
                mostraData(0);
                break;
            case 4:
                mostraHora();
                break;
            case 5:
                mostraAtendentes(1);
                break;
            case 6:
                mostraData(1);
                break;
        }
    }
    else{
        elemento.innerHTML = ""
    }
}

function mostraAtendentes(toggle) {
    var select = window.document.createElement("select");
    if(toggle == 0){
        select.name = "atendente";
        var div = document.getElementById("atendente");
    }else{
        select.name = "atendente1";
        var div = document.getElementById("atendente1");
    }
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            select.innerHTML = this.responseText;
            div.appendChild(select);
        }
    };

    xmlhttp.open("GET", "./formulario/listarAtendente.php", true);
    xmlhttp.send();
}

function mostraServico() {
    var select = null;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            select = this.responseText;
            document.getElementById("servico").innerHTML = select;
        }
    };

    xmlhttp.open("GET", "./formulario/listarServico.php", true);
    xmlhttp.send();
}

function mostraData(toggle) {
    var inputDataInicial = window.document.createElement("input");
    inputDataInicial.type = "date";
    var inputDataFinal = window.document.createElement("input");
    inputDataFinal.type = "date";
    
    if(toggle == 0){
        var div = window.document.getElementById("data");
        inputDataInicial.name = "dataInicial";
        inputDataFinal.name = "dataFinal";
    }else{
        var div = window.document.getElementById("data1");
        inputDataInicial.name = "dataInicial1";
        inputDataFinal.name = "dataFinal1";
    }
    
    var pDe = window.document.createElement("p");
    var pAte = window.document.createElement("p");
    var br = window.document.createElement("br");
    
    pDe.innerHTML = "De:";
    pAte.innerHTML = "Até:";
    
    div.appendChild(pDe);
    div.appendChild(inputDataInicial);
    div.appendChild(br);
    div.appendChild(br);
    div.appendChild(pAte);
    div.appendChild(inputDataFinal);
    
    /*var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            input = this.responseText;
            document.getElementById("data").innerHTML = input;
        }
    };

    xmlhttp.open("GET", "./formulario/selecionaData.php", true);
    xmlhttp.send();*/
}

function mostraHora() {
    var input = null;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            input = this.responseText;
            document.getElementById("hora").innerHTML = input;
        }
    };

    xmlhttp.open("GET", "./formulario/selecionaHora.php", true);
    xmlhttp.send();
}