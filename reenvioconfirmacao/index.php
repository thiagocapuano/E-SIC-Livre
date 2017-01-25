<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	require_once("../class/solicitante.class.php");
                            
        $idsolicitante = getSession("uid");
        
        $solicitante = new Solicitante($idsolicitante);
                
        if($solicitante->reenvioConfirmacao())
        {
            $msg = "<br>Prezado(a) ".$solicitante->getNome().", 
                    <br><br>Seu cadastro precisa ser completado. Foi reenviado um e-mail para o seu endereço <b>".$solicitante->getEmail()."</b> solicitando a 
                        confirmação do cadastro. 
                        <br><br>Após a confirmação, seu acesso será liberado.";
        }

        $_SESSION = array();
        session_destroy();
	$solicitante = null;
	
	include_once("../inc/topo.php");

	echo "<h1>ATENÇÃO</h1>";
	
	echo $msg."<br><br>&nbsp;";

	include_once("../inc/rodape.php");	
?>



