<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'students';
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'id',
        'name',
        'name_kana',
        'sex',
        'birthday',
        'age',
        'country',
        'first_interv_date',
        'first_interv_staff',
        'first_interv_result',
        'sec_interv_date',
        'sec_interv_staff',
        'sec_interv_result',
        'intern_interv_date',
        'intern_department',
        'intern_result',
        'hire_date',
        'phone',
        'email',
        'skill_jlpt',
        'skill_hearing',
        'skill_speaking',
        'skill_reading',
        'skill_se',
        'graduate_4',
        'graduate_2',
        'graduate_school',
        'apply_department',
        'working_place',
        'current_status', 
        'note',
        'folder_name',
    ];
}
