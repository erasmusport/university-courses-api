<?php

    try {

        define('ADMIN_EMAIL', 'xyz@uni.edu');

        set_include_path('./vendor/ZendFramework/1.12.20-custom/');

        //require_once('Zend/Loader.php');
        require_once('Zend/Db.php');
        require_once('models/Common.php');
        require_once('models/Data.php');


        $config['db']['adapter']                                   = 'Pdo_xyz';
        $config['db']['params']['username']                        = 'xyz_dbuser';
        $config['db']['params']['password']                        = 'xyz_dbpass';
        $config['db']['params']['dbname']                          = 'xyz_dbname';
        $config['db']['params']['options']['caseFolding']          = 2;
        $config['db']['params']['options']['autoQuoteIdentifiers'] = false;
        //$config['db']['params']['charset'] = '';
        //$config['db']['params']['options']['persistent'] = true;

        $db = Zend_Db::factory($config['db']['adapter'], $config['db']['params']);

        //$db->getServerVersion();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);


        $allowedIpNumbers = [//which IPs can access to this API
            '127.0.0.1',//ip description
            '10.0.0.50',//ip description
        ];

    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
