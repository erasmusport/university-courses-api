<?php
    if (!ini_get('display_startup_errors')) {
        ini_set('display_startup_errors', 1);
    }
    if (!ini_get('display_errors')) {
        ini_set('display_errors', 1);
    }

    $res = new stdClass();

    try {

        require_once('config.php');

        $commonObj = new Common();
        $commonObj->authenticateApi();


        $job   = trim($_GET['job']);
        $debug = trim($_GET['debug']);

        define('DEBUG', (($debug == '1') ? true : false));

        switch ($job) {

            case 'departments':

                $keyword = trim($_GET['keyword']);

                $dataObj = new Data();
                $results = $dataObj->getDepartments($keyword);

                break;

            case 'course-codes':

                $keyword = trim($_GET['keyword']);

                $dataObj = new Data();
                $results = $dataObj->getCourseCodes($keyword);

                break;

            case 'course-info':

                $code = trim($_GET['code']);

                $dataObj = new Data();
                $results = $dataObj->getCourseInfo($code);

                break;

            case 'search-courses':

                $keyword = trim($_GET['keyword']);

                $dataObj = new Data();
                $results = $dataObj->searchCourses($keyword);

                break;

            default:
            case '':
                throw new Exception('ERR105|Invalid job!');
                break;
        }


        $res->res  = 1;
        $res->data = $results;

    } catch (Exception $e) {
        $errorArr = explode('|', $e->getMessage());

        $res->res        = 0;
        $res->msg        = $errorArr[0];
        $res->error_code = $errorArr[0];
        $res->error_msg  = $errorArr[1];

        if (DEBUG) {
            $res->debug = print_r($e->getMessage(), true);
        }

    }

    echo json_encode($res);
    exit;

