<?php

    class Data
    {
        public $_db = null;

        function __construct()
        {
            global $db;

            $this->_db = $db;
        }


        public function getDepartments($keyword='')
        {
            $keyword = trim($keyword);

            $where  = '';
            $params = [];
            if ($keyword) {
                $params[] = '%' . $keyword . '%';
                $where    = " WHERE LOWER(department_code || ' ' || department_label_en) LIKE LOWER(?) ";
            }

            $filter = "SELECT department_code, department_label_en FROM departments d " . $where . " ORDER BY department_label_en ASC";
            $rows   = $this->_db->fetchPairs($filter, $params);

            return $rows;

        }


        public function getCourseCodes($keyword='')
        {
            $keyword = trim($keyword);

            $where  = '';
            $params = [];
            if ($keyword) {
                $params[] = '%' . $keyword . '%';
                $where    = " WHERE LOWER((course_code || ' ' || course_number || ' - ' || course_label_en)) LIKE LOWER(?) ";
            }


            $filter = "
                SELECT (course_code || '' || course_number) AS course_key,
                       (course_code || ' ' || course_number || ' - ' || course_label_en) AS course_label
                  FROM 
                       courses d
                   " . $where . " 
                 ORDER BY 
                          course_code ASC, course_number ASC
            ";

            $rows = $this->_db->fetchPairs($filter, $params);

            return $rows;

        }


        public function getCourseInfo($code)
        {
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
                 ";

            $data = $this->_db->fetchRow($filter, array($code));

            return $data;

        }

        public function searchCourses($keyword)
        {
            if (!$keyword) {
                return [];
            }

            $params   = [];
            $params[] = '%' . $keyword . '%';


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


        public function curriculumCourses($studentId)
        {
            if (!$studentId) {
                return [];
            }

            $params   = [$studentId];

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
