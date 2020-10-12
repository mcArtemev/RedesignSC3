<?php

namespace framework\ajax\data_request;

use framework\pdo;
use framework\ajax as ajax;

class data_request extends ajax\ajax {

    public function __construct($args)
    {
        parent::__construct('');

        $sql = "SELECT * FROM partners WHERE name IN ";

        $q_partners = '(\'' . implode( '\',\'', $args ) . '\')';

        $sql .= $q_partners;

        $stmt = pdo::getPdo()->prepare($sql);
        $stmt->execute( );
        $result = $stmt->fetchAll( \PDO::FETCH_ASSOC);

        $this->getWrapper()->addChildren( json_encode( $result ) );


//        $sql = "SELECT `partner_id` FROM `sites` WHERE `name` IN ('".implode("','", $args)."')";
//        $partners_id = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
//
//        $t = array();
//        foreach ($partners_id as $partner_id)
//            $t[] = $partner_id['partner_id'];
//
//        $partners_id = $t;
//
//        $partners_id = array_unique($partners_id);
//
//        $sql = "UPDATE `partners` SET `email` = 'litovchenko@list.ru' WHERE `id` IN (".implode(',', $partners_id).")";
//        pdo::getPdo()->query($sql);
    }
}