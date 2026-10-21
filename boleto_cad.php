
<?php
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include 'cabecalho.php'; ?>

<?php
include "boleto_acao.php";

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$dados = array();

if ($id != 0)
    $dados = carregar($id);
?>

<body>
    <header class="container">
        <?php include 'menu.php'; ?>
    </header>

    <main class="container">
        <form action="boleto_acao.php" method="post">
            <fieldset>
                <legend>Cadastro de boletos</legend>

                <label for="id">Id</label>
                <input type="text" name="id" id="id"
                    value="<?= $id ?>" readonly><br>

                <label for="data_vencimento">Data de Vencimento</label>
                <input type="date" name="data_vencimento" id="data_vencimento"
                    value="<?= $dados['data_vencimento'] ?? '' ?>" required><br>

                <label for="data_emissao">Data de Emissão</label>
                <input type="date" name="data_emissao" id="data_emissao"
                    value="<?= $dados['data_emissao'] ?? '' ?>" required><br>

                <label for="data_pagamento">Data de Pagamento</label>
                <input type="date" name="data_pagamento" id="data_pagamento"
                    value="<?= $dados['data_pagamento'] ?? '' ?>"><br>

                <label for="valor">Valor</label>
                <input type="number" step="0.01" name="valor" id="valor"
                    value="<?= $dados['valor'] ?? '' ?>" required><br>

                <label for="desconto">Desconto</label>
                <input type="number" step="0.01" name="desconto" id="desconto"
                    value="<?= $dados['desconto'] ?? '' ?>"><br>

                <label for="juros">Juros</label>
                <input type="number" step="0.01" name="juros" id="juros"
                    value="<?= $dados['juros'] ?? '' ?>"><br>

                <label for="multa">Multa</label>
                <input type="number" step="0.01" name="multa" id="multa"
                    value="<?= $dados['multa'] ?? '' ?>"><br>

                <label for="mora">Mora</label>
                <input type="number" step="0.01" name="mora" id="mora"
                    value="<?= $dados['mora'] ?? '' ?>"><br>

                <label for="valor_pago">Valor Pago</label>
                <input type="number" step="0.01" name="valor_pago" id="valor_pago"
                    value="<?= $dados['valor_pago'] ?? '' ?>"><br>

                <input class="primary" type="submit" name="acao" id="acao"
                    value="<?php if ($id == 0)
                        echo 'Salvar';
                    else
                        echo 'Alterar';
                    ?>">

                <input type="reset" value="Cancelar">
            </fieldset>
        </form>
    </main>

    <footer class="container"></footer>
</body>
</html>
