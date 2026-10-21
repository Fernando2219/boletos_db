
<?php

/*
 * Código de exemplo da utilização de PDO como persistencia
 * Controlador responsável pela manutenção do cadastro da entidade boleto
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 */

require_once "boleto.php";
require_once "persistencia/PDOboletoDAO.php";

/* definição de constantes */
define("DESTINO", "index.php");
define("ARQUIVO_XML", "boleto.xml");

/* escolha da ação que processará a requisição */
$acao = "";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;

    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

switch ($acao) {
    case 'Salvar':
        salvar();
        break;

    case 'Alterar':
        alterar();
        break;

    case 'excluir':
        excluir();
        break;
}

/*
 * Método que converte formulário html para array com respectivos dados
 * @return array
 */
function tela2array()
{
    $novo = array(
        'id' => isset($_POST['id']) ? $_POST['id'] : "0",
        'data_vencimento' => isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : "",
        'data_emissao' => isset($_POST['data_emissao']) ? $_POST['data_emissao'] : "",
        'data_pagamento' => isset($_POST['data_pagamento']) ? $_POST['data_pagamento'] : "",
        'valor' => isset($_POST['valor']) ? $_POST['valor'] : "0",
        'desconto' => isset($_POST['desconto']) ? $_POST['desconto'] : "0",
        'juros' => isset($_POST['juros']) ? $_POST['juros'] : "0",
        'multa' => isset($_POST['multa']) ? $_POST['multa'] : "0",
        'mora' => isset($_POST['mora']) ? $_POST['mora'] : "0",
        'valor_pago' => isset($_POST['valor_pago']) ? $_POST['valor_pago'] : "0"
    );

    if ($novo['id'] == "0") {
        $novo['id'] = date("YmdHis");
    }

    return $novo;
}

/*
 * Método que converte array para objeto
 * @return objeto
 */
function array2objeto($array_dados)
{
    $elemento = new Boleto();

    $elemento->id = $array_dados['id'];
    $elemento->data_vencimento = $array_dados['data_vencimento'];
    $elemento->data_emissao = $array_dados['data_emissao'];
    $elemento->data_pagamento = $array_dados['data_pagamento'];
    $elemento->valor = $array_dados['valor'];
    $elemento->desconto = $array_dados['desconto'];
    $elemento->juros = $array_dados['juros'];
    $elemento->multa = $array_dados['multa'];
    $elemento->mora = $array_dados['mora'];
    $elemento->valor_pago = $array_dados['valor_pago'];

    return $elemento;
}

/*
 * Método que converte objeto para array
 * @return array
 */
function objeto2array($elemento)
{
    $dado = array(
        'id' => (string) $elemento->id,
        'data_vencimento' => (string) $elemento->data_vencimento,
        'data_emissao' => (string) $elemento->data_emissao,
        'data_pagamento' => (string) $elemento->data_pagamento,
        'valor' => (string) $elemento->valor,
        'desconto' => (string) $elemento->desconto,
        'juros' => (string) $elemento->juros,
        'multa' => (string) $elemento->multa,
        'mora' => (string) $elemento->mora,
        'valor_pago' => (string) $elemento->valor_pago
    );

    return $dado;
}

/*
 * Método que lê os dados e os carrega em uma variável
 * @param $id identificador numérico do registro
 * @return array
 */
function carregar($id)
{
    $dao = PDOboletoDAO::getInstance();
    $dados = $dao->obter($id);

    return $dados;
}

/*
 * Método que altera os dados de um registro
 * @return void
 */
function alterar()
{
    $novo = tela2array();

    $dao = PDOboletoDAO::getInstance();
    $objeto = array2objeto($novo);
    $dados = $dao->alterar($objeto);

    header("location:" . DESTINO);
    exit;
}

/*
 * Método que exclui um registro
 * @return void
 */
function excluir()
{
    $id = isset($_GET['id']) ? $_GET['id'] : "";

    $dao = PDOboletoDAO::getInstance();
    $dados = $dao->excluir($id);

    header("location:" . DESTINO);
    exit;
}

/*
 * Método que salva os dados de um registro
 * @return void
 */
function salvar()
{
    $novo = tela2array();

    $dao = PDOboletoDAO::getInstance();
    $objeto = array2objeto($novo);
    $dados = $dao->inserir($objeto);

    header("location:" . DESTINO);
    exit;
}

?>
