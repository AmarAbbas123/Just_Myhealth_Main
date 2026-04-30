<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserType30OnboardQuestions extends Model
{
    use HasFactory;

    protected $table = 'sys_user_type_30_onboard_questions';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'QuestionStatus',
        'TherapyType',
        'QuestionHeading',
        'QuestionDisplayType',
        'SelectEntryType',
        'QuestionNotes',
        'Option1',
        'Option2',
        'Option3',
        'Option4',
        'Option5',
        'Option6',
        'Option7',
        'Option8',
        'Option9',
        'Option10',
        'Option11',
        'Option12',
    ];
}
