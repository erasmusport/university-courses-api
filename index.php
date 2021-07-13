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

            case 'version'://version of the API

                $results = '202107141000';

                break;

            case 'departments':

                $keyword = trim($_GET['keyword']);

                $dataObj = new Data();
                $results = $dataObj->getDepartments($keyword);

                break;

            case 'course-codes':

                $keyword      = trim($_GET['keyword']);
                $academicYear = trim($_GET['academic-year']);

                $dataObj = new Data();
                $results = $dataObj->getCourseCodes($keyword, $academicYear);

                break;

            case 'course-info':

                $code         = trim($_GET['code']);
                $academicYear = trim($_GET['academic-year']);

                $dataObj = new Data();
                $results = $dataObj->getCourseInfo($code, $academicYear);

                break;

            case 'search-courses':

                $keyword      = trim($_GET['keyword']);
                $academicYear = trim($_GET['academic-year']);

                $dataObj = new Data();
                $results = $dataObj->searchCourses($keyword, $academicYear);

                break;

            case 'student-curriculum-courses':

                $studentId    = trim($_GET['student-id']);
                $academicYear = trim($_GET['academic-year']);

                $dataObj = new Data();
                $results = $dataObj->curriculumCourses($studentId, $academicYear);

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
        $res->msg        = trim($errorArr[0]);
        $res->error_code = trim($errorArr[0]);
        $res->error_msg  = trim($errorArr[1]);

        if (DEBUG) {
            $res->debug = print_r($e->getMessage(), true);
        }

    }

    echo json_encode($res);
    exit;

