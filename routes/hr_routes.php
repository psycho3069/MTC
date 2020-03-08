<?php 

//------HR-AND-PAYROLL START-------//

//DEPARTMENT
Route::get('/hr_payroll/department/departments', 'HRandPayrollController@department')->name('Departments');
Route::get('/hr_payroll/department/add_department', 'HRandPayrollController@add_department')->name('Add Department');
Route::post('/save_department','HRandPayrollController@save_department');
Route::get('/edit_department/{id}','HRandPayrollController@edit_department')->name('Edit Department');
Route::post('/update_department/{id}','HRandPayrollController@update_department');
Route::get('/delete_department/{id}','HRandPayrollController@delete_department');

//EMPLOYEE-DESIGNATION
Route::get('/hr_payroll/employee_designation/employee_designations', 'HRandPayrollController@employee_designation')->name('Employee Designations');
Route::get('/hr_payroll/employee_designation/add_employee_designation', 'HRandPayrollController@add_employee_designation')->name('Add Employee Designation');
Route::post('/save_employee_designation','HRandPayrollController@save_employee_designation');
Route::get('/edit_employee_designation/{id}','HRandPayrollController@edit_employee_designation')->name('Edit Employee Designation');
Route::post('/update_employee_designation/{id}','HRandPayrollController@update_employee_designation');
Route::get('/delete_employee_designation/{id}','HRandPayrollController@delete_employee_designation');

//SALARY-GRADE
Route::get('/hr_payroll/salary_grade/salary_grades', 'HRandPayrollController@salary_grade')->name('Departments');
Route::get('/hr_payroll/salary_grade/add_salary_grade', 'HRandPayrollController@add_salary_grade')->name('Add SALARY-GRADE');
Route::post('/save_salary_grade','HRandPayrollController@save_salary_grade');
Route::get('/edit_salary_grade/{id}','HRandPayrollController@edit_salary_grade')->name('Edit SALARY-GRADE');
Route::post('/update_salary_grade/{id}','HRandPayrollController@update_salary_grade');
Route::get('/delete_salary_grade/{id}','HRandPayrollController@delete_salary_grade');

//LEAVE
Route::get('/hr_payroll/leave/leaves', 'HRandPayrollController@leave')->name('Leaves');
Route::get('/hr_payroll/leave/add_leave', 'HRandPayrollController@add_leave')->name('Add Leave');
Route::get('/hr_payroll/leave/leave_categories', 'HRandPayrollController@leave_category')->name('Leaves Categories');
Route::get('/hr_payroll/leave/add_leave_category', 'HRandPayrollController@add_leave_category')->name('Add Leave Category');
Route::post('/save_leave','HRandPayrollController@save_leave');
Route::post('/save_leave_category','HRandPayrollController@save_leave_category');
Route::get('/edit_leave/{id}','HRandPayrollController@edit_leave')->name('Edit Leave');
Route::post('/update_leave/{id}','HRandPayrollController@update_leave');
Route::get('/delete_leave/{id}','HRandPayrollController@delete_leave');
Route::get('/edit_leave_category/{id}','HRandPayrollController@edit_leave_category')->name('Edit Leave Category');
Route::post('/update_leave_category/{id}','HRandPayrollController@update_leave_category');
Route::get('/delete_leave_category/{id}','HRandPayrollController@delete_leave_category');



//EMPLOYEE
Route::get('/hr_payroll/employee/employees', 'HRandPayrollController@employee')->name('Employees');
Route::get('/hr_payroll/employee/add_employee', 'HRandPayrollController@add_employee')->name('Add Employee');
Route::post('/save_employee','HRandPayrollController@save_employee');
Route::get('/edit_employee/{id}','HRandPayrollController@edit_employee')->name('Edit Employee');
Route::post('/update_employee/{id}','HRandPayrollController@update_employee');
Route::get('/delete_employee/{id}','HRandPayrollController@delete_employee');

//------HR-AND-PAYROLL END-------//