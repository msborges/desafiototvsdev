<?php

namespace controllers {

    use models\UsuarioModel;

    class Usuario extends UsuarioModel {
        private $PDO;

        function __construct() {
            $this->PDO = new \PDO('mysql:host=localhost;dbname=dbdesafiotovts', 'msborges', 'root');
            $this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION );
        }

        public function listaTodos() {
            $sth = $this->PDO->prepare(UsuarioModel::listaTodosSQL());
            $sth->execute();

            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function listaPorID($id) {
            $sth = $this->PDO->prepare(UsuarioModel::listaPorIDSQL(false));
            $sth ->bindValue(':id',$id);
            $sth->execute();

            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function novoUsuario($dados) {
            $dados = (sizeof($dados)==0)? $_POST : $dados;
            $keys = array_keys($dados);

            if (key_exists("email", $dados)) {
                if (!$this->validaEmail($dados["email"])) {
                    $result = array(
                        "status" => 0,
                        "message" => "E-mail informado não é válido."
                    );
                    return $result;
                }
            }

            if (key_exists("cpf", $dados)) {
                if (!$this->validaCPF($dados["cpf"])) {
                    $result = array(
                        "status" => 0,
                        "message" => "CPF informado não é válido."
                    );
                    return $result;
                }
            }

            $sth = $this->PDO->prepare(UsuarioModel::inserirNovoUsuarioSQL($keys));
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

        public function editarUsuario($idUsuario, $dados) {
            $dados = (sizeof($dados)==0)? $_POST : $dados;

            if (key_exists("email", $dados)) {
                if (!$this->validaEmail($dados["email"])) {
                    $result = array(
                        "status" => 0,
                        "message" => "E-mail informado não é válido."
                    );
                    return $result;
                }
            }

            if (key_exists("cpf", $dados)) {
                if (!$this->validaCPF($dados["cpf"])) {
                    $result = array(
                        "status" => 0,
                        "message" => "CPF informado não é válido."
                    );
                    return $result;
                }
            }

            $sth = $this->PDO->prepare(UsuarioModel::listaPorIDSQL(true));
            $sth ->bindValue(':id',$idUsuario);
            $sth->execute();

            $sth->fetchAll(\PDO::FETCH_ASSOC);
            if ($sth->rowCount() > 0) {
                $result = array(
                    "status" => 0,
                    "message" => "Usuário desativado. Não poderá ser editado."
                );
                return $result;
            }


            $sets = [];
            foreach ($dados as $key => $VALUES) {
                $sets[] = $key." = :".$key;
            }

            $sth = $this->PDO->prepare(UsuarioModel::alterarUsuarioPorIDSQL($sets));
            $sth ->bindValue(':id',$idUsuario);
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

        public function excluirUsuario($idUsuario) {
            $sth = $this->PDO->prepare(UsuarioModel::removerUsuarioSQL());
            $sth ->bindValue(':id',$idUsuario);

            $sth->execute();

            $result = array(
                "status" => 1,
                "message" => "Registro excluído com sucesso."
            );

            return $result;
        }

        private function validaEmail($email = null) {
            if(empty($email)) {
                return false;
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }

        private function validaCPF($cpf = null) {
            if(empty($cpf)) {
                return false;
            }
            $cpf = preg_replace("/[^0-9]/", "", $cpf);
            $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
            if (strlen($cpf) != 11) {
                return false;
            } else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
                return false;
            } else {
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }
                return true;
            }
        }
    }
}