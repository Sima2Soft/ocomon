<?php
 /*                        Copyright 2005 Fl�vio Ribeiro

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
*/session_start();

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");
	print "<link rel='stylesheet' href='../../includes/css/calendar.css.php' media='screen'></LINK>";
	$_SESSION['s_page_ocomon'] = $_SERVER['PHP_SELF'];

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],2);

	if (!isset($_POST['ok'])) { //&& $_POST['ok'] != 'Pesquisar')
		print "<html>";
		print "<head><script language=\"JavaScript\" src=\"../../includes/javascript/calendar.js\"></script></head>";
		print "	<BR><BR>";
		print "	<B><center>:::Relat�rio de Indicadores por n�veis de status dos chamados:::</center></B><BR><BR>";
		print "		<FORM action='".$_SERVER['PHP_SELF']."' method='post' name='form1' onSubmit=\"return valida()\" >"; //onSubmit=\"return valida()\"
		print "		<TABLE border='0' align='center' cellspacing='2'  bgcolor=".BODY_COLOR." >";
		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">�rea Respons�vel:</td>";


		print "					<td><Select name='area' class='select' size=1 onChange=\"fillSelectFromArray(this.form.operador, ((this.selectedIndex == -1) ? null : team[this.selectedIndex-1]));\">";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										$query="select * from sistemas where sis_status not in (0) order by sistema";
										$resultado=mysql_query($query);
										$linhas = mysql_num_rows($resultado);
										while($row=mysql_fetch_array($resultado))
										{
											print "<option value=".$row['sis_id']."";
											if ($row['sis_id']==$_SESSION['s_area']) print " selected";
											print ">".$row['sistema']."</option>";
										} // while
		print "		 				</Select>";
		print "					 </td>";
		print "				</tr>";

		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Operador:</td>";
		print "					<td><Select name='operador' class='select' size='1'>";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										$query="select * from usuarios order by nome";
										$resultado=mysql_query($query);
										$linhas = mysql_num_rows($resultado);
										while($row=mysql_fetch_array($resultado))
										{
											//$sis_id=$row['user_id'];
											//$sis_name=$row['nome'];
											print "<option value=".$row['user_id'].">".$row['nome']."</option>";
										} // while
		print "		 				</Select>";
		//	print "						<input type='checkbox' name='opTodos'>Todos";
		print "					 </td>";
		print "				</tr>";


			print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Local:</td>";
		print "					<td><Select name='local' class='select' size='1'>";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										$query="select * from localizacao where loc_status not in (0) order by local";
										$resultado=mysql_query($query);
										$linhas = mysql_num_rows($resultado);
										while($row=mysql_fetch_array($resultado))
										{
											//$sis_id=$row['user_id'];
											//$sis_name=$row['nome'];
											print "<option value=".$row['loc_id'].">".$row['local']."</option>";
										} // while
		print "		 				</Select>";
		print "					 </td>";
		print "				</tr>";


		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Data Inicial:</td>";
		//print "					<td ><INPUT type='text' name='d_ini' class='data' id='idD_ini'><a href=\"javascript:cal1.popup();\"><img height='14' width='14' src='../../includes/javascript/img/cal.gif' width='16' height='16' border='0' alt='Selecione a data'></a></td>";
		print "					<td><INPUT type='text' name='d_ini' class='data' id='idD_ini' value='01-".date("m-Y")."'><a onclick=\"displayCalendar(document.forms[0].d_ini,'dd-mm-yyyy',this)\"><img height='14' width='14' src='../../includes/javascript/img/cal.gif' width='16' height='16' border='0' alt='Selecione a data'></a></td>";
		print "				</tr>";
		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Data Final:</td>";
		print "					<td><INPUT type='text' name='d_fim' class='data' id='idD_fim' value='".date("d-m-Y")."'><a onclick=\"displayCalendar(document.forms[0].d_fim,'dd-mm-yyyy',this)\"><img height='14' width='14' src='../../includes/javascript/img/cal.gif' width='16' height='16' border='0' alt='Selecione a data'></a></td>";
		print "				</tr>";

		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Tipo de relat�rio:</td>";
		print "					<td><select name='saida' class='data'>";
		print "							<option value=-1 selected>Normal</option>";
	//	print "							<option value=1>Relat�rio 1 linha</option>";
		print "						</select>";
		print "					</td>";
		print "				</tr>";
		print "<tr><td colspan='2'><input type='checkbox' name='novaJanela' title='Selecione para que a sa�da seja em uma nova janela.'>Nova Janela (para impress�o)<td><tr>";
		print "		</TABLE><br>";

		print "		<TABLE align='center'>";
		print "			<tr>";
		print "	            <td>";
		//print"					<input type='hidden' name='sis_name' value='$sis_name' ";
		print "					<input type='submit'  class='button' value='Pesquisar' name='ok' >";//onClick=\"submitForm();\"
		print "	            </TD>";
		print "	            <td>";
		print "					<INPUT type='reset'  class='button' value='Limpar campos' name='cancelar'>";
		print "				</TD>";
		print "			</tr>";
		print "	    </TABLE>";
		print "</form>";
		print "</BODY>";
		print "</html>";
	}//if !isset($_POST['ok'])

	else { //if $ok==Pesquisar


		print "<html><body class='relatorio'>";

		//SLA 1 � menor do que o SLA 2 - VERDE
		$sla3 = 6; //INICIO DO VERMELHO - Tempo de SOLU��O
		$sla2 = 4; //IN�CIO DO AMARELO
		$slaR3 = 3600; //Tempo de RESPOSTA em segundos VERMELHO
		$slaR2 = 1800; //AMARELO

		$corSla1 = "green";
		$corSla2 = "orange";
		$corSla3 = "red";
		$percLimit = 20; //Limite em porcento que um chamado pode estourar para ficar no SLA2 antes de ficar no vermelho

		$chamadosSgreen = array();
		$chamadosSyellow = array();
		$chamadosSred = array();

		$chamadosRgreen = array();
		$chamadosRyellow = array();
		$chamadosRred = array();

		$hora_inicio = ' 00:00:00';
		$hora_fim = ' 23:59:59';

		$query = "";

    		$query = "SELECT o.numero, o.data_abertura, o.data_atendimento, o.data_fechamento, o.sistema as cod_area, ".
					"s.sistema as area, 	p.problema as problema, sl.slas_desc as sla, sl.slas_tempo as tempo , l.*, pr.*, ".
					"res.slas_tempo as resposta, 	u.nome as operador ".
				"FROM localizacao as l left join prioridades as pr on pr.prior_cod = l.loc_prior left join sla_solucao as res on ".
					"res.slas_cod = pr.prior_sla, problemas as p left join sla_solucao as sl on p.prob_sla = sl.slas_cod, ".
					"ocorrencias as o, sistemas as s, usuarios as u ".
				"WHERE o.status=4 and s.sis_id=o.sistema and p.prob_id = o.problema  and o.local =l.loc_id and ".
					"o.operador=u.user_id";


		if (isset($_POST['operador'])) {
			if (!empty($_POST['operador']) && $_POST['operador'] != -1)
				$query.= " AND o.operador=".$_POST['operador']." ";

		}
		if (isset($_POST['local'])) {
			if (!empty($_POST['local']) && $_POST['local'] != -1)
				$query.= " AND o.local=".$_POST['local']." ";

		}
		if (isset($_POST['area'])) {
			if (!empty($_POST['area']) && $_POST['area'] != -1 && ($_SESSION['s_nivel'] == 1 || isIn($_POST['area'], $_SESSION['s_uareas'])) )
				$query.= " AND o.sistema=".$_POST['area']." ";

		} else
		if (($_SESSION['s_nivel']!=1) && !isIn($_POST['area'], $_SESSION['s_uareas'] ) ) {
			print "<script>window.alert('Voc� s� pode consultar os dados da sua �rea!');</script>";
			print "<script>history.back();</script>";
			exit;
		}


		if ((!isset($_POST['d_ini'])) || ((!isset($_POST['d_fim'])))) {

			print "<script>window.alert('O per�odo deve ser informado!'); history.back();</script>";
		} else {
			$d_ini_nova = converte_dma_para_amd(str_replace("-","/",$_POST['d_ini']));
			$d_fim_nova = converte_dma_para_amd(str_replace("-","/",$_POST['d_fim']));

			$d_ini_completa = $d_ini_nova.$hora_inicio;
			$d_fim_completa = $d_fim_nova.$hora_fim;

			if($d_ini_completa <= $d_fim_completa) {

				//$dias_va  //Alterado de data_abertura para data_fechamento -- ordena mudou de fechamento para abertura
				$query .= " AND o.data_fechamento >= '".$d_ini_completa."' and o.data_fechamento <= '".$d_fim_completa."' and ".
						"o.data_atendimento is not null order by o.data_abertura";
				$resultado = mysql_query($query);       // print "<b>Query--></b> $query<br><br>";
				$linhas = mysql_num_rows($resultado);  //print "Linhas: $linhas";

		    		if($linhas==0) {

					print "<script>window.alert('N�o h� dados no per�odo informado!'); history.back();</script>";
		       		} else  { //if($linhas==0)
			   		$campos=array();

					switch($_POST['saida'])
					{
						case -1:
							$criterio = "<br>";
							$sql_area = "select * from sistemas where sis_id = '".$_POST['area']."'";
							$exec_area = mysql_query($sql_area);
							$row_area = mysql_fetch_array($exec_area);
							if (!empty($row_area['sistema'])) {
								$criterio.="�REA: ".$row_area['sistema']."";
							}

						if (!empty($_POST['operador']) and ($_POST['operador'] !=-1)){
				                        $sqlOp = "Select * from usuarios where user_id = ".$_POST['operador']."";
							$execOp= mysql_query($sqlOp);
							$rowOp = mysql_fetch_array($execOp);
							$criterio.= "- Operador: ".$rowOp['nome'];
						}
						if (!empty($_POST['local']) and ($_POST['local'] !=-1)){
							$sqlLoc = "Select * from localizacao where loc_id = ".$_POST['local']."";
							$execLoc = mysql_query($sqlLoc);
							$rowLoc = mysql_fetch_array($execLoc);
							$criterio.="- Local: ".$rowLoc['local']."";
						}
							//echo "<br><br>";
							$background = '#C7D0D9';
							print "<p class='titulo'>RELAT�RIO DE SLAS: INDICADORES DE RESPOSTA e INDICADORES DE SOLU��O".$criterio."</p>";
                            			print "<table class='centro' cellspacing='0' border='1' >";

                           	 		print "<tr bgcolor='".$background."'><td ><B>NUMERO</td>
							<td ><b><a title='tempo de resposta'>T RESPOSTA VALIDO</a></td>
							<td ><b><a title='tempo de solu��o'>T SOLUCAO VALIDO</a></td></B>
							<td ><b><a title='tempo definido para resposta para cada setor'>SLA Resposta</a></td></B>
							<td ><b><a title='tempo definido para solu��o para cada problema'>SLA Solu��o</a></td></B>
							<td ><b><a title='indicador de resposta'>Resposta</a></td></B>
							<td ><b><a title='indicador de solu��o'>Solu��o</a></td></B>
							<td ><b><a title='indicador de solu��o a partir da primeira resposta'>SOL - RESP</a></td></B>
							<td ><b><a title='tempo em que o chamado esteve pendente no usu�rio'>Depend�ncia ao usu�rio</a></td></B>
							<td ><b><a title='tempo em que o chamado esteve pendente por algum servi�o de terceiros'>Depend�ncia de terceiros</a></td></B>
							<td ><b><a title='tempo em equipamento de backup ou alterado ap�s encerramento'>Fora de depend�ncia</a></td></B>
							<td ><b><a title='Tempo de solu��o menos o tempo em pend�ncia do usu�rio'>T Solucao recalculado</a></td></B>
							<td ><b><a title='indicador atualizado descontando a pend�ncia do usu�rio'>Indicador atualizado</a></td></B>
							</tr>";

                           //INICIALIZANDO CONTADORES!!
                        $sla_green=0;
			$sla_red=0;
			$sla_yellow=0;
			$slaR_green=0;
			$slaR_red=0;
			$slaR_yellow=0;
			$c_slaS_blue = 0;
			$c_slaS_yellow = 0;
			$c_slaS_red = 0;
			$c_slaR_blue = 0;
			$c_slaR_yellow = 0;
			$c_slaR_red = 0;
			$c_slaM_blue = 0;
			$c_slaM_yellow = 0;
			$c_slaM_red = 0;
			$c_slaR_checked = 0;
			$c_slaS_checked = 0;
			$c_slaM_checked = 0;
			$imgSlaS = 'checked.png';
			$imgSlaR = 'checked.png';
			$imgSlaM = 'checked.png';

			$c_slaSR_blue = 0;
			$c_slaSR_yellow = 0;
			$c_slaSR_red = 0;
			$c_slaSR_checked = 0;

			$dtS = new dateOpers; //solu��o
			$dtR = new dateOpers; //resposta
			$dtM = new dateOpers; //tempo entre resposta e solu��o
                        $cont = 0;
                        while ($row = mysql_fetch_array($resultado)) {
				// if (array_key_exists($row['cod_area'],$H_horarios)){  //verifica se o c�digo da �rea possui carga hor�ria definida no arquivo config.inc.php
					// $area = $row['cod_area']; //Recebe o valor da �rea de atendimento do chamado
				// } else $area = 1; //Carga hor�ria default definida no arquivo config.inc.php
				$areaReal=$row['cod_area'];
				$area = "";
				$area=testaArea($_POST['area'],$row['cod_area'],$H_horarios);

				$dtR->setData1($row['data_abertura']);
				$dtR->setData2($row['data_atendimento']);
				$dtR->tempo_valido($dtR->data1,$dtR->data2,$H_horarios[$area][0],$H_horarios[$area][1],$H_horarios[$area][2],$H_horarios[$area][3],"H");

				$dtS->setData1($row['data_abertura']);
				$dtS->setData2($row['data_fechamento']);
				$dtS->tempo_valido($dtS->data1,$dtS->data2,$H_horarios[$area][0],$H_horarios[$area][1],$H_horarios[$area][2],$H_horarios[$area][3],"H");
				$t_horas = $dtS->diff["hValido"];

				$dtM->setData1($row['data_atendimento']);
				$dtM->setData2($row['data_fechamento']);
				$dtM->tempo_valido($dtM->data1,$dtM->data2,$H_horarios[$area][0],$H_horarios[$area][1],$H_horarios[$area][2],$H_horarios[$area][3],"H");

				$sql_status = "SELECT sum(T.ts_tempo) as segundos, sec_to_time(sum(T.ts_tempo)) as tempo, ".
								"T.ts_status as codStat, A.sistema as area, CAT.stc_desc as dependencia, CAT.stc_cod as cod_dependencia ".
							"FROM ocorrencias as O, tempo_status as T, `status` as S, sistemas as A, status_categ as CAT ".
							"WHERE O.numero = T.ts_ocorrencia and O.numero = ".$row['numero']." and S.stat_id = T.ts_status ".
								"and S.stat_cat = CAT.stc_cod and O.sistema = A.sis_id and O.sistema =".$areaReal." and O.status = 4 ".
								" and O.data_fechamento >= '".$d_ini_completa."' and O.data_fechamento <='".$d_fim_completa."' ".
							"GROUP BY A.sis_id,CAT.stc_desc ".
							"ORDER BY CAT.stc_cod";
				$exec_sql_status = mysql_query($sql_status);

				//PARA CHECAR O SLA DO PROBLEMA -  TEMPO DE SOLU��O
				$t_segundos_total = $dtS->diff["sValido"];

				if ($row['tempo'] !=""){
					if ($t_segundos_total <= ($row['tempo']*60))  { //transformando em segundos
						//$corSLA = $corSla1;
						$imgSlaS = 'sla1.png';
						$c_slaS_blue++;
					} else
					if ($t_segundos_total <= ( ($row['tempo']*60) + (($row['tempo']*60) *$percLimit/100)) ){ //mais 20%
						//$corSLA = $corSla2;
						$imgSlaS = 'sla2.png';
						$c_slaS_yellow++;
					} else {
						//$corSLA = $corSla3;
						$imgSlaS = 'sla3.png';
						$c_slaS_red++;
					}
				} else {
					$imgSlaS = 'checked.png';
					$c_slaS_checked++;
				}
				//PARA CHECAR O SLA DO SETOR - TEMPO DE RESPOSTA

				$t_segundos_resposta = $dtR->diff["sValido"];
				if ($row['resposta'] != "") {
					if ($t_segundos_resposta <= ($row['resposta']*60))  { //transformando em segundos
						//$corSLA = $corSla1;
						$imgSlaR = 'sla1.png';
						$c_slaR_blue++;
						$chamadosRgreen[]=$row['numero'];
					} else
					if ($t_segundos_resposta <= ( ($row['resposta']*60) + (($row['resposta']*60) *$percLimit/100)) ){ //mais 20%
						//$corSLA = $corSla2;
						$imgSlaR = 'sla2.png';
						$c_slaR_yellow++;
						$chamadosRyellow[]=$row['numero'];
					} else {
						//$corSLA = $corSla3;
						$imgSlaR = 'sla3.png';
						$c_slaR_red++;
						$chamadosRred[]=$row['numero'];
					}
				} else {
					$c_slaR_checked++;
					$imgSlaR = 'checked.png';
				}

				$t_segundos_m = $dtM->diff["sValido"];

				if ($row['tempo'] !=""){ //est� em minutos
					if ($t_segundos_m <= ($row['tempo']*60))  { //transformando em segundos
						$imgSlaM = 'sla1.png';
						$c_slaM_blue++;
					} else if ($t_segundos_m <= ( ($row['tempo']*60) + (($row['tempo']*60) *$percLimit/100)) ){ //mais 20%
						$imgSlaM = 'sla2.png';
						$c_slaM_yellow++;
					} else {
						$imgSlaM = 'sla3.png';
						$c_slaM_red++;
					}
				} else {
					$imgSlaM = 'checked.png';
					$c_slaM_checked++;
				}

				if ($t_horas>=$sla3) {//>=6
					$cor = $corSla3;
					$sla_red++;
				} else
				if ($t_horas>=$sla2) {
					$cor = $corSla2;
					$sla_yellow++;
				} else {
					$cor = $corSla1;
					$sla_green++;
				}
				$t_resp = $dtR->diff["sValido"];

				if ($t_resp>=$slaR3) {//>=6
					$corR = $corSla3;
					$slaR_red++;
				} else
				if ($t_resp>=$slaR2) {
					$corR = $corSla2;
					$slaR_yellow++;
				} else {
					$corR = $corSla1;
					$slaR_green++;
				}

				$total_sol_segundos = "";
				$total_res_segundos = "";
				$total_res_valido = "";
				$total_sol_valido = "";

				$total_sol_segundos+= $dtS->diff["sFull"];
				$total_res_segundos+=$dtR->diff["sFull"];
				$total_res_valido+=$dtR->diff["sValido"];
				$total_sol_valido+=$dtS->diff["sValido"];

				//Linhas de dados do relat�rio
				print "<tr id='linha".$cont."' onMouseOver=\"destaca('linha".$cont."', '".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linha".$cont."');\"  onMouseDown=\"marca('linha".$cont."', '".$_SESSION['s_colorMarca']."');\">";

				print "<td ><a onClick= \"javascript: popup_alerta('mostra_consulta.php?popup=true&numero=".$row['numero']."')\"><font color='blue'>".$row['numero']."</font></a></td>
					<td ><font color='".$corR."'>".$dtR->tValido."</font></td>
					<td ><font color='".$corR."'>".$dtS->tValido."</font></td>
					<td >".$row['resposta']." minutos</font></td>
					<td >".$row['sla']."</font></td>
					<td align='center'><a onClick=\"javascript:popup('mostra_hist_status.php?popup=true&numero=".$row['numero']."')\"><img height='14' width='14' src='../../includes/imgs/".$imgSlaR."'></a></td>
					<td align='center'><a onClick=\"javascript:popup('mostra_hist_status.php?popup=true&numero=".$row['numero']."')\"><img height='14' width='14' src='../../includes/imgs/".$imgSlaS."'></a></td>
					<td align='center'><a onClick=\"javascript:popup('mostra_hist_status.php?popup=true&numero=".$row['numero']."')\"><img height='14' width='14' src='../../includes/imgs/".$imgSlaM."'></a></td>";

				$dependUser = 0;
				$dependTerc = 0;
				$dependNone = 0;
				while ($row_status = mysql_fetch_array($exec_sql_status)){
					//print $row_status['dependencia'].": ".$row_status['tempo']." | ";
					if ($row_status['cod_dependencia'] == 1) {//dependente ao usu�rio
						$dependUser+= $row_status['segundos'];
					} else
					if ($row_status['cod_dependencia'] == 3 ){ //dependente de terceiros
						$dependTerc+=$row_status['segundos'];
					} else
					if ($row_status['cod_dependencia'] == 4 ){ //dependente de terceiros
						$dependNone+=$row_status['segundos'];
					}
				}
				//print "</td>";
				print "<td >";//coluna do tempo vinculado ao usu�rio
				if ($dependUser != 0)
					$dependUser = $dtS->secToHour($dependUser); else
					$dependUser = "----";
				print $dependUser;
				print "</td>";
				print "<td >";//coluna do tempo vinculado a terceiros
				if ($dependTerc != 0)
					$dependTerc = $dtS->secToHour($dependTerc); else
					$dependTerc = "----";
				print $dependTerc;
				print "</td>";

				print "<td >";//coluna do tempo independente (encerrados - em backup..)
				if ($dependNone != 0)
					$dependNone = $dtS->secToHour($dependNone); else
					$dependNone = "----";
				print $dependNone;
				print "</td>";

				print "<td >";//Solu��o recalculada
				$solucTotal = $dtS->diff["sValido"];
				//$solucRecalc = $dtS->secToHour($solucTotal);
				$solucRecalc = $solucTotal;
				$imgSlaSR=$imgSlaS;//Solu��o recalculada

				if ((strpos($dependUser,":")) || (strpos($dependNone,":"))){
					if (strpos($dependUser,":")) {
						$dependUser = $dtS->hourToSec($dependUser);
						$solucRecalc-=$dependUser;
						//$solucRecalc = $dtS->secToHour($solucRecalc);
					}
					if (strpos($dependNone,":")) {
						$dependNone = $dtS->hourToSec($dependNone);
						$solucRecalc-=$dependNone;
						//$solucRecalc = $dtS->secToHour($solucRecalc);
					}
				}
				if ($solucRecalc <0) $solucRecalc*=-1;

				$solucRecalc = $dtS->secToHour($solucRecalc);

				print $solucRecalc; //Novo tempo de solu��o - recalculado tirando as depend�ncias ao usu�rio ou status independentes

				if ($row['tempo'] !=""){
					if ($dtS->hourToSec($solucRecalc) <= ($row['tempo']*60))  { //transformando em segundos
							$imgSlaSR = 'sla1.png';
							$c_slaSR_blue++;
							$chamadosSgreen[]= $row['numero'];
					}
					else if ($dtS->hourToSec($solucRecalc) <= ( ($row['tempo']*60) + (($row['tempo']*60) *$percLimit/100)) ){ //mais 20%
							$imgSlaSR = 'sla2.png';
							$c_slaSR_yellow++;
							$chamadosSyellow[]= $row['numero'];
					} else {
						$imgSlaS = 'sla3.png';
						$c_slaSR_red++;
						$chamadosSred[]= $row['numero'];
					}
				} else {
					$imgSlaSR = 'checked.png';
					$c_slaSR_checked++;
				}
				print "</td>";
				print "<td ><img height='14' width='14' src='../../includes/imgs/".$imgSlaSR."'></td>";

				print "</tr>";
				$cont++;
			}//while chamados

			$media_resposta_geral = $dtR->secToHour(floor($total_res_segundos/$linhas));
			$media_solucao_geral = $dtS->secToHour(floor($total_sol_segundos/$linhas));
			$media_resposta_valida = $dtR->secToHour(floor($total_res_valido/$linhas));
			$media_solucao_valida = $dtS->secToHour(floor($total_sol_valido/$linhas));

			print "<tr><td colspan=5><b>M�DIAS -></td><td ><b>".$media_resposta_valida."</td><td ><B>".$media_solucao_valida."</td></tr>";

			//MEDIAS DE SOLU��O
			$perc_ate_sla2=round((($sla_green*100)/$linhas),2);
			$perc_ate_sla3=round((($sla_yellow*100)/$linhas),2);
			$perc_mais_sla3=round((($sla_red*100)/$linhas),2);
			//MEDIAS DE RESPOSTA
			$perc_ate_slaR2=round((($slaR_green*100)/$linhas),2);
			$perc_ate_slaR3=round((($slaR_yellow*100)/$linhas),2);
			$perc_mais_slaR3=round((($slaR_red*100)/$linhas),2);

			$slaR2M = $slaR2/60;
			$slaR3M = $slaR3/60;
			//TOTAL DE HORAS V�LIDAS NO PER�ODO:
			$area_fixa = 1;//Padrao
			$dt = new dateOpers;
			$dt->setData1($d_ini_completa);
			$dt->setData2($d_fim_completa);
			$dt->tempo_valido($dt->data1,$dt->data2,$H_horarios[$area_fixa][0],$H_horarios[$area_fixa][1],$H_horarios[$area_fixa][2],$H_horarios[$area_fixa][3],"H");
			$hValido = $dt->diff["hValido"]+1; //Como o per�odo passado n�o � arredondado (xx/xx/xx 23:59:59) � necess�rio arrendondar o total de horas.
			print "</table>";


			##TRANSFORMA��ES DOS ARRAYS

			$numerosRed=putComma($chamadosSred);
			$numerosYellow=putComma($chamadosSyellow);
			$numerosGreen=putComma($chamadosSgreen);

			$numerosRred=putComma($chamadosRred);
			$numerosRyellow=putComma($chamadosRyellow);
			$numerosRgreen=putComma($chamadosRgreen);



			## QUADROS DE ESTAT�STICAS

			print "<table align='center' cellspacing='0'>";
			print "  <tr><td colspan =4></td><td ></td></tr>";
			print "  <tr bgcolor='#C7D0D9'><td colspan=4 align=center><b>Per�odo: ".$_POST['d_ini']." a ".$_POST['d_fim']."</b></td></tr>";
			print "  <tr bgcolor='#C7D0D9'><td colspan=4 align=center><b>Total de horas v�lidas no per�odo: ".$hValido."</b></td></tr>";
			print "  <tr bgcolor='#C7D0D9'><td colspan='4' align='center'><b>Total de chamados fechados no per�odo: ".$linhas.".</b></td></tr>";
                        print "  <tr><td colspan =4></td></tr>";
			print "<tr><td ><b>Resposta em at� ".$slaR2M." minutos:</b></TD><td ><font color=".$corSla1."> ".$slaR_green." chamados = </font></TD><td ><font color=".$corSla1.">".$perc_ate_slaR2."%</font></td><td ></td></tr>";
			print "<tr><td ><b>Resposta em at� ".$slaR3M." minutos:</b></TD><td ><font color=".$corSla2."> ".$slaR_yellow." chamados = </font></TD><td ><font color=".$corSla2.">".$perc_ate_slaR3."%</font></td><td ></td></tr>";
			print "<tr><td ><b>Resposta em mais de ".$slaR3M." minutos:</b></TD><td ><font color=".$corSla3."> ".$slaR_red." chamados = </font></TD><td ><font color=".$corSla3.">".$perc_mais_slaR3."%</font></td><td ></td></tr>";
			print "  <tr><td colspan=4><hr></td></tr>";

			print "<tr><td ><b>Solu��o em at� ".$sla2." horas:</b></TD><td ><font color=".$corSla1."> ".$sla_green." chamados = </font></TD><td ><font color=".$corSla1.">".$perc_ate_sla2."%</font></td><td ></td></tr>";
			print "<tr><td ><b>Solu��o em at� ".$sla3." horas:</b></TD><td ><font color=".$corSla2."> ".$sla_yellow." chamados = </font></TD><td ><font color=".$corSla2.">".$perc_ate_sla3."%</font></td><td ></td></tr>";
			print "<tr><td ><b>Solu��o em mais de ".$sla3." horas:</TD><td ></b><font color=".$corSla3."> ".$sla_red." chamados = </font></TD><td ><font color=".$corSla3.">".$perc_mais_sla3."%</font></td><td ></td></tr>";
			print "  <tr><td colspan=4><hr></td></tr>";


			$perc_blueS = (round($c_slaS_blue*100/$linhas,2));
			$perc_yellowS = (round($c_slaS_yellow*100/$linhas,2));
			$perc_redS = (round($c_slaS_red*100/$linhas,2));
			$perc_checkedS = (round($c_slaS_checked*100/$linhas,2));
			$perc_blueR = (round($c_slaR_blue*100/$linhas,2));
			$perc_yellowR = (round($c_slaR_yellow*100/$linhas,2));
			$perc_redR = (round($c_slaR_red*100/$linhas,2));
			$perc_checkedR = (round($c_slaR_checked*100/$linhas,2));
			$perc_blueM = (round($c_slaM_blue*100/$linhas,2));
			$perc_yellowM = (round($c_slaM_yellow*100/$linhas,2));
			$perc_redM = (round($c_slaM_red*100/$linhas,2));
			$perc_checkedM = (round($c_slaM_checked*100/$linhas,2));

			$perc_blueSR = (round($c_slaSR_blue*100/$linhas,2));
                        $perc_yellowSR = (round($c_slaSR_yellow*100/$linhas,2));
			$perc_redSR = (round($c_slaSR_red*100/$linhas,2));
			$perc_checkedSR = (round($c_slaSR_checked*100/$linhas,2));


			print "<tr bgcolor='#C7D0D9'><td colspan='4' align='center'><b>Tempo de Resposta X SLA definidos</b></td></tr>";
			print "<tr><td ><b>Resposta dentro do SLA:</td><td ><font color='blue'><a onClick= \"javascript: popup_alerta('mostra_chamados.php?popup=true&numero=".$numerosRgreen."')\">".$c_slaR_blue."</a></font> chamados</b></td><td >".$perc_blueR."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla1.png'></td></tr>";
			print "<tr><td ><b>Resposta at� ".$percLimit."% acima do SLA:</td><td ><font color='blue'><a onClick= \"javascript: popup_alerta('mostra_chamados.php?popup=true&numero=".$numerosRyellow."')\">".$c_slaR_yellow."</a></font> chamados</b></td><td >".$perc_yellowR."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla2.png'></td></tr>";
			print "<tr><td ><b>Resposta acima de ".$percLimit."% do SLA:</td><td ><font color='blue'><a onClick= \"javascript: popup_alerta('mostra_chamados.php?popup=true&numero=".$numerosRred."')\">".$c_slaR_red."</a></font> chamados</b></td><td >".$perc_redR."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla3.png'></td></tr>";
			print "<tr><td ><b>Tempo de resposta n�o definido para o setor:</td><td >".$c_slaR_checked." chamados</b></td><td >".$perc_checkedR."%</td><td ><img height='14' width='14' src='../../includes/imgs/checked.png'></td></tr>";
			print "  <tr><td colspan=4><hr></td></tr>";


			print "<tr bgcolor='#C7D0D9'><td colspan='4' align='center'><b>Tempo de Solu��o X SLA definidos</b></td></tr>";
			print "<tr><td ><b>Solu��o dentro do SLA:</td><td >".$c_slaS_blue." chamados</b></td><td >".$perc_blueS."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla1.png'></td></tr>";
			print "<tr><td ><b>Solu��o at� ".$percLimit."% acima do SLA:</b></td><td >".$c_slaS_yellow." chamados</td><td >".$perc_yellowS."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla2.png'></td></tr>";
			print "<tr><td ><b>Solu��o acima de ".$percLimit."% do SLA:</b></td><td >".$c_slaS_red." chamados</td><td >".$perc_redS."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla3.png'></td></tr>";
			print "<tr><td ><b>Tempo de solu��o n�o definido para o problema:</b></td><td >".$c_slaS_checked." chamados</td><td >".$perc_checkedS."%</td><td ><img height='14' width='14' src='../../includes/imgs/checked.png'></td></tr>";
			print "  <tr><td colspan=4><hr></td></tr>";


			print "<tr bgcolor='#C7D0D9'><td colspan='4' align='center'><b>Tempo de Solu��o a partir da 1.� resposta</b></td></tr>";
			print "<tr><td ><b>Solu��o dentro do SLA:</td><td >".$c_slaM_blue." chamados</b></td><td >".$perc_blueM."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla1.png'></td></tr>";
			print "<tr><td ><b>Solu��o at� ".$percLimit."% acima do SLA:</b></td><td >".$c_slaM_yellow." chamados</td><td >".$perc_yellowM."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla2.png'></td></tr>";
			print "<tr><td ><b>Solu��o acima de ".$percLimit."% do SLA:</b></td><td >".$c_slaM_red." chamados</td><td >".$perc_redM."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla3.png'></td></tr>";
			print "<tr><td ><b>Tempo de solu��o n�o definido para o problema:</b></td><td >".$c_slaM_checked." chamados</td><td >".$perc_checkedM."%</td><td ><img height='14' width='14' src='../../includes/imgs/checked.png'></td></tr>";
			print "  <tr><td colspan=4><hr></td></tr>";

			print "<tr bgcolor='#C7D0D9'><td colspan='4' align='center'><b>Tempo de Solu��o recalculado</b></td></tr>";
			print "<tr><td ><b>Solu��o dentro do SLA:</td><td ><font color='blue'><a onClick= \"javascript: popup_alerta('mostra_chamados.php?popup=true&numero=".$numerosGreen."')\">".$c_slaSR_blue."</a></font> chamados</b></td><td >".$perc_blueSR."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla1.png'></td></tr>";
			print "<tr><td ><b>Solu��o at� ".$percLimit."% acima do SLA:</b></td><td ><font color='blue'><a onClick= \"javascript: popup_alerta('mostra_chamados.php?popup=true&numero=".$numerosYellow."')\">".$c_slaSR_yellow."</a></font> chamados</td><td >".$perc_yellowSR."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla2.png'></td></tr>";
			print "<tr><td ><b>Solu��o acima de ".$percLimit."% do SLA:</b></td><td ><font color='blue'><a onClick= \"javascript: popup_alerta('mostra_chamados.php?popup=true&numero=".$numerosRed."')\">".$c_slaSR_red."</a></font> chamados</td><td >".$perc_redSR."%</td><td ><img height='14' width='14' src='../../includes/imgs/sla3.png'></td></tr>";
			print "<tr><td ><b>Tempo de solu��o n�o definido para o problema:</b></td><td >".$c_slaSR_checked." chamados</td><td >".$perc_checkedSR."%</td><td ><img height='14' width='14' src='../../includes/imgs/checked.png'></td></tr>";
			print "  <tr><td colspan=4><hr></td></tr>";



			$sql_total_sec = "SELECT sum(T.ts_tempo) as segundos ".
						"FROM ocorrencias as O, tempo_status as T, `status` as S, sistemas as A ".
						"WHERE O.numero = T.ts_ocorrencia and S.stat_id = T.ts_status and O.sistema = A.sis_id and ".
							"O.sistema = ".$areaReal." and O.status = 4 and O.data_fechamento >=  '".$d_ini_completa."'  and ".
							"O.data_fechamento <= '".$d_fim_completa."' ".
						"GROUP BY A.sis_id,T.ts_status ".
						"ORDER BY segundos desc, A.sistema,T.ts_status";
			$exec_total_sec = mysql_query($sql_total_sec);
			$total_sec = 0;
			while ($row_total_sec = mysql_fetch_array($exec_total_sec)){
				$total_sec+=$row_total_sec['segundos'];
			}
				//$total_sol_valido;

			$sql_cada_status = "SELECT S.status as status,  sum(T.ts_tempo) as segundos, concat(sum(T.ts_tempo) /".$total_sec."*100,'%')".
								" as porcento, sec_to_time(sum(T.ts_tempo)) as tempo, T.ts_status as codStat, A.sistema as area ".
							"FROM ocorrencias as O, tempo_status as T, `status` as S, sistemas as A ".
							"WHERE O.numero = T.ts_ocorrencia and S.stat_id = T.ts_status and O.sistema = A.sis_id and ".
								"O.sistema =".$areaReal." and O.status = 4 and O.data_fechamento >=  '".$d_ini_completa."'  and ".
								"O.data_fechamento <= '".$d_fim_completa."' ".
							"GROUP BY A.sis_id,T.ts_status ".
							"ORDER BY segundos desc, A.sistema,T.ts_status";
			$exec_cada_status = mysql_query($sql_cada_status);
			print "<tr><td colspan='4' align='center'><b>Quadro de chamados por tempo em cada status</b></td></tr>";
			print "<tr bgcolor='#C7D0D9'><td >STATUS</td><td colspan='2'>TEMPO</td><td >PERCENTUAL</td></tr>";

			//print $sql_cada_status."<br>";
			while ($row_cada_status = mysql_fetch_array($exec_cada_status)) {
				print "<tr><td >".$row_cada_status['status']."</td><td colspan='2'>".$row_cada_status['tempo']."</td><td >".$row_cada_status['porcento']."</td></tr>";
			}
				print "  <tr><td colspan=4><hr></td></tr>";

			$sql_total_sec2 = "SELECT sum(T.ts_tempo) as segundos, sec_to_time(sum(T.ts_tempo)) as tempo, 	T.ts_status as codStat, ".
								"A.sistema as area, CAT.stc_desc as dependencia, CAT.stc_cod as cod_dependencia ".
							"FROM ocorrencias as O, tempo_status as T, `status` as S, sistemas as A, status_categ as CAT ".
							"WHERE O.numero = T.ts_ocorrencia and S.stat_id = T.ts_status and S.stat_cat = CAT.stc_cod and ".
								"O.sistema = A.sis_id and O.sistema =".$areaReal." and O.status = 4 and O.data_fechamento ".
								">='".$d_ini_completa."' and 	O.data_fechamento <='".$d_fim_completa."' ".
							"GROUP BY A.sis_id,CAT.stc_desc ".
							"ORDER BY segundos desc, A.sistema,T.ts_status	";
			$exec_total_sec2 = mysql_query($sql_total_sec2);
			$total_sec2 = 0;
			while ($row_total_sec2 = mysql_fetch_array($exec_total_sec2)){
				$total_sec2+=$row_total_sec2['segundos'];
			}



			$sql_vinc_status = "SELECT sum(T.ts_tempo) as segundos, sec_to_time(sum(T.ts_tempo)) as tempo, ".
								"concat(sum(T.ts_tempo) /".$total_sec2."*100,'%') as porcento, T.ts_status as codStat, ".
								"A.sistema as area, CAT.stc_desc as dependencia, CAT.stc_cod as cod_dependencia ".
							"FROM ocorrencias as O, tempo_status as T, `status` as S, sistemas as A, status_categ as CAT ".
							"WHERE O.numero = T.ts_ocorrencia and S.stat_id = T.ts_status and S.stat_cat = CAT.stc_cod and ".
								"O.sistema = A.sis_id and O.sistema =".$areaReal." and O.status = 4 and O.data_fechamento ".
								" >='".$d_ini_completa."' and 	O.data_fechamento <='".$d_fim_completa."' ".
							"GROUP BY A.sis_id,CAT.stc_desc ".
							"ORDER BY segundos desc, A.sistema,T.ts_status	";
			$exec_vinc = mysql_query($sql_vinc_status);

			print "<tr><td colspan='4' align='center'><b>Quadro chamados por tempo de depend�ncia de atendimento</b></td></tr>";
			print "<tr bgcolor='#C7D0D9'><td >DEPEND�NCIA</td><td colspan='2'>TEMPO</td><td >PERCENTUAL</td></tr>";
			while ($row_vinc = mysql_fetch_array($exec_vinc)) {
				print "<tr><td >".$row_vinc['dependencia']."</td><td colspan='2'>".$row_vinc['tempo']."</td><td >".$row_vinc['porcento']."</td></tr>";
			}
			print "<tr><td colspan='4'><hr></td></tr>";



			print "<tr><td colspan='4'><hr></td></tr>";
			print "</table>";
							break;

				case 1:
					$campos=array();
					$campos[]="numero";
					$campos[]="data_abertura";
					$campos[]="data_atendimento";
					$campos[]="data_fechamento";
					$campos[]="t_res_hora";
					$campos[]="t_sol_hora";
					$campos[]="t_res_valida_hor";
					$campos[]="t_sol_valida_hor";

					$cabs=array();
					$cabs[]="N�mero";
					$cabs[]="Abertura";
					$cabs[]="1� Resposta";
					$cabs[]="Fechamento";
					$cabs[]="T Resposta Total";
					$cabs[]="T Solu��o Total";
					$cabs[]="T Resposta V�lido";
					$cabs[]="T Solu��o V�lido";

					$logo="logo_unilasalle.gif";
					$msg1="Centro de Inform�tica";
					$msg2=date('d/m/Y H:m');
					$msg3= "Relat�rio de SLA's";

					gera_relatorio(1,$query,$campos,$cabs,$logo,$msg1, $msg2, $msg3);
					break;
			} // switch
		} //if($linhas==0)
	}//if  $d_ini_completa <= $d_fim_completa
	else 	{
		$aviso = "A data final n�o pode ser menor do que a data inicial. Refa�a sua pesquisa.";
		print "<script>mensagem('".$aviso."'); history.back();</script>";
	}
	}//if ((empty($d_ini)) and (empty($d_fim)))

	print "</body></html>";
}//if $ok==Pesquisar

