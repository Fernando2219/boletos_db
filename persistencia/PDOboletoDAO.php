
<?php

include_once __DIR__ . "/boletoDAO.php";

class PDOboletoDAO extends BoletoDAO
{
    private static $instance = NULL;
    private $conn = NULL;

    public function __construct()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new PDOboletoDAO();
        }

        return self::$instance;
    }

    public function connect()
    {
        try {
            $this->conn = new PDO(
                'sqlite:' . __DIR__ . '/boleto.db'
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            throw new RuntimeException(
                'Erro ao conectar ao banco SQLite: ' . $e->getMessage(),
                0,
                $e
            );
        }
    }

    function inserir($objeto)
    {
        try {
            $stmt = $this->conn->prepare(
                'INSERT INTO boleto
                (data_vencimento, data_emissao, data_pagamento, valor, desconto, juros, multa, mora, valor_pago)
                VALUES
                (:data_vencimento, :data_emissao, :data_pagamento, :valor, :desconto, :juros, :multa, :mora, :valor_pago)'
            );

            $stmt->execute(array(
                ':data_vencimento' => $objeto->data_vencimento,
                ':data_emissao' => $objeto->data_emissao,
                ':data_pagamento' => $objeto->data_pagamento,
                ':valor' => $objeto->valor,
                ':desconto' => $objeto->desconto,
                ':juros' => $objeto->juros,
                ':multa' => $objeto->multa,
                ':mora' => $objeto->mora,
                ':valor_pago' => $objeto->valor_pago
            ));

            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }

    function alterar($objeto)
    {
        try {
            $stmt = $this->conn->prepare(
                'UPDATE boleto SET
                data_vencimento = :data_vencimento,
                data_emissao = :data_emissao,
                data_pagamento = :data_pagamento,
                valor = :valor,
                desconto = :desconto,
                juros = :juros,
                multa = :multa,
                mora = :mora,
                valor_pago = :valor_pago
                WHERE id = :id'
            );

            $stmt->execute(array(
                ':data_vencimento' => $objeto->data_vencimento,
                ':data_emissao' => $objeto->data_emissao,
                ':data_pagamento' => $objeto->data_pagamento,
                ':valor' => $objeto->valor,
                ':desconto' => $objeto->desconto,
                ':juros' => $objeto->juros,
                ':multa' => $objeto->multa,
                ':mora' => $objeto->mora,
                ':valor_pago' => $objeto->valor_pago,
                ':id' => $objeto->id
            ));

            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }

    function excluir($id)
    {
        try {
            $stmt = $this->conn->prepare(
                'DELETE FROM boleto WHERE id = :id'
            );

            $stmt->execute(array(':id' => $id));

            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }


    function listar()
    {
        $dados = array();

        try {
            $sql = "SELECT
                    ID AS id,
                    DATA_VENCIMENTO AS data_vencimento,
                    DATA_EMISSAO AS data_emissao,
                    DATA_PAGAMENTO AS data_pagamento,
                    VALOR AS valor,
                    DESCONTO AS desconto,
                    JUROS AS juros,
                    MULTA AS multa,
                    MORA AS mora,
                    VALOR_PAGO AS valor_pago
                FROM boleto";

            $result = $this->conn->query($sql);

            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $dados[] = $linha;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return $dados;
    }



    function listar_filtro($filtro)
    {
        $dados = array();

        try {
            $sql = "SELECT
                    ID AS id,
                    DATA_VENCIMENTO AS data_vencimento,
                    DATA_EMISSAO AS data_emissao,
                    DATA_PAGAMENTO AS data_pagamento,
                    VALOR AS valor,
                    DESCONTO AS desconto,
                    JUROS AS juros,
                    MULTA AS multa,
                    MORA AS mora,
                    VALOR_PAGO AS valor_pago
                FROM boleto " . $filtro;

            $result = $this->conn->query($sql);

            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $dados[] = $linha;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return $dados;
    }


    function obter($id)
    {
        $boleto = array();

        try {
            $sql = "SELECT
                    ID AS id,
                    DATA_VENCIMENTO AS data_vencimento,
                    DATA_EMISSAO AS data_emissao,
                    DATA_PAGAMENTO AS data_pagamento,
                    VALOR AS valor,
                    DESCONTO AS desconto,
                    JUROS AS juros,
                    MULTA AS multa,
                    MORA AS mora,
                    VALOR_PAGO AS valor_pago
                FROM boleto
                WHERE ID = ?";

            $result = $this->conn->prepare($sql);
            $result->execute([$id]);

            $linha = $result->fetch(PDO::FETCH_ASSOC);

            if ($linha) {
                $boleto = $linha;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return $boleto;
    }
}
?>
