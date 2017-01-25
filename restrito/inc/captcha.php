<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

   session_start(); // inicial a sessao
   header("Content-type: image/jpeg"); // define o tipo do arquivo
    
    function captcha($largura,$altura,$tamanho_fonte,$quantidade_letras){
        $imagem = imagecreate($largura,$altura); // define a largura e a altura da imagem
        $fonte = "./times.ttf"; //voce deve ter essa ou outra fonte de sua preferencia em sua pasta
        $preto  = imagecolorallocate($imagem,0,0,0); // define a cor preta
        $branco = imagecolorallocate($imagem,255,255,255); // define a cor branca
        
        // define a palavra conforme a quantidade de letras definidas no parametro $quantidade_letras
        $palavra = substr(str_shuffle("ABCDEFGHIJKLMNPQRSTUVYXWZ123456789"),0,($quantidade_letras)); 
        $_SESSION["palavra"] = $palavra; // atribui para a sessao a palavra gerada
        for($i = 1; $i <= $quantidade_letras; $i++){ 
            imagettftext($imagem,$tamanho_fonte,rand(-25,25),($tamanho_fonte*$i),($tamanho_fonte + 10),$branco,$fonte,substr($palavra,($i-1),1)); // atribui as letras a imagem
        }
        imagejpeg($imagem); // gera a imagem
        //imagedestroy($imagem); // limpa a imagem da memoria
    }
    
    $largura = $_GET["l"]; // recebe a largura
    $altura = $_GET["a"]; // recebe a altura
    $tamanho_fonte = $_GET["tf"]; // recebe o tamanho da fonte
    $quantidade_letras = $_GET["ql"]; // recebe a quantidade de letras que o captcha terá

    captcha($largura,$altura,$tamanho_fonte,$quantidade_letras); // executa a funcao captcha passando os parametros recebidos

//Leia mais em: Captcha Simples com PHP http://www.devmedia.com.br/captcha-simples-com-php/17444#ixzz2sMuc4uwy
?>

