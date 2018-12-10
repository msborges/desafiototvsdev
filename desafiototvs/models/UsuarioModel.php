<?php

namespace models {
    class UsuarioModel {
        public function listaTodosSQL() {
            return "SELECT * FROM tbl_usuario WHERE usrativo = 1";
        }

        public function listaPorIDSQL($method = false) {
            if ($method) {
                return "SELECT * FROM tbl_usuario WHERE id = :id AND usrativo = 0";
            }
            return "SELECT * FROM tbl_usuario WHERE id = :id AND usrativo = 1";
        }

        public function inserirNovoUsuarioSQL($keys) {
            return "INSERT INTO tbl_usuario (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")";
        }

        public function alterarUsuarioPorIDSQL($sets) {
            return "UPDATE tbl_usuario SET ".implode(',', $sets)." WHERE id = :id";
        }

        public function removerUsuarioSQL() {
            return "UPDATE tbl_usuario SET usrativo = 0 WHERE id = :id";
        }
    }
}