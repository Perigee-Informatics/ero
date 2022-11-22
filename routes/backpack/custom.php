<?php
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web','XSS', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    // primary master routes
    Route::crud('mstfedprovince', 'MstFedProvinceCrudController');
    Route::crud('mstfeddistrict', 'MstFedDistrictCrudController');
    Route::crud('mstfedlocallevel', 'MstFedLocalLevelCrudController');
    Route::crud('mstfedlocalleveltype', 'MstFedLocalLevelTypeCrudController');
    Route::crud('mstnepalimonth', 'MstNepaliMonthCrudController');
    Route::crud('mstgender', 'MstGenderCrudController');

    Route::get('dashboard', 'DashboardCrudController@index')->name('dashboard');
    
    Route::crud('mstschool', 'MstSchoolCrudController');
    Route::crud('reviewprofile', 'ReviewProfileCrudController');
    Route::crud('questiongroup', 'QuestionGroupCrudController');
    Route::crud('workassigneemaster', 'WorkAssigneeMasterCrudController');
    Route::crud('mstquestion', 'MstQuestionCrudController');
}); // this should be the absolute last line of this file