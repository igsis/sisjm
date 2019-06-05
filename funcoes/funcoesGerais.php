<?php
date_default_timezone_set("Brazil/East");

	function habilitarErro()
	{
		@ini_set('display_errors', '1');
		error_reporting(E_ALL);
	}

	//saudacao inicial
	function saudacao()
	{
		$hora = date('H');
		if(($hora > 12) AND ($hora <= 18))
		{
			return "Boa tarde";
		}
		else if(($hora > 18) AND ($hora <= 23))
		{
			return "Boa noite";
		}
		else if(($hora >= 0) AND ($hora <= 4))
		{
			return "Boa noite";
		}
		else if(($hora > 4) AND ($hora <=12))
		{
			return "Bom dia";
		}
	}

	function retornaCamposObrigatorios($idEvento)
	{
		$vetor = [];
		$con = bancoMysqli();
		$query = "SELECT idPf, idPj, idTipoPessoa FROM evento WHERE id = '$idEvento'";
		$envio = mysqli_query($con, $query);
		while($row = mysqli_fetch_array($envio))
		{
			$idTipoPessoa = $row['idTipoPessoa'];

			if($idTipoPessoa == 1)
			{
				$idPessoa = $row['idPf'];
			}
			else
			{
				$idPessoa = $row['idPj'];
			}
		}
		if($idTipoPessoa == 2)
		{
			$consultaC = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '22' AND idPessoa = '$idPessoa' AND publicado = '1'"; // CNPJ
			$envioC = mysqli_query($con, $consultaC);
			$retornoCNPJ = mysqli_num_rows($envioC);
			$retornoCNPJ == 0 || $retornoCNPJ == NULL ? array_push($vetor,"CNPJ") : "";

			$consultaFC = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '31' AND idPessoa = '$idPessoa' AND publicado = '1'"; // fdc ccm
			$envioFC = mysqli_query($con, $consultaFC);
			$retornoFC = mysqli_num_rows($envioFC);
			$retornoFC == 0 || $retornoFC == NULL ? array_push($vetor,"FDC CCM") : "";

			$consultaCP = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '28' AND idPessoa = '$idPessoa' AND publicado = '1'"; // CPOM cad
			$envioCP = mysqli_query($con, $consultaCP);
			$retornoCP = mysqli_num_rows($envioCP);
			$retornoCP == 0 || $retornoCP == NULL ? array_push($vetor,"CPOM") : "";

			$consultaRGR = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '103' AND idPessoa = '$idPessoa' AND publicado = '1'"; // rg do representante
			$envioRGR = mysqli_query($con, $consultaRGR);
			$retornoRGR = mysqli_num_rows($envioRGR);
			$retornoRGR == 0 || $retornoRGR == NULL ? array_push($vetor,"RG do Representante") : "";

			$consultaCPFR = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '104' AND idPessoa = '$idPessoa' AND publicado = '1'"; // cpf do representante
			$envioCPFR = mysqli_query($con, $consultaCPFR);
			$retornoCPFR = mysqli_num_rows($envioRGR);
			$retornoCPFR == 0 || $retornoCPFR == NULL ? array_push($vetor,"CPF do representante") : "";

			$consultaDECE = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '105' AND idPessoa = '$idPessoa' AND publicado = '1'"; // declaração de exclusividade PJ
			$envioDECE= mysqli_query($con, $consultaDECE);
			$retornoDECE = mysqli_num_rows($envioDECE);
			$retornoDECE == 0 || $retornoDECE == NULL ? array_push($vetor,"Declaração de exclusividade PJ") : "";
		} else //pf
		{

			$consultaRG = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '2' AND idPessoa = '$idPessoa' AND publicado = '1'"; // RG
			$envioRG = mysqli_query($con, $consultaRG);
			$retornoRG = mysqli_num_rows($envioRG);
			$retornoRG == 0 || $retornoRG == NULL ? array_push($vetor,"RG") : "";

			$consultaCPF = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '3' AND idPessoa = '$idPessoa' AND publicado = '1'"; // CPF
			$envioCPF = mysqli_query($con, $consultaCPF);
			$retornoCPF = mysqli_num_rows($envioCPF);
			$retornoCPF == 0 || $retornoCPF == NULL ? array_push($vetor,"CPF") : "";

			$consultaCVI = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '96' AND idPessoa = '$idEvento' AND publicado = '1'"; // CV integrante
			$envioCVI = mysqli_query($con, $consultaCVI);
			$retornoCVI = mysqli_num_rows($envioCVI);
			$retornoCVI == 0 || $retornoCVI == NULL ? array_push($vetor,"Curriculo do Grupo") : "";

			$consultaDECEF = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '106' AND idPessoa = '$idPessoa' AND publicado = '1'"; // declaração de exclusividade PF
			$envioDECEF= mysqli_query($con, $consultaDECEF);
			$retornoDECEF = mysqli_num_rows($envioDECEF);
			$retornoDECEF == 0 || $retornoDECEF == NULL ? array_push($vetor,"Declaração de exclusividade PF") : "";
		}
		//evento

		$consultaClipping = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '65' AND idPessoa = '$idEvento' AND publicado = '1'"; // clipping
		$envioClipping = mysqli_query($con, $consultaClipping);
		$retornoClipping = mysqli_num_rows($envioClipping);
		$retornoClipping == 0 || $retornoClipping == NULL ? array_push($vetor,"Clipping") : "";

		$consultaCurLider = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '107' AND idPessoa = '$idEvento' AND publicado = '1'"; // currículo do líder
		$envioCurLider = mysqli_query($con, $consultaCurLider);
		$retornoCurLider = mysqli_num_rows($envioCurLider);
		$retornoCurLider == 0 || $retornoCurLider == NULL ? array_push($vetor,"Currículo do líder") : "";

		$consultaCRF = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '8' AND idPessoa = '$idEvento' AND publicado = '1'"; // CRF
		$envioCRF= mysqli_query($con, $consultaCRF);
		$retornoCRF = mysqli_num_rows($envioCRF);
		$retornoCRF == 0 || $retornoCRF == NULL ? array_push($vetor,"CRF") : "";

		$consultaConst = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento in (10,58,91) AND idPessoa = '$idEvento' AND publicado = '1'"; // documentos de constituição da empresa
		$envioConst = mysqli_query($con, $consultaConst);
		$retornoConst = mysqli_num_rows($envioConst);
		$retornoConst == 0 || $retornoConst == NULL ? array_push($vetor,"Documentos de constituição") : "";

		$consultaCTM = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '34' AND idPessoa = '$idEvento' AND publicado = '1'"; // CTM
		$envioCTM = mysqli_query($con, $consultaCTM);
		$retornoCTM = mysqli_num_rows($envioCTM);
		$retornoCTM == 0 || $retornoCTM == NULL ? array_push($vetor,"CTM") : "";

		$consultaCDN = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '95' AND idPessoa = '$idEvento' AND publicado = '1'"; // CND
		$envioCDN = mysqli_query($con, $consultaCDN);
		$retornoCDN = mysqli_num_rows($envioCDN);
		$retornoCDN == 0 || $retornoCDN == NULL ? array_push($vetor,"CDN") : "";

		$consultaCCM = "SELECT id FROM upload_arquivo WHERE idUploadListaDocumento = '31' AND idPessoa = '$idPessoa' AND publicado = '1'"; // CCM
		$envioCCM = mysqli_query($con, $consultaCCM);
		$retornoCCM = mysqli_num_rows($envioCCM);
		$retornoCCM == 0 || $retornoCCM == NULL ? array_push($vetor,"CCM") : "";

		return $vetor;
	}
	// Formatação de datas, valores
	// Retira acentos das strings
	function semAcento($string)
	{
		$newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
		return $newstring;
	}
	//retorna data d/m/y de mysql/date(a-m-d)
	function exibirDataBr($data)
	{
		$timestamp = strtotime($data);
		return date('d/m/Y', $timestamp);
	}
	// retorna datatime sem hora
	function retornaDataSemHora($data)
	{
		$semhora = substr($data, 0, 10);
		return $semhora;
	}
	//retorna data d/m/y de mysql/datetime(a-m-d H:i:s)
	function exibirDataHoraBr($data)
	{
		$timestamp = strtotime($data);
		return date('d/m/y - H:i:s', $timestamp);
	}
	//retorna hora H:i de um datetime
	function exibirHora($data)
	{
		$timestamp = strtotime($data);
		return date('H:i', $timestamp);
	}
	//retorna data mysql/date (a-m-d) de data/br (d/m/a)
	function exibirDataMysql($data)
	{
		list ($dia, $mes, $ano) = explode ('/', $data);
		$data_mysql = $ano.'-'.$mes.'-'.$dia;
		return $data_mysql;
        /*
        $dt = DateTime::createFromFormat('d/m/Y', $data);
        if( !$dt ){
            return '';
        }
        return $dt->format('Y-m-d');
        */
	}
	//retorna o endereço da página atual
	function urlAtual()
	{
		$dominio= $_SERVER['HTTP_HOST'];
		$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
		return $url;
	}
	//retorna valor xxx,xx para xxx.xx
	function dinheiroDeBr($valor)
	{
		$valor = str_ireplace(".","",$valor);
		$valor = str_ireplace(",",".",$valor);
		return $valor;
	}
	//retorna valor xxx.xx para xxx,xx
	function dinheiroParaBr($valor)
	{
		$valor = number_format($valor, 2, ',', '.');
		return $valor;
	}
	//use em problemas de codificacao utf-8
	function _utf8_decode($string)
	{
		$tmp = $string;
		$count = 0;
		while (mb_detect_encoding($tmp)=="UTF-8")
		{
			$tmp = utf8_decode($tmp);
			$count++;
		}
		for ($i = 0; $i < $count-1 ; $i++)
		{
			$string = utf8_decode($string);
		}
		return $string;
	}
	//retorna o dia da semana segundo um date(a-m-d)
	function diasemana($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana)
		{
			case"0": $diasemana = "Domingo";       break;
			case"1": $diasemana = "Segunda-Feira"; break;
			case"2": $diasemana = "Terça-Feira";   break;
			case"3": $diasemana = "Quarta-Feira";  break;
			case"4": $diasemana = "Quinta-Feira";  break;
			case"5": $diasemana = "Sexta-Feira";   break;
			case"6": $diasemana = "Sábado";        break;
		}
		return "$diasemana";
	}

	//soma(+) ou substrai(-) dias de um date(a-m-d)
	function somarDatas($data,$dias)
	{
		$data_final = date('Y-m-d', strtotime("$dias days",strtotime($data)));
		return $data_final;
	}

	//retorna a diferença de dias entre duas datas
	function diferencaDatas($data_inicial,$data_final)
	{
		// Define os valores a serem usados
		// Usa a função strtotime() e pega o timestamp das duas datas:
		$time_inicial = strtotime($data_inicial);
		$time_final = strtotime($data_final);
		// Calcula a diferença de segundos entre as duas datas:
		$diferenca = $time_final - $time_inicial; // 19522800 segundos
		// Calcula a diferença de dias
		$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
		return $dias;
	}

	function gravarLog($log)
	{
		//grava na tabela log os inserts e updates
		$logTratado = addslashes($log);
		$idUser = $_SESSION['idUser'];
		$ip = $_SERVER["REMOTE_ADDR"];
		$data = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `log` (`id`, `idUsuario`, `enderecoIP`, `dataLog`, `descricao`)
			VALUES (NULL, '$idUser', '$ip', '$data', '$logTratado')";
		$mysqli = bancoMysqli();
		$mysqli->query($sql);
	}

	function gravarLogSenha($log, $idUsuario)
	{
		//grava na tabela log as alterações de senha
		$logTratado = addslashes($log);
		$ip = $_SERVER["REMOTE_ADDR"];
		$data = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `log` (`id`, `idUsuario`, `enderecoIP`, `dataLog`, `descricao`)
			VALUES (NULL, '$idUsuario', '$ip', '$data', '$logTratado')";
		$mysqli = bancoMysqli();
		$mysqli->query($sql);
	}

