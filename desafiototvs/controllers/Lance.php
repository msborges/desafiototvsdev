<?php

namespace controllers {

    use models\LanceModel;
    use models\LeilaoModel;
    use models\UsuarioModel;

    class Lance extends LanceModel {
        private $PDO;

        function __construct()
        {
            $this->PDO = new \PDO('mysql:host=localhost;dbname=dbdesafiotovts', 'msborges', 'root');
            $this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function listaTodosPorLeilaoID($id) {
            $sth = $this->PDO->prepare(LanceModel::listaTodosPorLeilaoSQL(false));
            $sth->bindValue(':id',$id);
            $sth->execute();

            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

            return $result;
        }

        public function novoLancePorLeilao($dados) {
            $dados = (sizeof($dados)==0)? $_POST : $dados;
            $keys = array_keys($dados);

            $sth = $this->PDO->prepare(LeilaoModel::listaPorIDSQL(false));
            $sth ->bindValue(':id',$dados["tbl_leilao_id"]);
            $sth->execute();

            if ($sth->rowCount() > 0) {
                $leilaoVerifica = $sth->fetchAll(\PDO::FETCH_ASSOC);
                if ($leilaoVerifica[0]["leilativo"] != 1) {
                    $result = array(
                        "status" => 0,
                        "message" => "Esse leilão está desativado. Não é possível dar lances."
                    );
                    return $result;
                } else if ($leilaoVerifica[0]["dtfinalizacao"] < date("d/m/Y")) {
                    $result = array(
                        "status" => 0,
                        "message" => "Esse leilão já venceu. Não é possível dar lances."
                    );
                    return $result;
                }
            }
            $sth = $this->PDO->prepare(LanceModel::listaTodosPorLeilaoSQL(true));
            $sth->bindValue(':id',$dados["tbl_leilao_id"]);
            $sth->execute();

            if ($sth->rowCount() > 0) {
                $ultimoLanceValor = $sth->fetchAll(\PDO::FETCH_ASSOC);
                $num1 = floatval(str_replace(".", "", $ultimoLanceValor[0]["valorlance"]));
                $num2 = floatval(str_replace(".", "", ["valorlance"]));
                if ($num1 >= $num2) {
                    $result = array(
                        "status" => 0,
                        "message" => "Seu lance deve ser maior que o último lance cadastrado."
                    );
                    return $result;
                }
            }

            $sth = $this->PDO->prepare(LanceModel::inserirNovoLanceLeilaoSQL($keys));
            foreach ($dados as $key => $value) {
                $sth ->bindValue(':'.$key,$value);
            }
            $sth->execute();

            $result = array(
                "status" => 1,
                "ultimoID" => $this->PDO->lastInsertId(),
                "message" => "Registro inserido com sucesso."
            );

            return $result;
        }

    }
}