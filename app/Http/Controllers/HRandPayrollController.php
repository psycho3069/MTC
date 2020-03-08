<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use DB;
use PDF;
use Auth;
use Session;
use Exception;


class HRandPayrollController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    //------- METHODS FOR DEPARTMENT --------//
    //DEPARTMENT
    public function department(){
        $department_info=DB::table('e1_departments')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_departments=view('admin.hr_payroll.department.departments')
                         ->with('department_info',$department_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.department.departments',$manage_departments);
    }
    //ADD-DEPARTMENT
    public function add_department(){
        return view('admin.hr_payroll.department.add_department');
    }
    //SAVE DEPARTMENT TO DATABASE
    public function save_department(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:e1_departments'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('e1_departments')->insert($data);
        Session::put('message','Department is Added Successfully');
        return Redirect::to('/hr_payroll/department/add_department');
    }
    //EDIT DEPARTMENT
    public function edit_department($id)
    {
        $department=DB::table('e1_departments')
                           ->where('id',$id)
                           ->first();
        $manage_department=view('admin.hr_payroll.department.edit_department')
                         ->with('department',$department);
        return view('admin.master')
                         ->with('admin.hr_payroll.department.edit_department',$manage_department);
    }
    //UPDATE DEPARTMENT
    public function update_department(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('e1_departments')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Department has been updated Successfully');
        return Redirect::to('/hr_payroll/department/departments');
    }
    //DELETE DEPARTMENT FROM DATABASE
    public function delete_department($id)
    {
        try {
          DB::table('e1_departments')
                ->where('id',$id)
                ->delete();
          Session::put('message', 'Department has been deleted Successfully');
          return Redirect::to('/hr_payroll/department/departments');
        } catch (Exception $e) {
          return back()->withError('This Department cannot be deleted because other Employee/Employees depend on it. To delete this Department, delete dependent Employee/Employees first, only then you can delete it.');
        }
    }


    //------- METHODS FOR EMPLOYEE-DESIGNATION --------//
    //EMPLOYEE-DESIGNATION
    public function employee_designation(){
        $employee_designation_info=DB::table('e2_employee_designations')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_employee_designations=view('admin.hr_payroll.employee_designation.employee_designations')
                         ->with('employee_designation_info',$employee_designation_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.employee_designation.employee_designations',$manage_employee_designations);
    }
    //ADD-EMPLOYEE-DESIGNATION
    public function add_employee_designation(){
        return view('admin.hr_payroll.employee_designation.add_employee_designation');
    }
    //SAVE EMPLOYEE-DESIGNATION TO DATABASE
    public function save_employee_designation(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:e2_employee_designations'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('e2_employee_designations')->insert($data);
        Session::put('message','Employee Designation is Added Successfully');
        return Redirect::to('/hr_payroll/employee_designation/add_employee_designation');
    }
    //EDIT EMPLOYEE-DESIGNATION
    public function edit_employee_designation($id)
    {
        $employee_designation=DB::table('e2_employee_designations')
                           ->where('id',$id)
                           ->first();
        $manage_employee_designation=view('admin.hr_payroll.employee_designation.edit_employee_designation')
                         ->with('employee_designation',$employee_designation);
        return view('admin.master')
                         ->with('admin.hr_payroll.employee_designation.edit_employee_designation',$manage_employee_designation);
    }
    //UPDATE EMPLOYEE-DESIGNATION
    public function update_employee_designation(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('e2_employee_designations')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Employee Designation has been updated Successfully');
        return Redirect::to('/hr_payroll/employee_designation/employee_designations');
    }
    //DELETE EMPLOYEE-DESIGNATION FROM DATABASE
    public function delete_employee_designation($id)
    {
        try {
          DB::table('e2_employee_designations')
                ->where('id',$id)
                ->delete();
          Session::put('message', 'Employee Designation has been deleted Successfully');
          return Redirect::to('/hr_payroll/employee_designation/employee_designations');
        } catch (Exception $e) {
          return back()->withError('This Employee Designation cannot be deleted because other Employee/Employees depend on it. To delete this Employee Designation, delete dependent Employee/Employees first, only then you can delete it.');
        }
    }


    //------- METHODS FOR SALARY-GRADE --------//
    //SALARY-GRADE
    public function salary_grade(){
        $salary_grade_info=DB::table('e3_salary_grades')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_salary_grades=view('admin.hr_payroll.salary_grade.salary_grades')
                         ->with('salary_grade_info',$salary_grade_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.salary_grade.salary_grades',$manage_salary_grades);
    }
    //ADD-SALARY-GRADE
    public function add_salary_grade(){
        return view('admin.hr_payroll.salary_grade.add_salary_grade');
    }
    //SAVE SALARY-GRADE TO DATABASE
    public function save_salary_grade(Request $request)
    {
        $this->validate($request, [
          'name'                        => ['required', 'string', 'max:100','unique:e3_salary_grades'],
          'type'                        => ['required', 'integer'],
          'provident_fund'              => ['required', 'integer', 'min:0'],
          'basic_salary'                => ['required', 'integer', 'min:0'],
          'transportation_allowance'    => ['required', 'integer', 'min:0'],
          'dinning_allowance'           => ['required', 'integer', 'min:0'],
          'other_allowance'             => ['required', 'integer', 'min:0'],
          'home_rent'                   => ['required', 'integer', 'min:0'],
          'gross_salary'                => ['required', 'integer', 'min:0'],
          'note'                        => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['type'] = $request->type;
        $data['provident_fund'] = $request->provident_fund;
        $data['basic_salary'] = $request->basic_salary;
        $data['transportation_allowance'] = $request->transportation_allowance;
        $data['dinning_allowance'] = $request->dinning_allowance;
        $data['other_allowance'] = $request->other_allowance;
        $data['home_rent'] = $request->home_rent;
        $data['gross_salary'] = $request->gross_salary;
        $data['note'] = $request->note;
        $data['created_at'] = now();

        DB::table('e3_salary_grades')->insert($data);
        Session::put('message','Salary Grade is Added Successfully');
        return Redirect::to('/hr_payroll/salary_grade/add_salary_grade');
    }
    //EDIT SALARY-GRADE
    public function edit_salary_grade($id)
    {
        $salary_grade=DB::table('e3_salary_grades')
                           ->where('id',$id)
                           ->first();
        $manage_salary_grade=view('admin.hr_payroll.salary_grade.edit_salary_grade')
                         ->with('salary_grade',$salary_grade);
        return view('admin.master')
                         ->with('admin.hr_payroll.salary_grade.edit_salary_grade',$manage_salary_grade);
    }
    //UPDATE SALARY-GRADE
    public function update_salary_grade(Request $request, $id)
    {
        $this->validate($request, [
          'name'                        => ['required', 'string', 'max:100'],
          'type'                        => ['required', 'integer'],
          'provident_fund'              => ['required', 'integer', 'min:0'],
          'basic_salary'                => ['required', 'integer', 'min:0'],
          'transportation_allowance'    => ['required', 'integer', 'min:0'],
          'dinning_allowance'           => ['required', 'integer', 'min:0'],
          'other_allowance'             => ['required', 'integer', 'min:0'],
          'home_rent'                   => ['required', 'integer', 'min:0'],
          'gross_salary'                => ['required', 'integer', 'min:0'],
          'note'                        => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['type'] = $request->type;
        $data['provident_fund'] = $request->provident_fund;
        $data['basic_salary'] = $request->basic_salary;
        $data['transportation_allowance'] = $request->transportation_allowance;
        $data['dinning_allowance'] = $request->dinning_allowance;
        $data['other_allowance'] = $request->other_allowance;
        $data['home_rent'] = $request->home_rent;
        $data['gross_salary'] = $request->gross_salary;
        $data['note'] = $request->note;
        $data['created_at'] = now();

        DB::table('e3_salary_grades')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Salary Grade has been updated Successfully');
        return Redirect::to('/hr_payroll/salary_grade/salary_grades');
    }
    //DELETE SALARY-GRADE FROM DATABASE
    public function delete_salary_grade($id)
    {
        try {
          DB::table('e3_salary_grades')
                ->where('id',$id)
                ->delete();
          Session::put('message', 'Salary Grade has been deleted Successfully');
          return Redirect::to('/hr_payroll/salary_grade/salary_grades');
        } catch (Exception $e) {
          return back()->withError('This Salary Grade cannot be deleted because other Employee/Employees depend on it. To delete this Salary Grade, delete dependent Employee/Employees first, only then you can delete it.');
        }
    }


//------- METHODS FOR LEAVE --------//
    //LEAVE
    public function leave(){
        $leave_info=DB::table('e6_leaves')
                           ->orderBy('id', 'desc')
                           ->get();
        $leave_category_info=DB::table('e5_leave_categories')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_leaves=view('admin.hr_payroll.leave.leaves')
                         ->with('leave_info',$leave_info)
                         ->with('leave_category_info',$leave_category_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.leave.leaves',$manage_leaves);
    }
    //ADD-LEAVE
    public function add_leave(){
        $leave_category_info=DB::table('e5_leave_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        return view('admin.hr_payroll.leave.add_leave')
                            ->with('leave_category_info',$leave_category_info);;
    }
    //SAVE LEAVE TO DATABASE
    public function save_leave(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:e6_leaves'],
          'start_date'  => ['required', 'date'],
          'end_date'  => ['required', 'date'],
          'leave_category_id'  => ['required', 'integer','min:0'],
          'description'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        // $rs->${$item.'_data'}
        $data['duration'] = $request->start_date.'-'.$request->end_date;
        $data['leave_category_id'] = $request->leave_category_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('e6_leaves')->insert($data);
        Session::put('message','Leave is Added Successfully');
        return Redirect::to('/hr_payroll/leave/add_leave');
    }
    //EDIT LEAVE
    public function edit_leave($id)
    {
        $leave=DB::table('e6_leaves')
                           ->where('id',$id)
                           ->first();
        $leave_category_info=DB::table('e5_leave_categories')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_leave=view('admin.hr_payroll.leave.edit_leave')
                         ->with('leave',$leave)
                         ->with('leave_category_info',$leave_category_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.leave.edit_leave',$manage_leave);
    }
    //UPDATE LEAVE
    public function update_leave(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'duration'  => ['required', 'string'],
          'leave_category_id'  => ['required', 'integer','min:0'],
          'description'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['duration'] = $request->duration;
        $data['leave_category_id'] = $request->leave_category_id;
        $data['description'] = $request->description;
        $data['created_at'] = now();

        DB::table('e6_leaves')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Leave has been updated Successfully');
        return Redirect::to('/hr_payroll/leave/leaves');
    }
    //DELETE LEAVE FROM DATABASE
    public function delete_leave($id)
    {
        DB::table('e6_leaves')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Leave has been deleted Successfully');
        return Redirect::to('/hr_payroll/leave/leaves');
    }


    //------- METHODS FOR LEAVE-CATEGORY --------//
    //LEAVE-CATEGORY
    public function leave_category(){
        $leave_category_info=DB::table('e5_leave_categories')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_leave_category=view('admin.hr_payroll.leave.leave_categories')
                         ->with('leave_category_info',$leave_category_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.leave.leave_categories',$manage_leave_category);
    }
    //ADD-LEAVE-CATEGORY
    public function add_leave_category(){
        return view('admin.hr_payroll.leave.add_leave_category');
    }
    //SAVE LEAVE-CATEGORY TO DATABASE
    public function save_leave_category(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100','unique:e5_leave_categories'],
          'details'  => ['max:255']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['details'] = $request->details;
        $data['created_at'] = now();

        DB::table('e5_leave_categories')->insert($data);
        Session::put('message','Leave Category is Added Successfully');
        return Redirect::to('/hr_payroll/leave/add_leave_category');
    }
    //EDIT LEAVE-CATEGORY
    public function edit_leave_category($id)
    {
        $leave_category=DB::table('e5_leave_categories')
                           ->where('id',$id)
                           ->first();
        $manage_leave_category=view('admin.hr_payroll.leave.edit_leave_category')
                         ->with('leave_category',$leave_category);
        return view('admin.master')
                         ->with('admin.hr_payroll.leave.edit_leave_category',$manage_leave_category);
    }
    //UPDATE LEAVE-CATEGORY
    public function update_leave_category(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100'],
          'details'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['details'] = $request->details;

        DB::table('e5_leave_categories')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Leave Category has been updated Successfully');
        return Redirect::to('/hr_payroll/leave/leave_categories');
    }
    //DELETE LEAVE-CATEGORY FROM DATABASE
    public function delete_leave_category($id)
    {
        DB::table('e5_leave_categories')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Leave Category has been deleted Successfully');
        return Redirect::to('/hr_payroll/leave/leave_categories');
    }


    //------- METHODS FOR EMPLOYEE --------//
    //EMPLOYEE
    public function employee(){
        $employees_info=DB::table('e4_employees')
                           ->orderBy('id', 'desc')
                           ->get();
        $department_info=DB::table('e1_departments')
                           ->orderBy('id', 'desc')
                           ->get();
        $employee_designation_info=DB::table('e2_employee_designations')
                           ->orderBy('id', 'desc')
                           ->get();
        $salary_grade_info=DB::table('e3_salary_grades')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_employees=view('admin.hr_payroll.employee.employees')
                         ->with('employees_info',$employees_info)
                         ->with('department_info',$department_info)
                         ->with('employee_designation_info',$employee_designation_info)
                         ->with('salary_grade_info',$salary_grade_info);
        return view('admin.master')
                         ->with('admin.hr_payroll.employee.employees',$manage_employees);
    }
    //ADD EMPLOYEE
    public function add_employee(){

        $department_info=DB::table('e1_departments')
                           ->orderBy('id', 'desc')
                           ->get();
        $employee_designation_info=DB::table('e2_employee_designations')
                           ->orderBy('id', 'desc')
                           ->get();
        $salary_grade_info=DB::table('e3_salary_grades')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_employee = view('admin.hr_payroll.employee.add_employee')
                            ->with('department_info',$department_info)
                            ->with('employee_designation_info',$employee_designation_info)
                            ->with('salary_grade_info',$salary_grade_info);

        return view('admin.master')
                        ->with('admin.hr_payroll.employee.add_employee',$manage_employee);
    }
    //SAVE EMPLOYEE TO DATABASE
    public function save_employee(Request $request)
    {
//        $this->validate($request, [
//          'name'  => ['required', 'string', 'max:50', 'unique:employees'],
//          'date_of_birth' => ['required','date'],
//          'phone' => ['required','string', 'max:15', 'unique:employees'],
//          'address' => ['required','string', 'max:100'],
//          'blood_group' => ['required','string', 'max:15'],
//          'department_id' => ['required','integer'],
//          'designation_id' => ['required','integer'],
//          'salary_grade_id' => ['required','integer'],
//          'emergency_contact' => ['required','string', 'max:15'],
//          'other'  => ['max:255']
//        ]);
        $input = $request->all();
        Employee::create($input);
        Session::put('message','Employee is Added Successfully');
        return Redirect::to('/hr_payroll/employee/add_employee');
    }
    //EDIT EMPLOYEE
    public function edit_employee($id)
    {
        $employee=DB::table('e4_employees')
                           ->where('id',$id)
                           ->first();
        $department_info=DB::table('e1_departments')
                           ->orderBy('id', 'desc')
                           ->get();
        $employee_designation_info=DB::table('e2_employee_designations')
                           ->orderBy('id', 'desc')
                           ->get();
        $salary_grade_info=DB::table('e3_salary_grades')
                           ->orderBy('id', 'desc')
                           ->get();

        $manage_employee=view('admin.hr_payroll.employee.edit_employee')
                         ->with('employee',$employee)
                         ->with('department_info',$department_info)
                         ->with('employee_designation_info',$employee_designation_info)
                         ->with('salary_grade_info',$salary_grade_info);

        return view('admin.master')
                         ->with('admin.hr_payroll.employee.edit_employee',$manage_employee);
    }
    //UPDATE EMPLOYEE
    public function update_employee(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:50'],
          'date_of_birth' => ['required','date'],
          'phone' => ['required','string', 'max:15'],
          'address' => ['required','string', 'max:100'],
          'blood_group' => ['required','string', 'max:15'],
          'department_id' => ['required','integer'],
          'designation_id' => ['required','integer'],
          'salary_grade_id' => ['required','integer'],
          'emergency_contact' => ['required','string', 'max:15'],
          'other'  => ['max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['date_of_birth'] = $request->date_of_birth;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['blood_group'] = $request->blood_group;
        $data['department_id'] = $request->department_id;
        $data['designation_id'] = $request->designation_id;
        $data['salary_grade_id'] = $request->salary_grade_id;
        $data['emergency_contact'] = $request->emergency_contact;
        $data['other'] = $request->other;
        $data['created_at'] = now();

        DB::table('e4_employees')
             ->where('id',$id)
             ->update($data);
        Session::put('message','Employee has been updated Successfully');
        return Redirect::to('/hr_payroll/employee/employees');
    }
    //DELETE EMPLOYEE FROM DATABASE
    public function delete_employee($id)
    {
        DB::table('e4_employees')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'Employee has been deleted Successfully');
        return Redirect::to('/hr_payroll/employee/employees');
    }
}