/**
 * Preenche um select com os dados da tabela especificada
 * @param string $tabela <p>
 * Nome da tabela no banco de dados
 * </p>
 * @param string|int $select [opcional] <p>
 * Opção que deve ser exibida caso já haja um valor
 * </p>
 * @param string $where [opcional] <p>
 * Clausula WHERE para especificar um campo
 * </p>
 */
function geraOpcao($tabela, $select = '')
	{
		//gera os options de um select
		$sql = "SELECT * FROM $tabela ORDER BY 2";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";
			}
		}
	}

function geraOpcaoParcelas($tabela, $select = '')
{
    //gera os options de um select
    $sql = "SELECT * FROM $tabela ORDER BY id";
    $con = bancoMysqli();
    $query = mysqli_query($con,$sql);
    while($option = mysqli_fetch_row($query))
    {
        if($option[0] == $select)
        {
            echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
        }
        else
        {
            echo "<option value='".$option[0]."'>".$option[1]."</option>";
        }
    }
}




function geraOpcaoLocais ($tabela, $select = '')
{
    //gera os options de um select
    $sql = "SELECT * FROM $tabela ORDER BY 3";
    $con = bancoMysqli();
    $query = mysqli_query($con,$sql);
    while($option = mysqli_fetch_row($query))
    {
        if($option[0] == $select)
        {
            echo "<option value='".$option[0]."' selected >".$option[2]."</option>";
        }
        else
        {
            echo "<option value='".$option[0]."'>".$option[2]."</option>";
        }
    }
}

	function geraOpcaoPublicado($tabela,$select = '')
	{
		//gera os options de um select
		$sql = "SELECT * FROM $tabela WHERE publicado = '1' ORDER BY 2";

		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";
			}
		}
	}


	function geraOpcaoUsuario($tabela, $cargo,$select)
	{
		//gera os options de um select
        if($cargo == 1){
            $sql = "SELECT * FROM $tabela WHERE fiscal = 1 AND publicado = 1 ORDER BY 2";
        }else{
            $sql = "SELECT * FROM $tabela WHERE fiscal = 0 AND publicado = 1 ORDER BY 2";
        }


		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";
			}
		}
	}

	function retornaTipo($id)
	{
		//retorna o tipo de evento
		$con = bancoMysqli();
		$sql = "SELECT * FROM tipo_evento WHERE id = '$id'";
		$query = mysqli_query($con,$sql);
		$x = mysqli_fetch_array($query);
		return $x['tipoEvento'];
	}

	function retornaObjeto($idPedido){
        $con = bancoMysqli();
        $sql = "SELECT nome_evento FROM pedidos AS ped 
                INNER JOIN eventos AS eve ON ped.origem_id = eve.id
                WHERE ped.origem_tipo_id = 1 AND eve.publicado = 1 AND ped.publicado = 1 AND ped.id = '$idPedido'";
        $query = mysqli_query($con,$sql);
        $array = mysqli_fetch_array($query);
        return $array['nome_evento'];
    }

    function retornaPeriodo($idEvento){
        $con = bancoMysqli();
        $sql_data_inicio = "SELECT data_inicio FROM ocorrencias AS oco
                            INNER JOIN atracoes AS atr ON oco.origem_ocorrencia_id = atr.id
                            INNER JOIN eventos AS eve on atr.evento_id = eve.id
                            WHERE oco.tipo_ocorrencia_id = 1 AND oco.publicado = 1 AND atr.publicado = 1 AND eve.id = '$idEvento'
                            ORDER BY data_inicio ASC LIMIT 0,1";
        $query_data_inicio = mysqli_query($con,$sql_data_inicio);
        $array_inicio = mysqli_fetch_array($query_data_inicio);
        $data_inicio = $array_inicio['data_inicio'];

        $sql_data_fim = "SELECT data_fim FROM ocorrencias AS oco
                            INNER JOIN atracoes AS atr ON oco.origem_ocorrencia_id = atr.id
                            INNER JOIN eventos AS eve on atr.evento_id = eve.id
                            WHERE oco.tipo_ocorrencia_id = 1 AND oco.publicado = 1 AND atr.publicado = 1 AND eve.id = '$idEvento'
                            ORDER BY data_fim ASC LIMIT 0,1";
        $query_data_fim = mysqli_query($con,$sql_data_fim);
        $array_fim = mysqli_fetch_array($query_data_fim);

        $data_fim = $array_fim['data_fim'];
        if($data_fim == '0000-00-00' OR $data_fim == NULL){
            return "dia ".exibirDataBr($data_inicio);
        }
        else{
            return "de ".exibirDataBr($data_inicio)." até ".exibirDataBr($data_fim);
        }
    }

	function recuperaModulo($pag)
	{
		$sql = "SELECT * FROM modulo WHERE pagina = '$pag'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$modulo = mysqli_fetch_array($query);
		return $modulo;
	}

	function retornaModulos($perfil)
	{
		// recupera quais módulos o usuário tem acesso
		$sql = "SELECT * FROM perfil WHERE id = $perfil";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campoFetch = mysqli_fetch_array($query);
		$nome = "";
		while($fieldinfo = mysqli_fetch_field($query))
		{
			if(($campoFetch[$fieldinfo->name] == 1) AND ($fieldinfo->name != 'id'))
			{
				$descricao = recuperaModulo($fieldinfo->name);
				$nome = $nome.";\n + ".$descricao['nome'];
			}
		}
		return substr($nome,1);
	}

	function listaModulos($perfil)
	{
		//gera as tds dos módulos a carregar
		// recupera quais módulos o usuário tem acesso
		$sql = "SELECT * FROM perfil WHERE id = $perfil";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campoFetch = mysqli_fetch_array($query);
		while($fieldinfo = mysqli_fetch_field($query))
		{
			if(($campoFetch[$fieldinfo->name] == 1) AND ($fieldinfo->name != 'id'))
			{
				$descricao = recuperaModulo($fieldinfo->name);
				echo "<tr>";
				echo "<td class='list_description'><b>".$descricao['nome']."</b></td>";
				echo "<td class='list_description'>".$descricao['descricao']."</td>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=$fieldinfo->name'>
							<input type ='submit' class='btn btn-theme btn-lg btn-block' value='carregar'></td></form>"	;
				echo "</tr>";
			}
		}
	}


