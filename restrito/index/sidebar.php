<div class="menu fixed">
    <div class="scrollbar-inner">
        <header>
            <!--img class="img-responsive" src="../assets/dist/images/logo2.png" alt="E-SIC LIVRE "-->
            
			<div class="media text-center">
                <!--figure-->
                    <img src="../assets/dist/images/user-default.png"  width="160" alt="<?= getSession("apelidousuario"); ?>">
                <!--/figure-->
				<h5><?= getSession("apelidousuario"); ?></h5>
                <div class="email"><span class="text-bold">Setor:</span> 
					<script>
						function trocaSic(sic)
						{
							location.href='../index/?sic='+sic;
						}       
					</script>
					<select id="idsecretaria" name="idsecretaria" class="selectpicker" onChange="if (confirm('ATENÇÃO: Esta operação cancelarÁ os trabalhos atuais em aberto.\nConfirma troca de SIC?')){trocaSic(this.value);}">
					
					<?php
                                                                        $sql = "SELECT siglasecretaria, idsecretaria FROM vw_secretariausuario
                                                                                WHERE idusuario = '".getSession('uid')."'";

                                                                        $rs = execQuery($sql);
                                                                        
                                                                        while($row = mysqli_fetch_array($rs)){
                                                                            ?><option value="<?php echo md5($row['idsecretaria']);?>" <?php echo (getSession('idsecretaria') == $row['idsecretaria'])?"selected":"";?>><?php echo $row['siglasecretaria'];?></option><?php 
                                                                        }?>
						
					</select>
					
				</div>
            </div>
        </header>
        <ul dropdown>
			<li>
				<a href="<?php echo URL_BASE_SISTEMA; ?>index/" class="waves-effect"><i class="material-icons">dashboard</i>Painel Gerencial</a>
			</li>
				<?php echo getMenu(); ?>
            <li>
                <a href="../index/logout.php" class="waves-effect"><i class="material-icons">exit_to_app</i>Sair</a>
            </li>
        </ul>
    </div>
</div>

<?php

function getMenu() {	
	
	$sql = "select  distinct m.nome as menu, t.nome as tela, t.pasta
				from    sis_tela t 
				join    sis_menu m on m.idmenu = t.idmenu
				join    sis_acao a on a.idtela = t.idtela
				join    sis_permissao p on p.idacao = a.idacao
				join    sis_grupo g on g.idgrupo = p.idgrupo
				join    sis_grupousuario gu on gu.idgrupo = g.idgrupo
				where 
						t.ativo = 1 
						and a.status = 'A'
						and gu.idusuario = 16
				order by 
						m.ordem, menu, t.nome";

	$rs = execQuery($sql);

	$menuTmp = array();	
	$agrupaMenu = "";
	$menu = "";
	
	while($row = mysqli_fetch_array($rs)){

		if (empty($agrupaMenu)) {
			$agrupaMenu .= $row['menu'];
		}
	
		if ($agrupaMenu != $row['menu']) {
			$menu .= getMenuA($menuTmp);
			$menuTmp = array();
		}
		
		$agrupaMenu = $row['menu'];
		
		array_push($menuTmp, array($row['menu'], $row['pasta'], $row['tela']));
		
	}
	
	$menu .= getMenuA($menuTmp);
	return $menu;
}


function getMenuA($menuTmp) {
	$menu = "";
	$count =  count($menuTmp);

	if ($count == 1) {
		
		$menu .= '<li><a href="?'.$menuTmp[0][1].'" class="waves-effect"><i class="material-icons">'.$menuTmp[0][3].'</i>' . $menuTmp[0][0] .'</a></li>';
		
	} else if ($count > 1) {
		
		$menu .= '<li class="dropdown"><a href="#" class="waves-effect"><i class="material-icons">'.$menuTmp[0][3].'</i>' . $menuTmp[0][0] .'</a><ul>';
		
		for ($i = 0; $i < $count; $i++) {
			$menu .= '<li><a class="waves-effect" href="?'.$menuTmp[$i][1].'">' . $menuTmp[$i][2] .'</a></li>';
		}
		$menu .= "</ul></li>";
	}
	
	return $menu;
}

																		   
function getSics() {
	
                                                                        $sql = "SELECT siglasecretaria, idsecretaria FROM vw_secretariausuario
                                                                                WHERE idusuario = '".getSession('uid')."'";

                                                                        $rs = execQuery($sql);
                                                                        
                                                                        while($row = mysqli_fetch_array($rs)){
                                                                           echo "<option value="; echo md5($row['idsecretaria']);  
																		   echo (getSession('idsecretaria') == $row['idsecretaria'])?"selected":">";
																		   echo $row['siglasecretaria']; 
																		   echo "</option>";
                                                                        }
	
	
	
	/*
	$sic = getSession('sic');
	$ret = "";
	$sql = "SELECT siglasecretaria, idsecretaria FROM vw_secretariausuario
			WHERE idusuario = '".getSession('uid')."'";
	
	$rs = execQuery($sql);
	
	//for ($i = 0; $i <= count($sic); $i++) {
	foreach($sic as $rs) {
		$selected =  (md5(getSession('idsecretaria')) == $rs[0])?"selected":"";
		$ret .= "<option value='" . $rs[0] . "' " . $selected . ">" . $rs[1]. "</option>";
	}
	
	return $ret;*/
}
?>
