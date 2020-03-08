<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $table ='e4_employees';
    protected $fillable = [ 'department_id', 'type_id', 'name', 'date_of_birth', 'phone', 'address',
        'blood_group', 'designation_id', 'salary_grade_id', 'emergency_contact', 'other', ];



}
