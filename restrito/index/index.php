<?php
header("Content-Type: text/html; charset=UTF-8", true);
/* * ********************************************************************************
  Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.

  Copyright (C) 2014 Prefeitura Municipal do Natal

  Este programa é software livre; você pode redistribuí-lo e/ou
  modificá-lo sob os termos da Licença GPL2.
 * ********************************************************************************* */
require_once("../inc/security.php"); 
include(DIR_CLASSES_LEIACESSO . "solicitacao.class.php");
include(DIR_CLASSES_LEIACESSO . "solicitante.class.php");
	
$login 		= $_POST["login"];
$password 	= $_POST["password"];
$tipo 		= $_REQUEST['t'];
$token2 	= $_REQUEST["to2"];
$notRedir  	= $_REQUEST["red"];
$msg 		= "";

//usado pra troca de sic, chamado no arquivo topo através do select de sics
$sic = $_GET['sic'];
if(!empty($sic))
    if(!atualizaUnidadeUsuario($sic))
        echo "<script>alert('Usuário não pertence ao SIC que está tentando acessar!');</script>";
	else
		Redirect("../index/");
//----------------------   

if(usaRecaptcha($login))
	$usarecap = true;
else
	$usarecap = false;

if ($_POST['btsub']) {
    if ($usarecap) {
        $error = null;
        $recaptcha_ok = (strtoupper($_POST["palavra"]) == strtoupper($_SESSION["palavra"]));
    } else
        $recaptcha_ok = true;

    if ($recaptcha_ok) {
        if (autentica($login, $password, $tipo)) {
            Redirect("../index/");
        } else {
            $msg = "Erro: falha no login.";
            $usarecap = true;
        }
    } else {
        $msg = "Erro: falha no login.";
    }
}


if (!empty($token)) {
    if (autentica("", "", "", $token)) {
        Redirect("../index/");
    } else {
        $msg = "<font color='red'>Erro: falha no login.</font>";
    }
}