?>
<script type='text/javascript'>
<!--
	team = new Array(
		<?
		$sql="select * from sistemas where sis_status NOT in (0) order by sistema";//Somente as �reas ativas
		$sql_result=mysql_query($sql);
		echo mysql_error();

		$conta = 0;
		$conta_sub = 0;

		$num=mysql_numrows($sql_result);
		while ($row_A=mysql_fetch_array($sql_result)){
		$conta=$conta+1;
			$cod_item=$row_A["sis_id"];
				echo "new Array(\n";
				$sub_sql="select * from usuarios u left join sistemas s on u.AREA = s.sis_id where u.AREA=".$cod_item." or u.AREA is null order by u.nome";
				$sub_result=mysql_query($sub_sql);
				$num_sub=mysql_numrows($sub_result);
				if ($num_sub>=1){
					echo "new Array(\"-->Todos<--\", -1),\n";
					while ($rowx=mysql_fetch_array($sub_result)){
						$codigo_sub=$rowx["user_id"];
						$sub_nome=$rowx["nome"];
					$conta_sub=$conta_sub+1;
						if ($conta_sub==$num_sub){
							echo "new Array(\"$sub_nome\", $codigo_sub)\n";
							$conta_sub="";
						}else{
							echo "new Array(\"$sub_nome\", $codigo_sub),\n";
						}
					}
				}else{
					echo "new Array(\"Qualquer\", -1)\n";
				}
			if ($num>$conta){
				echo "),\n";
			}
		}
		echo ")\n";
		echo ");\n";
		?>

		function fillSelectFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem) {
			var i, j;
			var prompt;
			// empty existing items
			for (i = selectCtrl.options.length; i >= 0; i--) {
				selectCtrl.options[i] = null;
			}
			prompt = (itemArray != null) ? goodPrompt : badPrompt;
			if (prompt == null) {
				j = 0;
			}
			else {
				selectCtrl.options[0] = new Option(prompt);
				j = 1;
			}
			if (itemArray != null) {
				// add new items
				for (i = 0; i < itemArray.length; i++) {
					selectCtrl.options[j] = new Option(itemArray[i][0]);
					if (itemArray[i][1] != null) {
						selectCtrl.options[j].value = itemArray[i][1];
					}
					j++;
				}
				// select first item (prompt) for sub list
				selectCtrl.options[0].selected = true;
			}
		}

		function popup(pagina)	{ //Exibe uma janela popUP
			x = window.open(pagina,'popup','dependent=yes,width=400,height=200,scrollbars=yes,statusbar=no,resizable=yes');
			x.moveTo(window.parent.screenX+100, window.parent.screenY+100);
			return false
		}

		function popup_alerta(pagina)	{ //Exibe uma janela popUP
                	x = window.open(pagina,'_blank','dependent=yes,width=700,height=470,scrollbars=yes,statusbar=no,resizable=yes');
	                x.moveTo(window.parent.screenX+50, window.parent.screenY+50);
                	return false
             	}

		function checar() {
			var checado = false;
			if (document.form1.novaJanela.checked){
		      	checado = true;
			} else {
				checado = false;
			}
			return checado;
		}

		//window.setInterval("checar()",1000);


		function valida(){
			var ok = validaForm('idD_ini','DATA-','Data Inicial',1);
			if (ok) var ok = validaForm('idD_fim','DATA-','Data Final',1);

			if (ok) submitForm();

			return ok;
		}

		function submitForm()
		{
			if (checar() == true) {
				document.form1.target = "_blank";
				document.form1.submit();
			} else {
				document.form1.target = "";
				document.form1.submit();
			}
		}
	-->
</script>

