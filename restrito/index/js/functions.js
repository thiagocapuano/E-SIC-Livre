/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

function apagar(item){
  if (confirm("Tem certeza que deseja apagar?")) 
	  document.location = "apagar.php?codigo=" + item;
}

//outra forma de exclusao para paginas com mtos registros (observar que o arquivo apagar.php retorna diferente)
function remover(valor,pag){
	pag = typeof(pag) != 'undefined' ? pag : "";
	
	var iFName = "fexclui";
	if (confirm("Tem certeza que deseja remover o registro?")) {
		setFrame(iFName);
		
		if(pag!="")
			document.getElementById(iFName).src = pag+".php?codigo="+valor;
		else
			document.getElementById(iFName).src = "apagar.php?codigo="+valor;
		
	}
}	

function editar(item,pag){
  item = typeof(item) != 'undefined' ? item : "";
  pag = typeof(pag) != 'undefined' ? pag : "";

  if(pag!="")
	document.location = pag+".php?codigo=" + item;
  else
	document.location = "cadastro.php?codigo=" + item;
	
}


function getCorSelecao(selecionado){
	if(selecionado)
		return "#abcdef";
	else
		return "#FFFFFF";
}

//Controlar o maxlength dos elementos de edicao textarea.
function setMaxLength(size,element)
{
  if (element.value.length >= size) {
    element.value = element.value.substr(0,size);  
    return true;
  }else{
    return false;   
  }
}

function trim(str){
		return str.replace(/^\s+|\s+$/g,"");
}

//mascara data dd/mm/yyyy
function mascaraData(campoData)
{
	var data = campoData.value;

	if (data.length == 2)
	{             
		data = data + '/';                
		campoData.value = data;   
		return true;                            
	}              
	if (data.length == 5)
	{
		data = data + '/';                  
		campoData.value = data;                  
		return true;              
	}         
}

//mascara hora hh:mm
function mascaraHora(campoHora)
{
	var hora = campoHora.value;

	if (hora.length == 2)
	{             
		hora = hora + ':';                
		campoHora.value = hora;   
		return true;                            
	}              
}

//mascara dia/mes aniversario dd/mm
function mascaraNiver(campo)
{
	var niver = campo.value;

	if (niver.length == 2)
	{             
		niver = niver + '/';                
		campo.value = niver;   
		return true;                            
	}              
}

//mascara numero de telefone XXXX-XXXX
function mascaraTelefone(campo)
{
	var tel = campo.value;

	if (tel.length == 4)
	{             
		tel = tel + '-';                
		campo.value = tel;   
		return true;                            
	}              
}

//salta para o proximo campo se o tamanho do campo atual for igual ao tamanho informado
function pulaCampo(campo,proxcampo,tam)
{
	if(campo.value.length == tam)
		proxcampo.focus();
	
	return true;
}

function setFrame(ifName)
{
  if (!document.getElementById(ifName)) {
    var newNode = document.createElement("iFrame");
    newNode.setAttribute("id", ifName);
    newNode.setAttribute("src", "javascript:false;");
    newNode.setAttribute("scrolling", "no");
    newNode.setAttribute("frameborder", "0");
	newNode.setAttribute("style", "display:none");
    document.body.appendChild(newNode);
  }
 
}

function busca(valor,condicao,pagina)
{
	var iFName = "f"+pagina;
	if (condicao)
	{		
		setFrame(iFName);
		document.getElementById(iFName).src = pagina+".php?f="+valor;
	}
	
}

function limpa_string(S,excessao) // Deixa so os digitos no numero
{
	excessao = typeof(excessao) != 'undefined' ? excessao : '';
	var Digitos = "0123456789";
	if(excessao)
		Digitos = Digitos+excessao;
		
	var temp = "";
	var digito = "";
	for (var i=0; i<S.length; i++)
	{
		digito = S.charAt(i);
		if (Digitos.indexOf(digito)>=0)
		{
			temp=temp+digito;
		}
	}
	return temp;
}
function soNumero(campo,excessao)
{  
	excessao = typeof(excessao) != 'undefined' ? excessao : '';
	num = limpa_string(campo.value,excessao);
	campo.value = num;
}  
