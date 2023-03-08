<?php
// error_reporting (E_ALL);
include("config.php");

if($_GET['id']) $_POST["id"] = $_GET['id'];

	/**
	 *
	 *
	 * ARQUIVO DE EXEMPLO DE COMO PODE MONTAR A API
	 */

	// TODOS OS DADOS AQUI VOCE DEVE VIR DA SUA BASE DE DADOS

	// DOCUMENTAÇÃO:
	//	https://github.com/nfephp-org/sped-nfe/tree/master/docs

	// REVISAR TODO O ARQUIVO api/gerador/emissor.php

	/*
	MODELO DA NOTA:
	65 - NFC-e
	55 - NF-e
	*/

	/*
	TIPO DE IMPRESSAO - $impressao
	Para NF-e (modelo 55),  permitido utilizar os Formatos de Impresso do DANFE abaixo:
	0 = Sem gerao de DANFE;
	1 = DANFE normal, Retrato;
	2 = DANFE normal, Paisagem;
	3 = DANFE Simplificado;
	4 = DANFE NFC-e;
	5 = DANFE NFC-e em mensagem eletrnica (o envio de mensagem eletrnica pode ser feita de forma simultanea com a impresso do DANFE; usar o tpImp=5 quando esta for a unica forma de disponibilizao do DANFE)
	*/

	/*
	Tipo de Emissao da NF-e
	1 - Normal - emisso normal;
	2 - Contingncia FS - emisso em contingncia com impresso do DANFE em Formulrio de Segurana;
	3 - Contingncia SCAN - emisso em contingncia no Sistema de Contingncia do Ambiente Nacional ? SCAN;
	4 - Contingncia DPEC - emisso em contingncia com envio da Declarao Prvia de Emisso em Contingncia ? DPEC;
	9 - Contingncia off-line da NFC-e;
	5 - Contingncia FS-DA - emisso em contingncia com impresso do DANFE em Formulrio de Segurana para Impresso de Documento Auxiliar de Documento Fiscal Eletrnico (FS-DA).
	*/

	/*
	PRESENÇA - $presenca
	0=No se aplica (por exemplo, Nota Fiscal complementar
	ou de ajuste);
	1=Operao presencial;
	2=Operao no presencial, pela Internet;
	3=Operao no presencial, Teleatendimento;
	4=NFC-e em operao com entrega a domiclio;
	9=Operao no presencial, outros.
	*/

	/**
	 * CERTIFICADO DIGITAL::::::::::::
	 * colocar na pasta: /api-nfe/certificado_digital/
	 *
	 */


	 /**
	 * LOGOTIPO PARA A NOTA (.JPG)::::::::::::
	 * colocar na pasta: /api-nfe/logos_notas/
	 *
	 */

	function limpardados($txt){
		return preg_replace("/[^0-9]/", "", $txt);
	}

	function getCodigoEstado($uf){

		if($uf=="") return;

		$estados = array(
			35 => 'SP',
			41 => 'PR',
			42 => 'SC',
			43 => 'RS',
			50 => 'MS',
			11 => 'RO',
			12 => 'AC',
			13 => 'AM',
			14 => 'RR',
			15 => 'PA',
			16 => 'AP',
			17 => 'TO',
			21 => 'MA',
			24 => 'RN',
			25 => 'PB',
			26 => 'PE',
			27 => 'AL',
			28 => 'SE',
			29 => 'BA',
			31 => 'MG',
			33 => 'RJ',
			51 => 'MT',
			52 => 'GO',
			53 => 'DF',
			22 => 'PI',
			23 => 'CE',
			32 => 'ES',
			);

			$code = array_search(strtoupper($uf), $estados);
			return $code;
	   }

	$venda_id = $_POST["id"];


	// SELECIONE OS DADOS SUA TABELA DE VENDAS
	$sql = 'SELECT a.*, (select forma_pagamento from vendas_pagamentos where a.codigo = venda and deletado != \'1\' order by valor desc limit 1) as forma_pagamento FROM vendas a WHERE a.deletado != \'1\' and a.codigo = ?';
    $stmt = $PDO->prepare($sql);
    $stmt->execute([$venda_id]);
    $rowVenda = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;


	// SELECIONE O NÚMERO DA NOTA
	$sql = 'SELECT * FROM configuracao WHERE codigo = ?';
    $stmt = $PDO->prepare($sql);
    $stmt->execute([1]);
    $nota = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;

	// $sql = 'UPDATE configuracao set numero_proxima_nfc = (numero_proxima_nfc+1) WHERE codigo = ?';
	// $stmt = $PDO->prepare($sql);
	// $stmt->execute([1]);

    if(empty($rowVenda)) die("Vendas nao encontrada");

	if(!empty($rowVenda["nf_numero"])) die("Já foi emitida uma nota para esta venda! ");

    // configuracao DO EMISSOR DA NOTA E NÚMERO DA PROXIMA NOTA FISCAL
	// pode ser montado para facilitar o uso.
	// novos campos: numero_proxima_nfc e numero_proxima_nf por exemplo

	$tipoNota = 1; // 1- NFC-e / 2- NF-e

	if($tipoNota==1){

		// MODELO NFC-E
		$modelo = 65;
		$presenca = 1;
		$frete = 9;
		$impressao = 4;

	}elseif($tipoNota==2){

		// MODELO NF GRANDE
		$modelo = 55;
		$presenca = 2;
		$frete = 0;
		$impressao = 1;

	}

	// operacoes não presenciais necesita usar intermediario
	$intermediario = "";
	if($presenca==2 || $presenca==3 || $presenca==4 || $presenca==9){
		$intermediario = 1;
	}

	// CONFIGURA AS FORMAS DE PAGAMENTO ATUAL DO SEU SISTEMA
		$formasPagamentoNF = array(
			'dinheiro' => "01", // dinheiro
			'credito' => "03", // credito
			'debito' => "04", // debito
			'pix' => "17", // PIX
			'outros' => "99", // outros
		);

		$NUMERO_DA_NOTA = 1; // NUMERO DA NF QUE SERÁ EMITIDA (DEVE SER SEQUENCIAL, É IMPORTANTE GUARDAR A ORDEM NO SEU BANCO DE DADOS)

		// PEDIDO / VENDA / AQUI AS INFOMACOES PRINCIPAIS
		$data_nfe = array(
			'ID' => $rowVenda["codigo"], // ID DA VENDA NO SISTEMA
			'NF' => $nota['numero_proxima_nfc'], // Número da NF (Deve seguir uma ordem exata)
			'serie' => 3,
			'operacao' => 1, // Tipo de Operação da Nota Fiscal
			'metodo_envio' => 1, // Metodo de transmisão de nota 1) Modo síncrono. / 0) modo assíncrono.
			'natureza_operacao' => 'Venda', // Natureza da Operação
			'modelo' => $modelo, // Modelo da Nota Fiscal (65 - NFC / 55 - NF)
			'emissao' => 1, // Tipo de Emissao da NF-e
			'finalidade' => 1, // Finalidade de emissao da Nota Fiscal
			'consumidorfinal' => 1,  // Indicação do consumidor final
			'destinatario' => 1, // 1 = Operao interna; 2 = Operao interestadual; 3 = Operao com exterior.
			'impressao' => $impressao, // Tipo de impressao
			'intermediario' => $intermediario,
			'intermediador' => array(
				"cnpj" => "", //CNPJ do intermediador: Mercado livre, outros marketplaces
				"idcadastro" => "" // nome do intermediador:
			),
			'pedido' => array(
				'pagamento' => 1, // Indicador da forma de pagamento
				'presenca' => $presenca, // Indicador de presenca do comprador no estabelecimento comercial no momento da operacao
				'modalidade_frete' => $frete, // Modalidade do frete
				'frete' =>  number_format(0, 2, '.', ''), // Total do frete
				'desconto' =>  number_format($rowVenda["desconto"], 2, '.', ''),  // Total do desconto
				'outras_despesas' =>  number_format($rowVenda["taxa"], 2, '.', ''), // Outras Despesas
				'total' =>  number_format(($rowVenda["valor"]), 2, '.', ''), // Valor total do pedido pago pelo cliente
				'troco' =>  number_format(0, 2, '.', ''), // Troco
				'forma_pagamento' => $formasPagamentoNF[$rowVenda["forma_pagamento"]], // 01 - dinheiro // 02-
				'valor_pagamento' =>  number_format(($rowVenda["valor"] + $rowVenda["taxa"] - $rowVenda["desconto"]), 2, '.', '') // valor total de R$75,00
			),
			'empresa' => array(
				"tpAmb" => 1, // AMBIENTE: 1 - PRODUÇÃO / 2 - HOMOLOGACAO
				"razaosocial" => "MANOS BARBEARIA LTDA", // RAZA0 SOCIAL DA EMPRESA (obrigatorio)
				"cnpj" => limpardados("20361605000115"), // CNPJ DA EMPRESA (obrigatorio)
				"fantasia" => "OS MANOS", // NOME FANTASIA (obrigatorio)
				"ie" => limpardados("05.358.150-4 SN"), // INSCRICAO ESTADUAL (obrigatorio)
				"im" => limpardados("21555101"), // INSCRICAO MUNICIPAL (não obrigatório)
				"cnae" => limpardados("96.02-5-01"), // CNAE EMPRESA  (obrigatorio)
				"crt" => "1", // CRT **********
				"rua" => "AVE DJALMA BATISTA", // obrigatorio
				"numero" => "370", // obrigatorio
				"bairro" => "CHAPADA", // obrigatorio
				"cidade" => "MANAUS", // NOME DA CIDADE,  obrigatorio
				"ccidade" => limpardados("1302603"), // CODIGO DA CIDADE IBGE, buscar no google,  obrigatorio
				"cep" => limpardados("69050-010"),  // obrigatorio
				"siglaUF" => "AM", // SIGLA DO ESTADO,  obrigatorio
				"codigoUF" => getCodigoEstado("AM"), // CODIGO DO ESTADO, obrigatorio
				"fone" => limpardados("92985120992"), // obrigatorio
				"tokenIBPT" => "B8IyVi3R_41JTb7ODyIwLxqLrzFs0QnKFSb8TvNNXzGY-84QCuiRAK5DIjiTd7Nd", // GERAR TOKEN NO https://deolhonoimposto.ibpt.org.br/
				"CSC" => "59b428b928eeca45", //"3c3419278d232aa4",  // obrigatorio para NFC-e somente
				"CSCid" => "000001", // EXEMPLO 000001 // obrigatorio para NFC-e somente
				"certificado_nome" => "6e7d5964332962ee541b3501b22e1111.p12", // NOME DO ARQUIVOS DO CERTIFICADO, IRÁ BUCAR NA PASTA api-nfe/certificado_digital
				"certificado_senha" => "1234567", // SENHA DO CERTIFICADO DIGITAL
				"logo" => "793413af836e67708856b843449f1111.jpg", // LOGO
			),
		);


		// VALIDADAR DADOS DO EMISSOR:
		if($data_nfe["empresa"]["razaosocial"]==""){ $errValidar .= "<br>Configure a Razão Social do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["cnpj"]==""){ $errValidar .= "<br>Configure o CNPJ do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["fantasia"]==""){ $errValidar .= "<br>Configure o Nome Fantasia do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["ie"]==""){ $errValidar .= "<br>Configure a Inscrição Estadual do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["crt"]==""){ $errValidar .= "<br>Configure o CRT do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["rua"]==""){ $errValidar .= "<br>Configure o Rua do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["numero"]==""){ $errValidar .= "<br>Configure o Número do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["bairro"]==""){ $errValidar .= "<br>Configure o Bairro do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["cidade"]==""){ $errValidar .= "<br>Configure a Cidade do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["cep"]==""){ $errValidar .= "<br>Configure o CEP do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["ccidade"]==""){ $errValidar .= "<br>Configure o Código da Cidade do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["siglaUF"]==""){ $errValidar .= "<br>Configure o Estado do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["codigoUF"]==""){ $errValidar .= "<br>Configure o Código do Estado do endereço do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["fone"]==""){ $errValidar .= "<br>Configure o Telefone do emissor da nota fiscal"; }
		if($data_nfe["empresa"]["certificado_nome"]==""){ $errValidar .= "<br>Deve fazer upload do certificado digital"; }
		if($data_nfe["empresa"]["certificado_senha"]==""){ $errValidar .= "<br>Configure a senha do certificado digital"; }
		if($data_nfe["empresa"]["CSC"]==""){ $errValidar .= "<br>Configure o CSC do emissor da nota (O Contador poderá te informar este dado)"; }
		if($data_nfe["empresa"]["CSCid"]==""){ $errValidar .= "<br>Configure o ID do CSC do emissor da nota (O Contador poderá te informar este dado)"; }

		// erro de valicações
		if($errValidar!=""){
			$errValidar = "Erro na emissão:".$errValidar;
			// echo '<h2>Erro na emissão:</h2>';
			// echo '<p>'.$errValidar.'</p>';
			$PDO->query("UPDATE vendas SET nf_error='{$errValidar}' where codigo='$venda_id'");
			die;
		}

	   // CLIENTE
	   // $cadastro (1 - pessoa fisica / 2 pessao juridica)
	   		$cadastro = 1;
			$cpfnanota = trim(limpardados($_POST["cpf"])); // CPF DO CLIENTE, ENVIAR SEM MASCARA

			if($cpfnanota!=""){
					// somente cpf na soma
					$data_nfe['cliente'] = array(
						'cpf' => $cpfnanota,
						'indIEDest' => "9",
						'tipoPessoa' => "F"
					);

			}else{

				if($cadastro==1){
					$d1 = 'cpf';
					$d2 = 'nome_completo';
					$d3 = 'rg';
				}else{
					$d1 = 'cnpj';
					$d2 = 'razao_social';
					$d3 = 'ie';
				}

				// SE FOR USADO DEVERÁ TER TODOS OS CAMPOS

				$data_nfe['cliente'] = array(
					$d1 => "", // Número do CPF / CNPJ
					$d2 => "", // Nome / RAZÃO SOCIAL
					$d3 => "", // RG (NAÕ OBRIGATÓRIO) / INSCRICAO ESTADUAL
					'endereco' => $endereco, // Endereço de entrega dos produtos
					'complemento' => $complemento, // Complemento do endereço de entrega
					'numero' => $numero, // Número do endereço de entrega
					'bairro' => $bairro, // Bairro do endereço de entrega
					'cidade' => $cidade, // Cidade do endereço de entrega
					'cidade_cod' => $codigocidade, // Código da cidade IBGE
					'uf' => $estado, // Estado do endereço de entrega
					'cep' => $cep, // CEP do endereço de entrega
					'telefone' => $telefone, // Telefone do cliente
					'email' => $email // E-mail do cliente para envio da NF-e
				);
			}




		// PRODUTOS (FAZER DA SUA BASE DE DADOS)
		// IMPORTANTE: NOVOS CAMPOS DE PRODUTOS:
		/**
		 *  p.ncm
		 * 	p.cfop
		 * 	p.origem
		 * p.unidade = "UN", "PC"
		 *
		 */
		$x = 0;

		// SELECIONE OS DADOS DA TABELA DE VENDAS_ITENS E JOIN COM PRODUTOS
		/**
		 * p.id = ID DO PRODUTO OU CODIGO
		 * p.codigo = CODIGO DO PRODUTO (CODIGO DE BARRAS OU OUTRO)
		 * p.nome = NOME DO PRODUTO
		 * p.ncm = NCM
		 * p.cfop = CFOP
		 * p.origem = ORIGEM
		 * p.unidade = UNIDADE (UN, KG,...)
		 * pv.valor_unitario = VALOR DE VENDA
		 * pv.quantidade = QUANTIDADE VENDIDA
		 * pv.valor_total = (VALOR DE VENDA * QUANTIDADE)
		 *
		 */
		echo $sql = "SELECT pv.*, p.produto as produto_nome,  p.nota_ncm, p.nota_cest, p.nota_cfop, p.nota_origem, p.nota_unit, p.nota_icms
				FROM vendas_produtos as pv
				LEFT JOIN produtos as p ON pv.produto = p.codigo
				WHERE pv.venda = '$venda_id' and pv.deletado != '1'";


		$stmt = $PDO->query($sql);
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


			//////////////////////////////////////////////////////////

			// $pedido = json_decode($row["produto_json"]);
			// $sabores = false;


			// $ListaPedido = [];
			// for($i=0; $i < count($pedido->produtos); $i++){
			// 	$ListaPedido[] = $pedido->produtos[$i]->descricao;
			// }
			// if($ListaPedido) $sabores = implode(', ', $ListaPedido);

			// $Prod = [];
			// if(count($pedido->produtos) > 0){
			// 	foreach($pedido->produtos as $ind => $prod){
			// 		if(is_array($prod)){
			// 			foreach($prod as $ind1 => $prod1){
			// 				$Prod[] = $prod1->descricao;
			// 			}
			// 		}else{
			// 			$Prod[] = $prod->descricao;
			// 		}

			// 	}
			// 	$Prod = (($Prod)?implode(' ',$Prod):false);
			// }


			//////////////////////////////////////////////////////////



			$codigo=$row["codigo"];
			$quatidade = (empty($row["quantidade"])) ? "1" : $row["quantidade"];
			$nomeproduto=$row["produto_nome"]; // NOME DO PRODUTO
			$ncm=$row["nota_ncm"]; // NCM
			$cest=$row["nota_cest"]; // CEST
			$unit=(empty($row["unidade"])) ? "UN" : $row["unidade"]; // CODIGO UNIDADE
			$origem = (empty($row["nota_origem"])) ? "0" : $row["nota_origem"];
			$cfop = $row["nota_cfop"];
			$icms = $row["nota_icms"];
			$preco = $row["valor_unitario"];
			$preco_total = $row["valor_total"];
			$peso = '0.100';

			$data_nfe['produtos'][$x] = array(
				'item' => $codigo, // ITEM do produto
				'nome' => $nomeproduto, // Nome do produto
				'ean' => '', // EAN do produto
				'ncm' => str_replace(array(" ", ".", ","), "", $ncm), // NCM do produto
				'cest' => str_replace(array(" ", ".", ","), "", $cest), // CEST do produto
				'unidade' => $unit, // UNIT do produto (UN, PC, KG)
				'quantidade' => $quatidade, // Quantidade de itens
				'peso' => str_replace(array(" ", ","), "", $peso), // Peso em KG. Ex: 800 gramas = 0.800 KG
				'subtotal' => number_format($preco, 2, '.', ''), // Preço unitário do produto - sem descontos
				'total' => number_format($preco_total, 2, '.', ''), // Preco total (quantidade x preco unitario) - sem descontos
			);

			$data_nfe['produtos'][$x]['impostos']['icms']['codigo_cfop'] = $cfop; // CFOP do produto
			$data_nfe['produtos'][$x]['impostos']['icms']['origem'] = $origem; // origem do produto

			$data_nfe['produtos'][$x]['impostos']["icms"]["situacao_tributaria"] = $icms;
			$data_nfe['produtos'][$x]['impostos']['ipi']['situacao_tributaria'] = "-1";
			$data_nfe['produtos'][$x]['impostos']['pis']['situacao_tributaria'] = "";
			$data_nfe['produtos'][$x]['impostos']['cofins']['situacao_tributaria'] = "";

			$x++;

		}


		// print_r($data_nfe);

			// Tecnico resposavel - opcional e obrigatório para alguns estados
			// Se for usar são obrigatório: cnpj, contato (nome), email e fone
			//*
			$data_nfe["tecnico"] = array(
				'cnpj' => "10158735000100",
				'contato'=> "Tamer Mohamed Elmenoufi",
				'email'=> "tamer@mohatron.com.br",
				'fone'=> "5592991886570",
				'csrt'=> "",
				'idcsrt'=> ""
			);
			//*/

			// INFORMACOES COMPLEMENTARES 0U COMENTÁRIOS
			$data_nfe['pedido']['informacoes_complementares'] = "";

			$urlxml = $endpoint.'gerador/xml/'; // ex: 'https://{muda isso aqui}seusite.com/api/gerador/xml/autorizadas/'
			$urldanfe = $endpoint.'danfe/index.php'; // URL PARA GERADOR DANFE
			$data_nfe['xml'] = $urlxml;
			$data_nfe['danfe'] = $urldanfe;

			// Modo de teste
			//echo $endpoint."gerador/Emissor.php?".$fields_string;
			//$data_nfe['teste'] = "ok"; // se desejar emitir em modo de teste, não será enviado para o sefaz

			// print_r($data_nfe);




			$fields_string = http_build_query($data_nfe);

			// Envio POST
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $endpoint."gerador/Emissor.php");
			curl_setopt($ch,CURLOPT_POST, count($data_nfe, COUNT_RECURSIVE));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response_server = curl_exec($ch);
			$response = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response_server));
			var_dump($response);
			if (curl_errno($ch)) {
				$errValidar = print_r(curl_error($ch), true);
				// var_dump(curl_error($ch));
				$PDO->query("UPDATE vendas SET nf_error='{$errValidar}' where codigo='$venda_id'");
				die;
			}
			curl_close($ch);

			exit();

			if (isset($response->error)){

				// echo '<h2>Erro: '.$response->error.'</h2>';
				$errValidar .= '<h2>Erro: '.$response->error.'</h2>';
				if (isset($response->log)){
					// echo '<h3>Log:</h3>';
					// echo '<ul>';
					$errValidar .= '<h3>Log:</h3><ul>';
					foreach ($response->log as $erros){
						foreach ($erros as $erro) {
							// echo '<li>'.$erro.'</li>';
							$errValidar .= '<li>'.$erro.'</li>';
						}
					}
					// echo '</ul>';
					$errValidar .= '</ul>';
				}

				$PDO->query("UPDATE vendas SET nf_error='{$errValidar}' where codigo='$venda_id'");


			}elseif(!$response){

				// echo '<h2>Erro no servidor ao emitir</h2>';
				$errValidar .= '<h2>Erro no servidor ao emitir</h2>';
				$errValidar .= print_r($response_server, true);
				// var_dump($response_server);
				$PDO->query("UPDATE vendas SET nf_error='{$errValidar}' where codigo='$venda_id'");

			} else {

				if($response->teste == "ok"){
					$cont = "tipo=validate&";
					$errValidar = $endpoint ."danfe/?".$cont."chave=".$response->chave."&logo=".$data_nfe["empresa"]["logo"];
					// header("location: ".$endpoint ."danfe/?".$cont."chave=".$response->chave."&logo=".$data_nfe["empresa"]["logo"]); exit;
					$PDO->query("UPDATE vendas SET nf_teste='{$errValidar}' where codigo='$venda_id'");
					die;
				}

				// echo '<h2>NF-e enviada com sucesso.</h2>';

				$status = (string) $response->status; // aprovado, reprovado, cancelado, processamento ou contingencia
				$nfe = (int) $response->nfe; // numero da NF-e
				$serie = (int) $response->serie; // numero de serie
				$recibo = (int) $response->recibo; // nuero do recibo
				$chave = $response->chave; // numero da chave de acesso
				$xml = (string) $response->xml; // URL do XML

				//var_dump($response);
				if($status=="aprovado"){

					// ::::: Açoes a serem feitas apos a emissao ::::
					// Guardar dos dados de retorno na banco de dados
					// Enviar um email também por exemplo
					// Atualizar o numero da proxima nf no seu banco de dados
					$proximanfc = (int) $nfe + 1;
					$PDO->query("UPDATE configuracao SET numero_proxima_nfc='$proximanfc'");

					$response_xml = simplexml_load_file("http://nf.mohatron.com/API-NFE/api-nfe/gerador/xml/{$xml}");
					$response_xml = json_encode($response_xml);

					$PDO->query("UPDATE vendas SET
						nf_numero='$nfe',
						nf_status='$status',
						nf_chave='$chave',
						nf_xml='$xml',
						nf_json = '$response_xml'
					where codigo='$venda_id'");

					// echo '<script>window.open('. $endpoint ."danfe/index.php?chave=".$chave."&logo=".$data_nfe["empresa"]["logo"].')</script>';
					// Redirecionar para imprimir a Nota:
					// header("location: ". $endpoint ."danfe/index.php?chave=".$chave."&logo=".$data_nfe["empresa"]["logo"]); exit;
					$errValidar = $endpoint ."danfe/index.php?chave=".$chave."&logo=".$data_nfe["empresa"]["logo"];
					$PDO->query("UPDATE vendas SET nf_pdf='{$errValidar}' where codigo='$venda_id'");
					exit();

				} else {
					// echo "Não foi possível aprovar a nota nesse momento: ". $status;
					$errValidar = "Não foi possível aprovar a nota nesse momento: ". $status;
					$PDO->query("UPDATE vendas SET nf_error='{$errValidar}' where codigo='$venda_id'");
					exit();
				}
			}

			// Atualização do sistem de emissão de notas