if (!empty($token2)) {
	
    if (autentica("", "", "", "", $token2)) {
		if (empty($notRedir)) {
			Redirect("../index/");
			echo 'loggin...';
		}
    } else {
        $msg = "<font color='red'>Erro: falha no login.</font>";
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title> Lei de Acesso </title>

        <!-- CSS -->
        
        <!-- TAG PARA O GOOGLEBOT -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Place favicon.ico in the root directory -->

        <!-- build:css styles/vendor.css -->
        <!-- bower:css -->
        <link rel="stylesheet" href="../bower_components/ng-img-crop/compile/minified/ng-img-crop.css" />
        <link rel="stylesheet" href="../bower_components/Waves/dist/waves.min.css" />
        <link rel="stylesheet" href="../bower_components/animate.css/animate.css" />
        <link rel="stylesheet" href="../bower_components/jquery.scrollbar/jquery.scrollbar.css" />
        <link rel="stylesheet" href="../bower_components/bootstrap-select/dist/css/bootstrap-select.css" />
        <link rel="stylesheet" href="../bower_components/awesomplete/awesomplete.css" />
        <!-- endbower -->
        <link rel="stylesheet" href="../assets/styles/menu.css" />
        <link rel="stylesheet" href="../assets/styles/chrome-tabs.css" />
        <link rel="stylesheet" href="../assets/styles/checkbox.css" />
        <!-- endbuild -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
              rel="stylesheet">

        <!-- build:css styles/main.css -->
        <link rel="stylesheet" href="../assets/dist/styles/main.css">
        <!-- endbuild -->

        <link rel="stylesheet" media="print" href="../assets/dist/styles/print.css"/>

        <!-- build:js scripts/vendor/modernizr.js -->
        <script src="../bower_components/modernizr/modernizr.js"></script>
        <!-- endbuild -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <meta name="E-Sic Livre" content="Portal da Prefeitura Municipal do Natal - SEMPLA - Secretaria de Planejamento, Orçamento e Finanças" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="revisit-after" content="1" />
        <meta name="classification" content="Internet" />	
        <meta name="description" content="Portal da Prefeitura Municipal do Natal - SEMPLA - Secretaria de Planejamento, Orçamento e Finanças" />
        <meta name="keywords" content="Prefeitura do Natal, natal, rn, sempla, natal, rn, noticias, serviços" />
        <meta name="robots" content="ALL" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="author" content="SEMPLA, Prefeitura do Natal" />
        <meta name="language" content="pt-br" />
        <meta name="doc-class" content="Completed" />
        <meta name="doc-rights" content="Public" />
        <meta http-equiv="X-UA-Compatible" content="IE=8">

        <style>
            @media only print  {
              body {
                font-size: 10px;
              }
              #areaToPrint tr{
                border-top: 1px solid #ccc !important;
              }
            }
        </style>
    
    </head>
    <body>
        <div class="overlay-mobile"></div>
        <?php if (empty($_SESSION[SISTEMA_CODIGO])) { ?>
            <div id="login-content">
                <div class="align">
                    <div class="center">
                        <div class="box">
                            <header class="text-center">
                                <img src="../assets/images/icon-logo.png" class="logo" alt="">
                            </header>
                            <div class="content">
                                <?php if (!empty($msg)): ?>
                                    <div class="alert alert-danger"><?= $msg ?></div>
                                <?php endif; ?>
                                <form action="index.php" method="post">
                                    <div class="form-group">
                                        <label for="cpf" class="input-label"><i class="material-icons">account_circle</i></label>
                                        <input placeholder="Usuário" class="form-control icon" type="text" name="login" id="cpf" value="" maxlength="13"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="input-label"><i class="material-icons">lock</i></label>
                                        <input placeholder="Senha" class="form-control icon" type="password" name="password" id="password" value="" maxlength="100"/>
                                    </div>
                                    <?php if ($usarecap) { ?>
                                        <div class="form-group captcha-group">
                                            <div class="row">
                                                <div class="col-sm-4 col-xs-12">
                                                    <img class="img-responsive" src="../inc/captcha.php?l=150&a=50&tf=20&ql=5" id="imgcaptcha">
                                                    <img style="    position: absolute;bottom: 10px;right: 0;" src="../img/refresh.gif" title="Clique aqui para recarregar a imagem" alt="Clique aqui para recarregar a imagem"onclick="getElementById('imgcaptcha').src = '../inc/captcha.php?l=150&a=50&tf=20&ql=5';">
                                                </div>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input class="form-control" placeholder="Informe o código acima:" type="text" name="palavra">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-success waves-effect waves-button" value="Entrar" name="btsub">Entrar</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>			
            </div>
        <?php } else { ?>
            <div id="body-main">
                <?php include ("sidebar.php") ?>
                <div class="wrapper">
                    <?php include("navbar.php") ?>
                    <?php 
					foreach($_GET as $x => $x_value) {
						$link = $x;
						break;
					}
					if (isset($_GET['p']))
						$page = $_GET['p'] . '.php';
					else	
						$page = 'index.php';

					if (!empty($link) && $link <> 'dashboard')
						include("../".$link."/".$page);					
					else
						include("dashboard/".$page);
					
					//echo getSession('sic')[getSession("idsecretaria")][2];
					//echo $link;
					//echo '<br>' . $page;
					?>
                </div>
            </div>
        <?php } ?>

         <!-- bower:js -->
        <script src="../bower_components/jquery/dist/jquery.js"></script>
        <script src="../bower_components/Waves/dist/waves.min.js"></script>
        <script src="../bower_components/jquery.scrollbar/jquery.scrollbar.js"></script>
        <script src="../bower_components/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
        <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
        <script src="../bower_components/awesomplete/awesomplete.js"></script>
        <script src="../js/functions.js"></script>
        <script src="../assets/dist/scripts/main.js"></script>
        <script>
            //<![CDATA[
            $(window).load(function(){
                function printDiv() {
                  window.print();
                }
                $('.btn-print').click(function(){
                    printDiv()     
                });
            });//]]> 

        </script>
        <!-- endbower -->
    </body>
</html>
