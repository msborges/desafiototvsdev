<?php

namespace models {
    class LanceModel {
        public function listaTodosPorLeilaoSQL($method = false) {
            if ($method) {
                return "SELECT 
                        l.id,
                        l.tbl_usuario_id,
                        u.nome,
                        l.tbl_leilao_id,
                        i.descricao,
                        i.valorinicial,
                        l.valorlance,
                        DATE_FORMAT(l.dtlance, \"%d/%m/%Y\") AS dtlance,
                        DATE_FORMAT(i.dtfinalizacao, \"%d/%m/%Y\") AS dtfinalizacao
                    FROM
                        tbl_lance l
                            INNER JOIN
                        tbl_usuario u ON u.id = l.tbl_usuario_id
                            INNER JOIN
                        tbl_leilao i ON i.id = l.tbl_leilao_id
                    WHERE i.id = :id
                    ORDER BY valorlance DESC LIMIT 1";
            }
            return "SELECT 
                        l.id,
                        l.tbl_usuario_id,
                        u.nome,
                        l.tbl_leilao_id,
                        i.descricao,
                        FORMAT(i.valorinicial, 2, 'pt_BR') AS valorinicial,
                        FORMAT(l.valorlance, 2, 'pt_BR') AS valorlance,
                        DATE_FORMAT(l.dtlance, \"%d/%m/%Y\") AS dtlance,
                        DATE_FORMAT(i.dtfinalizacao, \"%d/%m/%Y\") AS dtfinalizacao
                    FROM
                        tbl_lance l
                            INNER JOIN
                        tbl_usuario u ON u.id = l.tbl_usuario_id
                            INNER JOIN
                        tbl_leilao i ON i.id = l.tbl_leilao_id
                    WHERE i.id = :id
                    ORDER BY valorlance DESC ";
        }

        public function inserirNovoLanceLeilaoSQL($keys) {
            return "INSERT INTO tbl_lance (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")";
        }
    }
}
