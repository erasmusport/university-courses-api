# university-courses-api
Course list and course information publisher API for universities.
Keywords:
- PHP
- API
- Zend Framework library

contact: github->issues

### Sample URLs and Output

> ?job=search-courses&keyword=Analytical
>>  {"res":1,"data":[{"course_code":"CHEM","course_number":"211","course_label_en":"Analytical Chemistry I","ects_credits":"5","course_shortname":"CHEM 211","course_key":"CHEM211","course_label":"CHEM 211 - Analytical Chemistry I"},{"course_code":"CHEM","course_number":"214","course_label_en":"Analytical Chemistry Laboratory II","ects_credits":"3,5","course_shortname":"CHEM 214","course_key":"CHEM214","course_label":"CHEM 214 - Analytical Chemistry Laboratory II"},{"course_code":"ECON","course_number":"400","course_label_en":"Analytical Writing for Economist","ects_credits":"5","course_shortname":"ECON 400","course_key":"ECON400","course_label":"ECON 400 - Analytical Writing for Economist"},{"course_code":"FRP","course_number":"103","course_label_en":"Analytical Reading and Writing Strategies I","ects_credits":null,"course_shortname":"FRP 103","course_key":"FRP103","course_label":"FRP 103 - Analytical Reading and Writing Strategies I"},{"course_code":"FRP","course_number":"203","course_label_en":"Analytical Reading and Writing Strategies II","ects_credits":null,"course_shortname":"FRP 203","course_key":"FRP203","course_label":"FRP 203 - Analytical Reading and Writing Strategies II"}]}

> /?job=course-codes (shortened..)
>> {"res":1,"data":{"ADA131":"ADA 131 - Architectural Drawing","AMER115":"AMER 115 - Methods and Texts I","CHEM101":"CHEM 101 - Principles of Chemistry I",COMD308":"COMD 308 - Multi-Camera Production and Live-Recording","TURK102":"TURK 102 - Turkish II"}}


> ?job=course-info&code=MATH241
>> {"res":1,"data":{"course_code":"MATH","course_number":"241","course_label_en":"Engineering Mathematics I","ects_credits":"6,5","description_en":"Introduction to complex algebra. Systems of linear equations, Gaussian elimination. Vector spaces and their extension to complex case, linear dependence\/independence, bases. Matrix algebra, determinant, inverse, factorization. Eigenvalue problem, diagonalization, quadratic forms. Linear approximation, curve fitting. Linear constant coefficient difference equations and the z-transform. Linear constant coefficient differential equations and the Laplace transform. System of linear differential equations.","prerequisites":"MATH 102 or MATH 112 or MATH 114"}}