<?php

    class Common
    {
        function authenticateApi()
        {
            global $allowedIpNumbers;

            if (!in_array($_SERVER['REMOTE_ADDR'], $allowedIpNumbers)) {
                //throw new Exception('ERR404|Unauthorized access!(' . $_SERVER['REMOTE_ADDR'] . '' . print_r($allowedIpNumbers, true) . ')|' . $_SERVER['REMOTE_ADDR']);
                throw new Exception('ERROR 400 | Unauthorized access! (' . $_SERVER['REMOTE_ADDR'] . ') | ' . $_SERVER['REMOTE_ADDR']);
            }
        }


    }
