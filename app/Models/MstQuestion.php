<?php

namespace App\Models;

use App\Base\BaseModel;
use App\Models\QuestionGroup;
use App\Models\ReviewProfile;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class MstQuestion extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mst_questions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function reviewProfileEntity()
    {
        return $this->belongsTo(ReviewProfile::class,'review_profile_id','id');
    }
    public function groupEntity()
    {
        return $this->belongsTo(QuestionGroup::class,'group_id','id');
    }

    public function subQuestions()
    {
        return $this->hasMany(MstSubQuestion::class,'question_id','id');
    }
    public function questionOptions()
    {
        return $this->hasMany(MstQuestionOption::class,'question_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