/**
 * <p>Busca um registro na tabela passada no primeiro parametro onde a coluna passada no segundo parametro
 * é igual ao valor passado no terceiro parametro. Deve ser atribuído a uma variavel</p>
 *
 * <p>Ex: SELECT * FROM $tabela WHERE $campo = $variavelCampo</p>
 * @param string $tabela <p>
 * Nome da tabela no banco de dados
 * </p>
 * @param string $campo <p>
 * Nome da coluna na tabela
 * </p>
 * @param int|string $variavelCampo <p>
 * Valor a ser comparado para a clausula WHERE
 * </p>
 * @return array|null <p>
 * Retorna o registro como um array
 * </p>
 */
function recuperaDados($tabela, $campo, $variavelCampo)
	{
		//retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
		$con = bancoMysqli();
		$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$variavelCampo' LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo;
	}

function recuperaDadosPublicado($tabela, $campo, $variavelCampo)
{
    //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
    $con = bancoMysqli();
    $sql = "SELECT * FROM $tabela WHERE ".$campo." = '$variavelCampo' AND publicado = 1 LIMIT 0,1";
    $query = mysqli_query($con,$sql);
    $campo = mysqli_fetch_array($query);
    return $campo;
}

		function recuperaOcorrenciaDados($variavelCampo, $tipoOcorrenciaId)
	{
		//retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro com o tipo do evento.
		$con = bancoMysqli();
		$sql = "SELECT * FROM ocorrencias WHERE origem_ocorrencia_id = '$variavelCampo' AND tipo_ocorrencia_id = '$tipoOcorrenciaId' AND publicado = 1 LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo;
	}

	function verificaExiste($idTabela,$idCampo,$idDado,$st)
	{
		//retorna uma array com indice 'numero' de registros e 'dados' da tabela
		$con = bancoMysqli();
		if($st == 1)
		{
			// se for 1, é uma string
			$sql = "SELECT * FROM $idTabela WHERE $idCampo = '%$idDado%'";
		}
		else
		{
			$sql = "SELECT * FROM $idTabela WHERE $idCampo = '$idDado'";
		}
		$query = mysqli_query($con,$sql);
		$numero = mysqli_num_rows($query);
		$dados = mysqli_fetch_array($query);
		$campo['numero'] = $numero;
		$campo['dados'] = $dados;
		return $campo;
	}

	function recuperaIdDado($tabela,$id)
	{
		$con = bancoMysqli();
		//recupera os nomes dos campos
		$sql = "SELECT * FROM $tabela";
		$query = mysqli_query($con,$sql);
		$campo01 = mysqli_field_name($query, 0);
		$campo02 = mysqli_field_name($query, 1);
		$sql = "SELECT * FROM $tabela WHERE $campo01 = $id";
		$query = mysql_query($sql);
		$campo = mysql_fetch_array($query);
		return $campo[$campo02];
	}

	function checar($id)
	{
		//funcao para imprimir checked do checkbox
		if($id == 1)
		{
			echo "checked";
		}
	}

	function checarOcorrencia($id)
	{
		//funcao para imprimir checked ou disabled do checkbox
		if($id == 1)
		{
			echo "checked";
		}else{
			echo "disabled";
		}
	}


	function valorPorExtenso($valor=0)
	{
		//retorna um valor por extenso
		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
		$z=0;
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];
		$rt = "";
		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++)
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
		return($rt ? $rt : " zero");
	}

	function analisaArray($array)
	{
		//imprime o conteúdo de uma array
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	function recuperaUltimo($tabela)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM $tabela ORDER BY 1 DESC LIMIT 0,1";
		$query =  mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo[0];
	}

	function recuperaUltimoDoUsuario($tabela,$idUser)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM $tabela WHERE idUsuario = $idUser ORDER BY 1 DESC LIMIT 0,1";
		$query =  mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo[0];
	}

	function retornaMes($mes)
	{
		switch($mes)
		{
			case "01":
				return "Janeiro";
			break;
			case "02":
				return "Fevereiro";
			break;
			case "03":
				return "Março";
			break;
			case "04":
				return "Abril";
			break;
			case "05":
				return "Maio";
			break;
			case "06":
				return "Junho";
			break;
			case "07":
				return "Julho";
			break;
			case "08":
				return "Agosto";
			break;
			case "09":
				return "Setembro";
			break;
			case "10":
				return "Outubro";
			break;
			case "11":
				return "Novembro";
			break;
			case "12":
				return "Dezembro";
			break;
		}
	}

	function retornaMesExtenso($data)
	{
		$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		$data = explode("-", $dataMysql);
		$mes = $data[1];
		return $meses[($mes) - 1];
	}

	//retorna o dia da semana segundo um date(a-m-d)
	function diaSemanaBase($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana)
		{
			case"0":
				$diasemana = "domingo";
			break;
			case"1":
				$diasemana = "segunda";
			break;
			case"2":
				$diasemana = "terca";
			break;
			case"3":
				$diasemana = "quarta";
			break;
			case"4":
				$diasemana = "quinta";
			break;
			case"5":
				$diasemana = "sexta";
			break;
			case"6":
				$diasemana = "sabado";
			break;
		}
		return "$diasemana";
	}

	function soNumero($str)
	{
		return preg_replace("/[^0-9]/", "", $str);
	}

	// Gera o endereço no PDF
	function enderecoCEP($cep)
	{
		$con = bancoMysqliCEP();
		$cep_index = substr($cep, 0, 5);
		$dados['sucesso'] = 0;
		$sql01 = "SELECT * FROM igsis_cep_cep_log_index WHERE cep5 = '$cep_index' LIMIT 0,1";
		$query01 = mysqli_query($con,$sql01);
		$campo01 = mysqli_fetch_array($query01);
		$uf = "igsis_cep_".$campo01['uf'];
		$sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
		$query02 = mysqli_query($con,$sql02);
		$campo02 = mysqli_fetch_array($query02);
		$res = mysqli_num_rows($query02);
		if($res > 0)
		{
			$dados['sucesso'] = 1;
		}
		else
		{
			$dados['sucesso'] = 0;
		}
		$dados['rua']     = $campo02['tp_logradouro']." ".$campo02['logradouro'];
		$dados['bairro']  = $campo02['bairro'];
		$dados['cidade']  = $campo02['cidade'];
		$dados['estado']  = strtoupper($campo01['uf']);
		return $dados;
	}
