<?php

namespace controllers {

    use models\LeilaoModel;
    use models\UsuarioModel;

    class Leilao extends LeilaoModel {
        private $PDO;

        function __construct()
        {
            $this->PDO = new \PDO('mysql:host=localhost;dbname=dbdesafiotovts', 'msborges', 'root');
            $this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function listaTodos() {
            $sth = $this->PDO->prepare(LeilaoModel::listaTodosSQL());
            $sth->execute();

            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function listaPorID($id) {
            $sth = $this->PDO->prepare(LeilaoModel::listaPorIDSQL(false));
            $sth ->bindValue(':id',$id);
            $sth->execute();

            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function novoLeilao($dados) {
            $dados = (sizeof($dados)==0)? $_POST : $dados;
            $keys = array_keys($dados);

            $sth = $this->PDO->prepare(UsuarioModel::listaPorIDSQL(false));
            $sth ->bindValue(':id',$dados["tbl_usuario_id"]);
            $sth->execute();

            $sth->fetchAll(\PDO::FETCH_ASSOC);
            if ($sth->rowCount() > 0) {
                $userVerifica = $sth->fetchAll(\PDO::FETCH_ASSOC);
                if ($userVerifica[0]["usradmin"] != 1) {
                    $result = array(
                        "status" => 0,
                        "message" => "Usuário não é administrador e não pode criar novos leilões."
                    );
                    return $result;
                }
            }

            $sth = $this->PDO->prepare(LeilaoModel::inserirNovoLeilaoSQL($keys));
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

        public function editarLeilao($idLeilao, $dados) {
            $dados = (sizeof($dados)==0)? $_POST : $dados;

            $sth = $this->PDO->prepare(LeilaoModel::listaPorIDSQL(true));
            $sth ->bindValue(':id',$idLeilao);
            $sth->execute();

            $sth->fetchAll(\PDO::FETCH_ASSOC);
            if ($sth->rowCount() > 0) {
                $result = array(
                    "status" => 0,
                    "message" => "Leilão desativado. Não poderá ser editado."
                );
                return $result;
            }

            $sth = $this->PDO->prepare(UsuarioModel::listaPorIDSQL(false));
            $sth ->bindValue(':id',$dados["tbl_usuario_id"]);
            $sth->execute();

            $sth->fetchAll(\PDO::FETCH_ASSOC);
            if ($sth->rowCount() > 0) {
                $userVerifica = $sth->fetchAll(\PDO::FETCH_ASSOC);
                if ($userVerifica[0]["usradmin"] != 1) {
                    $result = array(
                        "status" => 0,
                        "message" => "Usuário não é administrador e não pode alterar leilões."
                    );
                    return $result;
                }
            }


            $sets = [];
            foreach ($dados as $key => $VALUES) {
                $sets[] = $key." = :".$key;
            }

            $sth = $this->PDO->prepare(LeilaoModel::alterarLeilaoPorIDSQL($sets));
            $sth ->bindValue(':id',$idLeilao);
            foreach ($dados as $key => $value) {
                $sth ->bindValue(':'.$key,$value);
            }

            $sth->execute();

            $result = array(
                "status" => 1,
                "message" => "Registro atualizado com sucesso."
            );

            return $result;
        }

        public function excluirLeilao($idLeilao) {
            $sth = $this->PDO->prepare(LeilaoModel::removerLeilaoSQL());
            $sth ->bindValue(':id',$idLeilao);

            $sth->execute();

            $result = array(
                "status" => 1,
                "message" => "Registro excluído com sucesso."
            );

            return $result;
        }
    }
}