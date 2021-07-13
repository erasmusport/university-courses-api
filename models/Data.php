<?php

    class Data
    {
        public $_db = null;

        function __construct()
        {
            global $db;

            $this->_db = $db;
        }


        public function getDepartments($keyword = '')
        {
            $keyword = trim($keyword);

            $where       = [];
            $params      = [];
            $whereString = '';

            if ($keyword) {
                //you can change this to a DBMS specific SQL code.
                $where[]  = "LOWER(department_code || ' ' || department_label_en) LIKE LOWER(?)";
                $params[] = '%' . $keyword . '%';
            }

            if ($where) {
                $whereString = ' WHERE ' . (implode(' AND ', $where));
            }

            $filter = "SELECT department_code, department_label_en FROM departments d " . $whereString . " ORDER BY department_label_en ASC";
            $rows   = $this->_db->fetchPairs($filter, $params);

            return $rows;

        }


        public function getCourseCodes($keyword = '', $academicYear = '')
        {
            $keyword = trim($keyword);

            $where       = [];
            $params      = [];
            $whereString = '';

            if ($keyword) {
                //you can change this to a DBMS specific SQL code.
                $where[]  = "LOWER((course_code || ' ' || course_number || ' - ' || course_label_en)) LIKE LOWER(?)";
                $params[] = '%' . $keyword . '%';
            }

            if ($academicYear) {
                $where[]  = "academic_year = ?";
                $params[] = $academicYear;
            }

            if ($where) {
                $whereString = ' WHERE ' . (implode(' AND ', $where));
            }

            $filter = "
                SELECT (course_code || '' || course_number) AS course_key,
                       (course_code || ' ' || course_number || ' - ' || course_label_en) AS course_label
                  FROM 
                       courses d
                   " . $whereString . " 
                 ORDER BY 
                          course_code ASC, course_number ASC
            ";

            $rows = $this->_db->fetchPairs($filter, $params);

            return $rows;

        }


        public function getCourseInfo($code, $academicYear = '')
        {

            $where       = [];
            $params      = [];
            $whereString = '';

            $params[] = $code;

            if ($academicYear) {
                $where[]  = "academic_year = ?";
                $params[] = $academicYear;
            }

            if ($where) {
                $whereString = ' ' . (implode(' AND ', $where));
            }

            $filter = "
                SELECT 
                    course_code,
                    course_number,
                    course_label_en,
                    ects_credits,
                    prerequisites,
                    description_en,
                    (course_code || ' ' || course_number) AS course_shortname,
                    (course_code || '' || course_number) AS course_key,
                    (course_code || ' ' || course_number || ' - ' || course_label_en) AS course_label,
                    department_code,
                    department_label_en
                    
                FROM 
                     courses d
                WHERE 
                      (course_code || '' || course_number) = ?
                      " . $whereString . " 
                      
                 ";

            $data = $this->_db->fetchRow($filter, array($code));

            return $data;

        }

        public function searchCourses($keyword, $academicYear = '')
        {
            if (!$keyword) {
                return [];
            }

            $params      = [];
            $where       = [];
            $whereString = '';

            $params[] = '%' . $keyword . '%';

            if ($academicYear) {
                $where[]  = "academic_year = ?";
                $params[] = $academicYear;
            }

            if ($where) {
                $whereString = ' ' . (implode(' AND ', $where));
            }


            $filter = "
               SELECT 
                   course_code,
                   course_number,
                   course_label_en,
                   ects_credits,
                   (course_code || '' || course_number) AS course_key,
                   (course_code || ' ' || course_number) AS course_shortname,
                   (course_code || ' ' || course_number || ' - ' || course_label_en) AS course_label
               FROM 
                    courses d
               WHERE 
                     LOWER(course_code || ' ' || course_number || ' - ' || course_label_en) LIKE LOWER(?)
                     " . $whereString . "
               ORDER BY 
                        course_code ASC, course_number ASC
            ";

            $rows = $this->_db->fetchAll($filter, $params);

            if (DEBUG) {
                print_r($filter);
                print_r($params);
                print_r($rows);
            }

            return $rows;

        }


        public function curriculumCourses($studentId, $academicYear = '')
        {
            if (!$studentId) {
                return [];
            }

            $params      = [$studentId];
            $where       = [];
            $whereString = '';


            if ($academicYear) {
                $where[]  = "academic_year = ?";
                $params[] = $academicYear;
            }

            if ($where) {
                $whereString = ' ' . (implode(' AND ', $where));
            }


            $filter = "
               SELECT 
                   course_code,
                   course_number,
                   course_label_en,
                   ects_credits,
                   (course_code || '' || course_number) AS course_key,
                   (course_code || ' ' || course_number) AS course_shortname,
                   (course_code || ' ' || course_number || ' - ' || course_label_en) AS course_label
               FROM 
                    student_curriculum sc
               WHERE 
                     sc.student_id = ?
                     " . $whereString . "
               ORDER BY 
                    course_code ASC, course_number ASC
            ";

            $rows = $this->_db->fetchAll($filter, $params);

            if (DEBUG) {
                print_r($filter);
                print_r($params);
                print_r($rows);
            }

            return $rows;

        }


    }