function verificaArquivosExistentesEvento($idEvento,$idDocumento)
{
	$con = bancoMysqli();
	$verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idPessoa = '$idEvento' AND idUploadListaDocumento = '$idDocumento' AND publicado = '1'";
	$envio = mysqli_query($con, $verificacaoArquivo);

	if (mysqli_num_rows($envio) > 0) {
		return true;
	}
}

function verificaArquivosExistentesComunicacao($idEvento)
{
	$con = bancoMysqli();
	$verificacaoArquivo = "SELECT arquivo FROM upload_arquivo_com_prod WHERE idEvento = '$idEvento' AND publicado = '1'";
	$envio = $con->query($verificacaoArquivo);
	$qtd = mysqli_num_rows($envio);
	if($qtd > 0){
		return $qtd;
	}
}

function verificaArquivosExistentesPF($idPessoa,$idDocumento)
{
	$con = bancoMysqli();
	$verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idTipoPessoa = '1' AND idPessoa = '$idPessoa' AND idUploadListaDocumento = '$idDocumento' AND publicado = '1'";
	$envio = mysqli_query($con, $verificacaoArquivo);
	if (mysqli_num_rows($envio) > 0) {
		return true;
	}
}

function verificaArquivosExistentesPJ($idPessoa,$idDocumento)
{
    $con = bancoMysqli();
    $verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idTipoPessoa = '2' AND idPessoa = '$idPessoa' AND idUploadListaDocumento = '$idDocumento' AND publicado = '1'";
    $envio = mysqli_query($con, $verificacaoArquivo);
    if (mysqli_num_rows($envio) > 0) {
        return true;
    }
}


