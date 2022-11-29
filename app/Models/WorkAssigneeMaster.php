<?php

namespace App\Models;

use App\Models\User;
use App\Base\BaseModel;
use App\Models\ReviewProfile;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class WorkAssigneeMaster extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'work_assignee_master';
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

    public function assignedByEntity()
    {
        return $this->belongsTo(User::class,'assigned_by','id');
    }
    public function assignedToEntity()
    {
        return $this->belongsTo(User::class,'assigned_to','id');
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
