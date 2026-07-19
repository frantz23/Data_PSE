<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\IndicatorvalueController;
use App\Http\Controllers\IndicatorvaluefileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Models\IndicatorValue;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $organizations = Organization::count();
    $projects = Project::count();
    return view('home', ['organizations'  => $organizations, 'projects' => $projects]);
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pannel', function () {
        return view('ownpage.pannel');
    })->name('ownpage.pannel');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Organization
    Route::get('/organization', [OrganizationController::class, 'indexOrganization'])->name('indexOrganization');
    Route::get('/organizations/show/{id}', [OrganizationController::class, 'showOrganization'])->name('showOrganization');
    Route::get('/organizations/create', [OrganizationController::class, 'createOrganization'])->name('createOrganization');
    Route::get('/organizations/edit/{id}', [OrganizationController::class, 'editOrganization'])->name('editOrganization');
    Route::post('/organizations/store', [OrganizationController::class, 'storeOrganization'])->name('storeOrganization');
    Route::put('/organizations/update/{organization}', [OrganizationController::class, 'updateOrganization'])->name('updateOrganization');
    Route::delete('/organizations/delete/{organization}', [OrganizationController::class, 'deleteOrganization'])->name('deleteOrganization');
    Route::get('/organization', [OrganizationController::class, 'indexOrganization'])->name('indexOrganization');
    Route::get('/organization/assignRole', [OrganizationController::class, 'assignView'])->name('assignView');
    Route::post('/roles/assign', [OrganizationController::class, 'assign'])->name('assignOrganizationRole');
    Route::get('/organization/{organization}/users', [OrganizationController::class, 'getUsers'])
        ->name('organization.users');

    //User
    Route::get('/users', [UserController::class, 'indexUser'])->name('indexUser');
    Route::get('/users/show/{id}', [UserController::class, 'showUser'])->name('showUser');
    Route::get('/users/create', [UserController::class, 'createUser'])->name('createUser');
    Route::get('/users/edit/{id}', [UserController::class, 'editUser'])->name('editUser');
    Route::post('/users/store', [UserController::class, 'storeUser'])->name('storeUser');
    Route::put('/users/update/{user}', [UserController::class, 'updateUser'])->name('updateUser');
    Route::delete('/users/delete/{user}', [UserController::class, 'deleteUser'])->name('deleteUser');
});