function listaArquivoCamposMultiplos($idPessoa,$tipoPessoa,$idCampo,$pagina,$pf)
{
	$con = bancoMysqli();
	switch ($pf) {
		case 1: //informacoes_iniciais_pf
			$arq1 = "AND (list.id = '2' OR ";
			$arq2 = "list.id = '3' OR";
			$arq3 = "list.id = '25' OR";
			$arq4 = "list.id = '31')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
		break;
		case 2: //informacoes_iniciais_pj
			$arq1 = "AND (list.id = '22' OR ";
			$arq2 = "list.id = '43' OR";
			$arq3 = "list.id = '28')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3
				AND arq.publicado = '1'";
		break;
		case 3: //dados_bancarios e informações_complementares
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND list.id = '$idCampo'
				AND arq.publicado = '1'";
		break;
		case 4: //anexos_pf
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND list.id NOT IN (2,3,4,25,31,51,60)
				AND arq.publicado = '1'";
		break;
		case 5: //representante_legal1
			$arq1 = "AND (list.id = '20' OR ";
			$arq2 = "list.id = '21')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2
				AND arq.publicado = '1'";
		break;
		case 6: //representante_legal2
			$arq1 = "AND (list.id = '103' OR ";
			$arq2 = "list.id = '104')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2
				AND arq.publicado = '1'";
		break;
		case 7: //artista_pj_cadastro
			$arq1 = "AND (list.id = '2' OR ";
			$arq2 = "list.id = '3' OR";
			$arq3 = "list.id = '60' OR";
			$arq4 = "list.id = '107')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
		break;
		case 8: //anexos_pj
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND list.id NOT IN ('20','21','22','28','43','89','103','104')
				AND arq.publicado = '1'";
		break;
		case 9: //grupo
			$arq1 = "AND (list.id = '99' OR ";
			$arq2 = "list.id = '100' OR";
			$arq3 = "list.id = '101' OR";
			$arq4 = "list.id = '102')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
		break;
		case 10: //evento
			$arq1 = "AND (list.id = '23' OR ";
			$arq2 = "list.id = '65' OR";
			$arq3 = "list.id = '78' OR";
			$arq4 = "list.id = '96' OR";
			$arq5 = "list.id = '97' OR";
			$arq6 = "list.id = '101' OR";
			$arq7 = "list.id = '108')";
			$sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3 $arq4 $arq5 $arq6 $arq7
				AND arq.publicado = '1'";
		break;
		default:
		break;
	}
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>".$arquivo['arquivo']."</a><br/>(".$arquivo['documento'].")</td>";
					echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=".$pagina."'>
								<input type='hidden' name='idPessoa' value='".$idPessoa."' />
								<input type='hidden' name='tipoPessoa' value='".$tipoPessoa."' />
								<input type='hidden' name='apagar' value='".$arquivo['id']."' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Arquivo?' data-message='Desejar realmente excluir o arquivo ".$arquivo['documento']."?'>Apagar
								</button></td>
							</form>";
					echo "</tr>";
				}
				echo "
		</tbody>
		</table>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

