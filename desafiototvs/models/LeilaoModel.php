<?php

namespace models {
    class LeilaoModel {
        public function listaTodosSQL() {
            return "SELECT 
                        i.id,
                        i.tbl_usuario_id,
                        u.nome,
                        i.tbl_situacao_id,
                        s.descricao,
                        i.descricao,
                        FORMAT(i.valorinicial, 2, 'pt_BR') AS valorinicial,
                        DATE_FORMAT(i.dtabertura, \"%d/%m/%Y\") AS dtabertura,
                        DATE_FORMAT(i.dtfinalizacao, \"%d/%m/%Y\") AS dtfinalizacao,
                        i.leilativo
                    FROM
                        tbl_leilao i
                            INNER JOIN
                                tbl_usuario u ON u.id = i.tbl_usuario_id
                            INNER JOIN
                                tbl_situacao s ON s.id = i.tbl_situacao_id";
        }

        public function listaPorIDSQL($method = false) {
            if ($method) {
                return "SELECT 
                            i.id,
                            i.tbl_usuario_id,
                            u.nome,
                            i.tbl_situacao_id,
                            s.descricao,
                            i.descricao,
                            FORMAT(i.valorinicial, 2, 'pt_BR') AS valorinicial,
                            DATE_FORMAT(i.dtabertura, \"%d/%m/%Y\") AS dtabertura,
                            DATE_FORMAT(i.dtfinalizacao, \"%d/%m/%Y\") AS dtfinalizacao,
                            i.leilativo
                        FROM
                            tbl_leilao i
                                INNER JOIN
                                    tbl_usuario u ON u.id = i.tbl_usuario_id
                                INNER JOIN
                                    tbl_situacao s ON s.id = i.tbl_situacao_id
                        WHERE
                            i.id = :id AND leilativo = 0";
            }
            return "SELECT 
                        i.id,
                        i.tbl_usuario_id,
                        u.nome,
                        i.tbl_situacao_id,
                        s.descricao,
                        i.descricao,
                        FORMAT(i.valorinicial, 2, 'pt_BR') AS valorinicial,
                        DATE_FORMAT(i.dtabertura, \"%d/%m/%Y\") AS dtabertura,
                        DATE_FORMAT(i.dtfinalizacao, \"%d/%m/%Y\") AS dtfinalizacao,
                        i.leilativo
                    FROM
                        tbl_leilao i
                            INNER JOIN
                                tbl_usuario u ON u.id = i.tbl_usuario_id
                            INNER JOIN
                                tbl_situacao s ON s.id = i.tbl_situacao_id
                    WHERE
                        i.id = :id";
        }

        public function inserirNovoLeilaoSQL($keys) {
            return "INSERT INTO tbl_leilao (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")";
        }

        public function alterarLeilaoPorIDSQL($sets) {
            return "UPDATE tbl_leilao SET ".implode(',', $sets)." WHERE id = :id";
        }

        public function removerLeilaoSQL() {
            return "UPDATE tbl_leilao SET leilativo = 0 WHERE id = :id";
        }
    }
}