Route::middleware(['adminONG', 'auth'])->group(function () {
    //Programs
    Route::get('/programs', [ProgramController::class, 'indexProgram'])->name('indexProgram');
    Route::get('/programs/show/{id}',  [ProgramController::class, 'showProgram'])->name('showProgram');
    Route::get('/programs/create', [ProgramController::class, 'createProgram'])->name('createProgram');
    Route::get('/programs/edit/{id}', [ProgramController::class, 'editProgram'])->name('editProgram');
    Route::post('/programs/store', [ProgramController::class, 'storeProgram'])->name('storeProgram');
    Route::put('/programs/update/{program}', [ProgramController::class, 'updateProgram'])->name('updateProgram');

    //Projects
    Route::get('/projects', [ProjectController::class, 'indexProject'])->name('indexProject');
    Route::get('/projects/show/{id}', [ProjectController::class, 'showProject'])->name('showProject');
    Route::get('/projects/create', [ProjectController::class, 'createProject'])->name('createProject');
    Route::get('/projects/edit/{id}', [ProjectController::class, 'editProject'])->name('editProject');
    Route::post('/projects/store', [ProjectController::class, 'storeProject'])->name('storeProject');
    Route::put('/projects/update/{project}', [ProjectController::class, 'updateProject'])->name('updateProject');

    //Activities
    Route::get('/activities', [ActivityController::class, 'indexActivity'])->name('indexActivity');
    Route::get('/activities/show/{id}', [ActivityController::class, 'showActivity'])->name('showActivity');
    Route::get('/activities/create', [ActivityController::class, 'createActivity'])->name('createActivity');
    Route::get('/activities/edit/{id}', [ActivityController::class, 'editActivity'])->name('editActivity');
    Route::post('/activities/store', [ActivityController::class, 'storeActivity'])->name('storeActivity');
    Route::put('/activities/update/{activity}', [ActivityController::class, 'updateActivity'])->name('updateActivity');
    Route::get('/activities/{activity}/indicators/create', [ActivityController::class, 'assignedIndicator'])->name('assignedIndicator');
    Route::post('/activities/{activity}/indicators/attach', [ActivityController::class, 'attachIndicator'])
    ->name('attachIndicator');

    //Indicator
    Route::get('/indicators', [IndicatorController::class, 'indexIndicator'])->name('indexIndicator');
    Route::get('/indicators/show/{id}', [IndicatorController::class, 'showIndicator'])->name('showIndicator');
    Route::get('/indicators/create', [IndicatorController::class, 'createIndicator'])->name('createIndicator');
    Route::get('/indicators/edit/{id}', [IndicatorController::class, 'editIndicator'])->name('editIndicator');
    Route::post('/indicators/store', [IndicatorController::class, 'storeIndicator'])->name('storeIndicator');
    Route::put('/indicators/update/{indicator}', [IndicatorController::class, 'updateIndicator'])->name('updateIndicator');

    //IndicatorValue
    Route::get('/indicatorvalues/create/{id}', [IndicatorvalueController::class, 'createIndicatorValue'])->name('createIndicatorValue');
    Route::get('/indicatorvalues/show/{id}', [IndicatorvalueController::class, 'showIndicatorValue'])->name('showIndicatorValue');
    Route::get('/indicatorvalues/edit/{id}', [IndicatorvalueController::class, 'editIndicatorValue'])->name('editIndicatorValue');
    Route::post('/indicatorvalues/store', [IndicatorvalueController::class, 'storeIndicatorValue'])->name('storeIndicatorValue');
    Route::put('/indicatorvalues/update/{indicatorvalue}', [IndicatorvalueController::class, 'updateIndicatorValue'])->name('updateIndicatorValue');

    //IVF
    Route::get('/indicatorvaluefiles/{indicatorValue}/create/file', [IndicatorvaluefileController::class, 'createIVFile'])->name('createIVFile');
    Route::post('/indicatorvaluefiles/store', [IndicatorvaluefileController::class, 'storeIVFile'])->name('storeIVFile');

});

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {

    //Get Organizations datas
    Route::get('/organizations', 'App\Http\Controllers\OrganizationController@index')->name('organization.index');

    //Show Organization by Id
    Route::get('/organizations/show/{id}', 'App\Http\Controllers\OrganizationController@show')->name('organization.show');

    //Get Organizations by Id
    Route::get('/organizations/create', 'App\Http\Controllers\OrganizationController@create')->name('organization.create');

    //Edit Organization by Id
    Route::get('/organizations/edit/{id}', 'App\Http\Controllers\OrganizationController@edit')->name('organization.edit');

    //Save new Organization
    Route::post('/organizations/store', 'App\Http\Controllers\OrganizationController@store')->name('organization.store');

    //Update One Organization
    Route::put('/organizations/update/{organization}', 'App\Http\Controllers\OrganizationController@update')->name('organization.update');

    //Update One Organization Speedly
    Route::put('/organizations/speed/{organization}', 'App\Http\Controllers\OrganizationController@updateSpeed')->name('organization.update.speed');

    //Delete Organization
    Route::delete('/organizations/delete/{organization}', 'App\Http\Controllers\OrganizationController@delete')->name('organization.delete');
});
Route::prefix('admin')->name('admin.')->group(function () {

    //Get Users datas
    Route::get('/users', 'App\Http\Controllers\UserController@index')->name('user.index');

    //Show User by Id
    Route::get('/users/show/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');

    //Get Users by Id
    Route::get('/users/create', 'App\Http\Controllers\UserController@create')->name('user.create');

    //Edit User by Id
    Route::get('/users/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('user.edit');

    //Save new User
    Route::post('/users/store', 'App\Http\Controllers\UserController@store')->name('user.store');

    //Update One User
    Route::put('/users/update/{user}', 'App\Http\Controllers\UserController@update')->name('user.update');

    //Update One User Speedly
    Route::put('/users/speed/{user}', 'App\Http\Controllers\UserController@updateSpeed')->name('user.update.speed');

    //Delete User
    Route::delete('/users/delete/{user}', 'App\Http\Controllers\UserController@delete')->name('user.delete');
});

Route::prefix('admin')->name('admin.')->group(function () {

    //Get Programs datas
    Route::get('/programs', 'App\Http\Controllers\ProgramController@index')->name('program.index');

    //Show Program by Id
    Route::get('/programs/show/{id}', 'App\Http\Controllers\ProgramController@show')->name('program.show');

    //Get Programs by Id
    Route::get('/programs/create', 'App\Http\Controllers\ProgramController@create')->name('program.create');

    //Edit Program by Id
    Route::get('/programs/edit/{id}', 'App\Http\Controllers\ProgramController@edit')->name('program.edit');

    //Save new Program
    Route::post('/programs/store', 'App\Http\Controllers\ProgramController@store')->name('program.store');

    //Update One Program
    Route::put('/programs/update/{program}', 'App\Http\Controllers\ProgramController@update')->name('program.update');

    //Update One Program Speedly
    Route::put('/programs/speed/{program}', 'App\Http\Controllers\ProgramController@updateSpeed')->name('program.update.speed');

    //Delete Program
    Route::delete('/programs/delete/{program}', 'App\Http\Controllers\ProgramController@delete')->name('program.delete');
});

Route::prefix('admin')->name('admin.')->group(function () {

    //Get Projects datas
    Route::get('/projects', 'App\Http\Controllers\ProjectController@index')->name('project.index');

    //Show Project by Id
    Route::get('/projects/show/{id}', 'App\Http\Controllers\ProjectController@show')->name('project.show');

    //Get Projects by Id
    Route::get('/projects/create', 'App\Http\Controllers\ProjectController@create')->name('project.create');

    //Edit Project by Id
    Route::get('/projects/edit/{id}', 'App\Http\Controllers\ProjectController@edit')->name('project.edit');

    //Save new Project
    Route::post('/projects/store', 'App\Http\Controllers\ProjectController@store')->name('project.store');

    //Update One Project
    Route::put('/projects/update/{project}', 'App\Http\Controllers\ProjectController@update')->name('project.update');

    //Update One Project Speedly
    Route::put('/projects/speed/{project}', 'App\Http\Controllers\ProjectController@updateSpeed')->name('project.update.speed');

    //Delete Project
    Route::delete('/projects/delete/{project}', 'App\Http\Controllers\ProjectController@delete')->name('project.delete');
});
Route::prefix('admin')->name('admin.')->group(function () {

    //Get Activities datas
    Route::get('/activities', 'App\Http\Controllers\ActivityController@index')->name('activity.index');

    //Show Activity by Id
    Route::get('/activities/show/{id}', 'App\Http\Controllers\ActivityController@show')->name('activity.show');

    //Get Activities by Id
    Route::get('/activities/create', 'App\Http\Controllers\ActivityController@create')->name('activity.create');

    //Edit Activity by Id
    Route::get('/activities/edit/{id}', 'App\Http\Controllers\ActivityController@edit')->name('activity.edit');

    //Save new Activity
    Route::post('/activities/store', 'App\Http\Controllers\ActivityController@store')->name('activity.store');

    //Update One Activity
    Route::put('/activities/update/{activity}', 'App\Http\Controllers\ActivityController@update')->name('activity.update');

    //Update One Activity Speedly
    Route::put('/activities/speed/{activity}', 'App\Http\Controllers\ActivityController@updateSpeed')->name('activity.update.speed');

    //Delete Activity
    Route::delete('/activities/delete/{activity}', 'App\Http\Controllers\ActivityController@delete')->name('activity.delete');
});

Route::prefix('admin')->name('admin.')->group(function(){

    //Get Indicators datas
    Route::get('/indicators', 'App\Http\Controllers\IndicatorController@index')->name('indicator.index');

    //Show Indicator by Id
    Route::get('/indicators/show/{id}', 'App\Http\Controllers\IndicatorController@show')->name('indicator.show');

    //Get Indicators by Id
    Route::get('/indicators/create', 'App\Http\Controllers\IndicatorController@create')->name('indicator.create');

    //Edit Indicator by Id
    Route::get('/indicators/edit/{id}', 'App\Http\Controllers\IndicatorController@edit')->name('indicator.edit');

    //Save new Indicator
    Route::post('/indicators/store', 'App\Http\Controllers\IndicatorController@store')->name('indicator.store');

    //Update One Indicator
    Route::put('/indicators/update/{indicator}', 'App\Http\Controllers\IndicatorController@update')->name('indicator.update');

    //Update One Indicator Speedly
    Route::put('/indicators/speed/{indicator}', 'App\Http\Controllers\IndicatorController@updateSpeed')->name('indicator.update.speed');

    //Delete Indicator
    Route::delete('/indicators/delete/{indicator}', 'App\Http\Controllers\IndicatorController@delete')->name('indicator.delete');

});

Route::prefix('admin')->name('admin.')->group(function(){

    //Get Indicatorvalues datas
    Route::get('/indicatorvalues', 'App\Http\Controllers\IndicatorvalueController@index')->name('indicatorvalue.index');

    //Show Indicatorvalue by Id
    Route::get('/indicatorvalues/show/{id}', 'App\Http\Controllers\IndicatorvalueController@show')->name('indicatorvalue.show');

    //Get Indicatorvalues by Id
    Route::get('/indicatorvalues/create', 'App\Http\Controllers\IndicatorvalueController@create')->name('indicatorvalue.create');

    //Edit Indicatorvalue by Id
    Route::get('/indicatorvalues/edit/{id}', 'App\Http\Controllers\IndicatorvalueController@edit')->name('indicatorvalue.edit');

    //Save new Indicatorvalue
    Route::post('/indicatorvalues/store', 'App\Http\Controllers\IndicatorvalueController@store')->name('indicatorvalue.store');

    //Update One Indicatorvalue
    Route::put('/indicatorvalues/update/{indicatorvalue}', 'App\Http\Controllers\IndicatorvalueController@update')->name('indicatorvalue.update');

    //Update One Indicatorvalue Speedly
    Route::put('/indicatorvalues/speed/{indicatorvalue}', 'App\Http\Controllers\IndicatorvalueController@updateSpeed')->name('indicatorvalue.update.speed');

    //Delete Indicatorvalue
    Route::delete('/indicatorvalues/delete/{indicatorvalue}', 'App\Http\Controllers\IndicatorvalueController@delete')->name('indicatorvalue.delete');

});

Route::prefix('admin')->name('admin.')->group(function(){

    //Get Indicatorvaluefiles datas
    Route::get('/indicatorvaluefiles', 'App\Http\Controllers\IndicatorvaluefileController@index')->name('indicatorvaluefile.index');

    //Show Indicatorvaluefile by Id
    Route::get('/indicatorvaluefiles/show/{id}', 'App\Http\Controllers\IndicatorvaluefileController@show')->name('indicatorvaluefile.show');

    //Get Indicatorvaluefiles by Id
    Route::get('/indicatorvaluefiles/create', 'App\Http\Controllers\IndicatorvaluefileController@create')->name('indicatorvaluefile.create');

    //Edit Indicatorvaluefile by Id
    Route::get('/indicatorvaluefiles/edit/{id}', 'App\Http\Controllers\IndicatorvaluefileController@edit')->name('indicatorvaluefile.edit');

    //Save new Indicatorvaluefile
    Route::post('/indicatorvaluefiles/store', 'App\Http\Controllers\IndicatorvaluefileController@store')->name('indicatorvaluefile.store');

    //Update One Indicatorvaluefile
    Route::put('/indicatorvaluefiles/update/{indicatorvaluefile}', 'App\Http\Controllers\IndicatorvaluefileController@update')->name('indicatorvaluefile.update');

    //Update One Indicatorvaluefile Speedly
    Route::put('/indicatorvaluefiles/speed/{indicatorvaluefile}', 'App\Http\Controllers\IndicatorvaluefileController@updateSpeed')->name('indicatorvaluefile.update.speed');

    //Delete Indicatorvaluefile
    Route::delete('/indicatorvaluefiles/delete/{indicatorvaluefile}', 'App\Http\Controllers\IndicatorvaluefileController@delete')->name('indicatorvaluefile.delete');

});