// Função que valida o CPF
function validaCPF($cpf)
{
	$cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
	// Valida tamanho
	if (strlen($cpf) != 11)
		return false;
	// Calcula e confere primeiro dígito verificador
	for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Lista de CPFs inválidos
	$invalidos = array(
		'11111111111',
		'22222222222',
		'33333333333',
		'44444444444',
		'55555555555',
		'66666666666',
		'77777777777',
		'88888888888',
		'99999999999');
	// Verifica se o CPF está na lista de inválidos
	if (in_array($cpf, $invalidos))
		return false;
	// Calcula e confere segundo dígito verificador
	for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida o CNPJ
function validaCNPJ($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Lista de CNPJs inválidos
	$invalidos = array(
		'11111111111111',
		'22222222222222',
		'33333333333333',
		'44444444444444',
		'55555555555555',
		'66666666666666',
		'77777777777777',
		'88888888888888',
		'99999999999999'
	);
	// Verifica se o CNPJ está na lista de inválidos
	if (in_array($cnpj, $invalidos))
	{
		return false;
	}
	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida e-mails
function validaEmail($email)
{
	/* Verifica se o email e valido */
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		/* Obtem o dominio do email */
		list($usuario, $dominio) = explode('@', $email);

		/* Faz um verificacao de DNS no dominio */
		if (checkdnsrr($dominio, 'MX') == 1)
		{
			return TRUE;
		}
		else
		{
		return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}

function listaArquivos($idEvento)
{
	//lista arquivos de determinado evento
	$con = bancoMysqli();
	$sql = "SELECT * FROM upload_arquivo_com_prod WHERE idEvento = '$idEvento' AND publicado = '1'";
	$query = mysqli_query($con,$sql);
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
	while($campo = mysqli_fetch_array($query))
	{
		echo "<tr>";
		echo "<td class='list_description'><a href='../uploads/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
		echo "
			<td class='list_description'>
				<form id='apagarArq' method='POST' action='?perfil=arquivos_com_prod'>
					<input type='hidden' name='apagar' value='".$campo['id']."' />
					<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Arquivo?' data-message='Desejar realmente excluir o arquivo ".$campo['arquivo']."?'>Apagar
					</button></td></form>"	;
		echo "</tr>";
	}
	echo "
		</tbody>
		</table>";
}

function mensagem($tipo,$texto){
	    return "
	    <div class=\"col-md-12\">
                <div class=\"box box-".$tipo." box-solid\">
                    <div class=\"box-header with-border\">
                        <h3 class=\"box-title\">".$texto."</h3>
                        <div class=\"box-tools pull-right\">
                            <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                        </div>
                    </div>
                </div>
            </div>
	    ";
}


function anexosNaPagina ($idDocumento, $idPessoa, $nomeModal, $documento) {
    $con = bancoMysqli();
    $sql = "SELECT * FROM arquivos WHERE lista_documento_id = '$idDocumento' AND origem_id = '$idPessoa' AND publicado = 1";
    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) == 0) {
        echo"
        <label>Anexo " . $documento . "</label><br>
        <button type='button' class='btn btn-primary btn-block' data-toggle='modal'
                data-target='#". $nomeModal . "'>Clique aqui para anexar
        </button>";

    } else {
        $doc = mysqli_fetch_array($query);
        echo"
        <label style='margin-top: 10px;'>". $documento ." anexado no dia: " . exibirDataBr($doc['data']). "</label>
        <br>
        <div class='form-group' style='display: flex; align-items: center;'>
        <button class='btn-sm btn-danger glyphicon glyphicon-trash' type='button' data-toggle='modal' 
            data-target='#exclusao' data-id='". $doc['id'] ."' data-nome='" . $doc['arquivo'] . "'>
         </button> &nbsp;&nbsp;
        <a href='../uploadsdocs/". $doc['arquivo'] . "' target='_blank'>" .
            mb_strimwidth($doc['arquivo'], 15, 25, '...') .  "</a></div>";
    }
}


function listaLocais($idEvento, $tiraLinha = "")
{
    $con = bancoMysqli();
    $sql_atracao = "SELECT * FROM atracoes WHERE evento_id = '$idEvento' AND publicado = 1";
    $query_atracao = mysqli_query($con, $sql_atracao);
    $locais = "";
    $negrito = 0;
    while ($atracao = mysqli_fetch_array($query_atracao)) {
        $idAtracao = $atracao['id'];
        $sql_virada = "SELECT DISTINCT local_id FROM ocorrencias WHERE origem_ocorrencia_id = '$idAtracao' AND publicado = '1' AND virada = '1'";
        $query_virada = mysqli_query($con, $sql_virada);
        $num = mysqli_num_rows($query_virada);
        if ($num > 0) {
            $locais = " DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.  ";
        } else {
            $sql = "SELECT DISTINCT local_id FROM ocorrencias WHERE origem_ocorrencia_id = '$idAtracao' AND publicado = '1'";
            $query = mysqli_query($con, $sql);
            while ($local = mysqli_fetch_array($query)) {
                if($tiraLinha == 1){

                    $sala = recuperaDados("locais", 'id', $local['local_id']);
                    $instituicao = recuperaDados("instituicoes", 'id', $sala['instituicao_id']);
                    $locais = $locais . " " . $sala['local'] . " (" . $instituicao['sigla'] . ") -  ";

                    $negrito++;
                }else{
                    $sala = recuperaDados("locais", 'id', $local['local_id']);
                    $instituicao = recuperaDados("instituicoes", 'id', $sala['instituicao_id']);
                    $locais = "<p>" . $locais . " " . $sala['local'] . " (" . $instituicao['sigla'] . ") </p><hr>";

                    $negrito++;
                }
            }
        }
    }
    $locais = substr($locais, 0, strlen($locais) - 4);
    //$locais = $locais . "";
    return $locais;
}

function retornaPeriodoNovo($id)
{
    //retorna o período
    $con = bancoMysqli();
    $sql_virada = "SELECT DISTINCT oco.local_id FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' AND virada = '1' ";
    $query_virada = mysqli_query($con,$sql_virada);
    $num = mysqli_num_rows($query_virada);
    if($num > 0)
    {
        $sql_anterior = "SELECT * FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio ASC LIMIT 0,1"; //a data inicial mais antecedente
        $query_anterior = mysqli_query($con,$sql_anterior);
        $data = mysqli_fetch_array($query_anterior);
        $data_inicio = $data['dataInicio'];
        $sql_posterior01 = "SELECT * FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' ORDER BY data_fim DESC LIMIT 0,1"; //quando existe data final
        $sql_posterior02 = "SELECT * FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio DESC LIMIT 0,1"; //quando há muitas datas únicas
        $query_anterior01 = mysqli_query($con,$sql_posterior01);
        $data = mysqli_fetch_array($query_anterior01);
        $num = mysqli_num_rows($query_anterior01);
        if(($data['data_fim'] != '0000-00-00') OR ($data['data_fim'] != NULL))
        {
            //se existe uma data final e que é diferente de NULO
            $dataFinal01 = $data['data_fim'];
        }
        $query_anterior02 = mysqli_query($con,$sql_posterior02); //recupera a data única mais tarde
        $data = mysqli_fetch_array($query_anterior02);
        $dataFinal02 = $data['data_inicio'];
        if(isset($dataFinal01))
        {
            //se existe uma temporada, compara com a última data única
            if($dataFinal01 > $dataFinal02)
            {
                $dataFinal = $dataFinal01;
            }
            else
            {
                $dataFinal = $dataFinal02;
            }
        }
        else
        {
            $dataFinal = $dataFinal02;
        }
        if($data_inicio == $dataFinal)
        {
            return exibirDataBr($data_inicio)." DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
        }
        else
        {
            return "de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal)." DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
        }
    }
    else
    {
        $sql_anterior = "SELECT * FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio ASC LIMIT 0,1"; //a data inicial mais antecedente
        $query_anterior = mysqli_query($con,$sql_anterior);
        $data = mysqli_fetch_array($query_anterior);
        $data_inicio = $data['data_inicio'];
        $sql_posterior01 = "SELECT * FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' ORDER BY data_fim DESC LIMIT 0,1"; //quando existe data final
        $sql_posterior02 = "SELECT * FROM ocorrencias oco INNER JOIN atracoes atr ON atr.id = oco.origem_ocorrencia_id WHERE atr.evento_id = '$id' AND oco.publicado = '1' ORDER BY data_inicio DESC LIMIT 0,1"; //quando há muitas datas únicas
        $query_anterior01 = mysqli_query($con,$sql_posterior01);
        $data = mysqli_fetch_array($query_anterior01);
        $num = mysqli_num_rows($query_anterior01);
        if(($data['data_fim'] != '0000-00-00') OR ($data['data_fim'] != NULL))
        {
            //se existe uma data final e que é diferente de NULO
            $dataFinal01 = $data['data_fim'];
        }
        $query_anterior02 = mysqli_query($con,$sql_posterior02); //recupera a data única mais tarde
        $data = mysqli_fetch_array($query_anterior02);
        $dataFinal02 = $data['data_inicio'];
        if(isset($dataFinal01))
        {
            //se existe uma temporada, compara com a última data única
            if($dataFinal01 > $dataFinal02)
            {
                $dataFinal = $dataFinal01;
            }
            else
            {
                $dataFinal = $dataFinal02;
            }
        }
        else
        {
            $dataFinal = $dataFinal02;
        }
        if($data_inicio == $dataFinal)
        {
            return exibirDataBr($data_inicio);
        }
        else
        {
            return "de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal);
        }
    }
}

function geraProtocolo($id)
{
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Ymd');
    $preencheZeros = str_pad($id, 5, '0', STR_PAD_LEFT);
    return $date . $preencheZeros;
}