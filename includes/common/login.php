<?/*                        Copyright 2005 Fl�vio Ribeiro

         This file is part of OCOMON.

         OCOMON is free software; you can redistribute it and/or modify
         it under the terms of the GNU General Public License as published by
         the Free Software Foundation; either version 2 of the License, or
         (at your option) any later version.

         OCOMON is distributed in the hope that it will be useful,
         but WITHOUT ANY WARRANTY; without even the implied warranty of
         MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
         GNU General Public License for more details.

         You should have received a copy of the GNU General Public License
         along with Foobar; if not, write to the Free Software
         Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/	session_start();

  	include ("../../includes/include_geral.inc.php");
  	include ("../../includes/functions/browser_detection.php");

	$browser = browser_detection('full');
	$_SESSION['s_browser'] = $browser[0];

	GLOBAL $conec;
	$conec = new conexao;
	$conec->conecta('MYSQL');


	if (AUTH_TYPE == "LDAP") {
		$conec->conLDAP(LDAP_HOST, LDAP_DOMAIN, LDAP_DN, LDAP_PASSWORD);
		$conecSec = new conexao; //Para testar no LDAP Labin
		$conecSec->conLDAP(LDAP_HOST, LDAP_DOMAIN_SEC, LDAP_DN, LDAP_PASSWORD);

		if ((senha_ldap($_POST['login'],$_POST['password'],'usuarios')=="ok") && ($conec->userLDAP($_POST['login'],$_POST['password']) || $conecSec->userLDAP($_POST['login'],$_POST['password'])))
		{
		        $s_usuario=$_POST['login'];
		        $s_senha=$_POST['password'];

			$queryOK = "SELECT u.*, n.*,s.* FROM usuarios u left join sistemas as s on u.AREA = s.sis_id ".
							"left join nivel as n on n.nivel_cod =u.nivel WHERE u.login = '".$_POST['login']."'";

			$resultadoOK = mysql_query($queryOK) or die('IMPOSS�VEL ACESSAR A BASE DE DADOS DE USU�RIOS: LOGIN.PHP');
			$row = mysql_fetch_array($resultadoOK);
			$s_nivel = $row['nivel'];

			if ($s_nivel<4){ //Verifica se n�o est� desabilitado
				$s_logado=1;
			}

			$s_nivel_desc = $row['nivel_nome'];
			$s_area = $row['AREA'];
			$s_uid = $row['user_id'];
			$s_area_admin =  $row['user_admin'];

			/*VERIFICA EM QUAIS �REAS O USU�RIO EST� CADASTRADO*/
			$qryUa = "SELECT * FROM usuarios_areas where uarea_uid=".$s_uid.""; //and uarea_sid=".$s_area."
			$execUa = mysql_query($qryUa) or die('IMPOSS�VEL ACESSAR A BASE DE USU�RIOS 02: LOGIN.PHP');
			$uAreas = "".$s_area.",";
			while ($rowUa = mysql_fetch_array($execUa)){
				$uAreas.=$rowUa['uarea_sid'].",";
			}
			$uAreas = substr($uAreas,0,-1);
			$s_uareas = $uAreas;

			/*CHECA QUAIS OS M�DULOS PODEM SER ACESSADOS PELAS �REAS QUE O USU�RIO PERTENCE*/
			$qry = "SELECT * FROM permissoes where perm_area in (".$uAreas.")";
			$exec = mysql_query($qry) or die('IMPOSS�VEL ACESSAR A BASE DE PERMISS�ES: LOGIN.PHP');

			while($row_perm = mysql_fetch_array($exec)){
				$s_permissoes[]=$row_perm['perm_modulo'];
			}
			$s_ocomon = 0;
			$s_invmon = 0;
			for ($i=0;$i<count($s_permissoes); $i++){
				if($s_permissoes[$i] == 1) $s_ocomon = 1;
				if($s_permissoes[$i] == 2) $s_invmon = 1;
			}

			$sqlFormatBar = "SELECT * FROM config";
			$execFormatBar = mysql_query($sqlFormatBar) or die ('N�O FOI POSS�VEL ACESSAR A TABELA DE CONFIGURA��ES DO SISTEMA!');
			$rowFormatBar = mysql_fetch_array($execFormatBar);
			if (strpos($rowFormatBar['conf_formatBar'],'%oco%')) {
				$formatBarOco = 1;
			} else {
				$formatBarOco = 0;
			}
			if (strpos($rowFormatBar['conf_formatBar'],'%mural%')) {
				$formatBarMural = 1;
			} else {
				$formatBarMural = 0;
			}



			$_SESSION['s_logado'] = $s_logado;
			$_SESSION['s_usuario'] = $s_usuario;
			$_SESSION['s_uid'] = $s_uid;
			$_SESSION['s_senha'] = $s_senha;
			$_SESSION['s_nivel'] = $s_nivel;
			$_SESSION['s_nivel_desc'] = $s_nivel_desc;
			$_SESSION['s_area'] = $s_area;
			$_SESSION['s_uareas'] = $s_uareas;
			$_SESSION['s_permissoes'] = $s_permissoes;
			$_SESSION['s_area_admin'] = $s_area_admin;
			$_SESSION['s_ocomon'] = $s_ocomon;
			$_SESSION['s_invmon'] = $s_invmon;


			$_SESSION['s_formatBarOco'] = $formatBarOco;
			$_SESSION['s_formatBarMural'] = $formatBarMural;

			$_SESSION['s_language'] = $rowFormatBar['conf_language'];

			$sqlStyles = "SELECT * FROM temas t, uthemes u  WHERE u.uth_uid = ".$_SESSION['s_uid']." and t.tm_id = u.uth_thid";
			$execStyles = mysql_query($sqlStyles) or die('ERRO NA TENTATIVA DE RECUPERAR AS INFORMA��ES DO TEMA!<BR>'.$sqlStyles);
			$rowSty = mysql_fetch_array($execStyles);
			$regs = mysql_num_rows($execStyles);
			if ($regs==0){ //SE N�O ENCONTROU TEMA ESPEC�FICO PARA O USU�RIO
				unset($rowSty);
				$sqlStyles = "SELECT * FROM styles";
				$execStyles = mysql_query($sqlStyles);
				$rowSty = mysql_fetch_array($execStyles);
			}

			$_SESSION['s_colorDestaca'] = $rowSty['tm_color_destaca'];
			$_SESSION['s_colorMarca'] = $rowSty['tm_color_marca'];

			print "<script>redirect('../../index.php?".session_id()."');</script>";
		} else {

			print "<script>redirect('../../index.php?usu=".$_POST['login']."&inv=1');</script>";
			$conec->desconLDAP();
			$conecSec->desconLDAP();
			exit;
		}
		$conec->desconLDAP();
		$conecSec->desconLDAP();

	} else {

		if (senha_system($_POST['login'],$_POST['password'],'usuarios')=="ok")
		{

		        $s_usuario=$_POST['login'];
		        $s_senha=$_POST['password'];

			$queryOK = "SELECT u.*, n.*,s.* FROM usuarios u left join sistemas as s on u.AREA = s.sis_id ".
							"left join nivel as n on n.nivel_cod =u.nivel WHERE u.login = '".$_POST['login']."'";

			$resultadoOK = mysql_query($queryOK) or die('IMPOSS�VEL ACESSAR A BASE DE DADOS DE USU�RIOS: LOGIN.PHP');
			$row = mysql_fetch_array($resultadoOK);
			$s_nivel = $row['nivel'];

			if ($s_nivel<4){ //Verifica se n�o est� desabilitado
				$s_logado=1;
			}

			$s_nivel_desc = $row['nivel_nome'];
			$s_area = $row['AREA'];
			$s_uid = $row['user_id'];
			$s_area_admin =  $row['user_admin'];


			/*VERIFICA EM QUAIS �REAS O USU�RIO EST� CADASTRADO*/
			$qryUa = "SELECT * FROM usuarios_areas where uarea_uid=".$s_uid.""; //and uarea_sid=".$s_area."
			$execUa = mysql_query($qryUa) or die('IMPOSS�VEL ACESSAR A BASE DE USU�RIOS 02: LOGIN.PHP');
			$uAreas = "".$s_area.",";
			while ($rowUa = mysql_fetch_array($execUa)){
				$uAreas.=$rowUa['uarea_sid'].",";
			}
			$uAreas = substr($uAreas,0,-1);
			$s_uareas = $uAreas;

			/*CHECA QUAIS OS M�DULOS PODEM SER ACESSADOS PELAS �REAS QUE O USU�RIO PERTENCE*/
			$qry = "SELECT * FROM permissoes where perm_area in (".$uAreas.")";
			$exec = mysql_query($qry) or die('IMPOSS�VEL ACESSAR A BASE DE PERMISS�ES: LOGIN.PHP');


			while($row_perm = mysql_fetch_array($exec)){
				$s_permissoes[]=$row_perm['perm_modulo'];
			}
			$s_ocomon = 0;
			$s_invmon = 0;
			for ($i=0;$i<count($s_permissoes); $i++){
				if($s_permissoes[$i] == 1) $s_ocomon = 1;
				if($s_permissoes[$i] == 2) $s_invmon = 1;
			}

			$sqlFormatBar = "SELECT * FROM config"; //INFO FROM GENERAL CONF
			$execFormatBar = mysql_query($sqlFormatBar) or die ('N�O FOI POSS�VEL ACESSAR A TABELA DE CONFIGURA��ES DO SISTEMA!');
			$rowFormatBar = mysql_fetch_array($execFormatBar);
			if (strpos($rowFormatBar['conf_formatBar'],'%oco%')) {
				$formatBarOco = 1;
			} else {
				$formatBarOco = 0;
			}
			if (strpos($rowFormatBar['conf_formatBar'],'%mural%')) {
				$formatBarMural = 1;
			} else {
				$formatBarMural = 0;
			}

			$_SESSION['s_logado'] = $s_logado;
			$_SESSION['s_usuario'] = $s_usuario;
			$_SESSION['s_uid'] = $s_uid;
			$_SESSION['s_senha'] = $s_senha;
			$_SESSION['s_nivel'] = $s_nivel;
			$_SESSION['s_nivel_desc'] = $s_nivel_desc;
			$_SESSION['s_area'] = $s_area;
			$_SESSION['s_uareas'] = $s_uareas;
			$_SESSION['s_permissoes'] = $s_permissoes;
			$_SESSION['s_area_admin'] = $s_area_admin;
			$_SESSION['s_ocomon'] = $s_ocomon;
			$_SESSION['s_invmon'] = $s_invmon;
			$_SESSION['s_allow_change_theme'] = $rowFormatBar['conf_allow_change_theme'];

			$_SESSION['s_formatBarOco'] = $formatBarOco;
			$_SESSION['s_formatBarMural'] = $formatBarMural;

			$_SESSION['s_language'] = $rowFormatBar['conf_language'];

			$_SESSION['s_date_format'] = $rowFormatBar['conf_date_format'];

			$_SESSION['s_paging_full'] = 0;


			$sqlStyles = "SELECT * FROM temas t, uthemes u  WHERE u.uth_uid = ".$_SESSION['s_uid']." and t.tm_id = u.uth_thid";
			$execStyles = mysql_query($sqlStyles) or die('ERRO NA TENTATIVA DE RECUPERAR AS INFORMA��ES DO TEMA!<BR>'.$sqlStyles);
			$rowSty = mysql_fetch_array($execStyles);
			$regs = mysql_num_rows($execStyles);
			if ($regs==0){ //SE N�O ENCONTROU TEMA ESPEC�FICO PARA O USU�RIO
				unset($rowSty);
				$sqlStyles = "SELECT * FROM styles";
				$execStyles = mysql_query($sqlStyles);
				$rowSty = mysql_fetch_array($execStyles);
			}


			$_SESSION['s_colorDestaca'] = $rowSty['tm_color_destaca'];
			$_SESSION['s_colorMarca'] = $rowSty['tm_color_marca'];

			print "<script>redirect('../../index.php?".session_id()."');</script>";
			//print "<script>redirect('../../index.php');</script>";

		}
		else
		{
				print "<script>redirect('../../index.php?usu=".$_POST['login']."&inv=1');</script>";
				exit;
		}
	}



?>
