<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){

    $api->group(['middleware' => ['throttle:60,1', 'bindings'], 'namespace' => 'App\Http\Controllers'], function($api) {

        $api->get('ping', 'Api\PingController@index');

        $api->group(['middleware' => ['auth:api'], ], function ($api) {

            $api->group(['prefix' => 'users'], function ($api) {
                $api->get('/', 'Api\Users\UsersController@index');
                $api->post('/', 'Api\Users\UsersController@store');

                $api->get('/draft-tasks', 'Api\Users\DraftTasksController@index');
                $api->get('/draft-tasks/{draftUuid}/{customerUuid}/{projectUuid}', 'Api\Users\DraftTasksController@show');
                $api->post('/draft-tasks', 'Api\Users\DraftTasksController@store');

                $api->get('/{uuid}', 'Api\Users\UsersController@show');
                $api->put('/{uuid}', 'Api\Users\UsersController@update');
                $api->patch('/{uuid}', 'Api\Users\UsersController@update');
                $api->delete('/{uuid}', 'Api\Users\UsersController@destroy');

            });

            $api->group(['prefix' => 'roles'], function ($api) {
                $api->get('/', 'Api\Users\RolesController@index');
                $api->post('/', 'Api\Users\RolesController@store');
                $api->get('/{uuid}', 'Api\Users\RolesController@show');
                $api->put('/{uuid}', 'Api\Users\RolesController@update');
                $api->patch('/{uuid}', 'Api\Users\RolesController@update');
                $api->delete('/{uuid}', 'Api\Users\RolesController@destroy');
            });

            $api->group(['prefix' => 'dashboard'], function ($api) {
                $api->get('/chart-data', 'Api\DashboardController@chartData');
                $api->get('/calendar', 'Api\DashboardController@calendar');
            });

            $api->get('permissions', 'Api\Users\PermissionsController@index');

            $api->group(['prefix' => 'me'], function($api) {
                $api->get('/', 'Api\Users\ProfileController@index');
                $api->put('/', 'Api\Users\ProfileController@update');
                $api->patch('/', 'Api\Users\ProfileController@update');
                $api->put('/password', 'Api\Users\ProfileController@updatePassword');
                $api->post('/profile/image', 'Api\Assets\ProfileImageController@store');
            });

            $api->group(['prefix' => 'assets'], function($api) {
                $api->post('/', 'Api\Assets\UploadFileController@store');
            });


            $api->group(['prefix' => 'projects/quotes'], function($api) {
                $api->post('/{uuid}', 'Api\Projects\ProjectQuoteController@store');
                $api->get('/{uuid}', 'Api\Projects\ProjectQuoteController@show');
            });

            $api->group(['prefix' => 'projects/tasks-profit'], function($api) {
                $api->post('/', 'Api\Projects\ProjectTaskProfitsController@store');
                $api->get('/{projectId}', 'Api\Projects\ProjectTaskProfitsController@show');
                $api->put('/{projectId}', 'Api\Projects\ProjectTaskProfitsController@update');
            });

            $api->group(['prefix' => 'projects'], function($api) {
                $api->get('/', 'Api\Projects\ProjectController@index');
                $api->put('/{uuid}', 'Api\Projects\ProjectController@update');
                $api->delete('/{uuid}', 'Api\Projects\ProjectController@destroy');
                $api->get('/invoice/{uuid}', 'Api\Projects\ProjectController@sendInvoice');
            });

            $api->group(['prefix' => 'customers'], function($api) {
                $api->post('/', 'Api\Projects\CustomersController@store');
                $api->get('/{id}', 'Api\Projects\CustomersController@show');
                $api->put('/', 'Api\Projects\CustomersController@update');

                $api->post('/tasks', 'Api\Projects\ProjectTasksController@store');
                $api->get('/tasks/{customerId}/{projectId}', 'Api\Projects\ProjectTasksController@show');
                $api->put('/tasks/update-sub-task-position', 'Api\Projects\ProjectTasksController@updateSubTaskPosition');
                $api->put('/tasks/update-milestone-position', 'Api\Projects\ProjectTasksController@updateMilestonePosition');
                $api->put('/tasks/update-customer-sub-task-element', 'Api\Projects\ProjectTasksController@updateSubTaskElement');
                $api->put('/tasks/update-customer-sub-task', 'Api\Projects\ProjectTasksController@updateSubTask');
                $api->put('/tasks/update-milestone-element', 'Api\Projects\ProjectTasksController@updateMilestoneElement');
                $api->delete('/tasks/delete-sub-task', 'Api\Projects\ProjectTasksController@deleteSubTask');
                $api->delete('/tasks/delete-parent-task', 'Api\Projects\ProjectTasksController@deleteParentTask');

                $api->post('/projects', 'Api\Projects\ProjectDetailsController@store');

                $api->post('/milestones', 'Api\Projects\MilestonesController@store');
            });

            $api->group(['prefix' => 'tasks'], function($api) {
                $api->get('/', 'Api\System\TasksController@index');
                $api->post('/', 'Api\System\TasksController@store');
                $api->get('/{uuid}', 'Api\System\TasksController@show');
                $api->get('/children/{uuid}', 'Api\System\TasksController@getChildren');
            });

            $api->group(['prefix' => 'suppliers/projects/tasks'], function($api) {
                $api->get('/{projectId}', 'Api\Projects\SupplierProjectTasksController@index');
                $api->post('/', 'Api\Projects\SupplierProjectTasksController@store');
                $api->get('/{uuid}', 'Api\Projects\SupplierProjectTasksController@show');
                $api->put('/{uuid}', 'Api\Projects\SupplierProjectTasksController@update');
                $api->patch('/{uuid}', 'Api\Projects\SupplierProjectTasksController@update');
                $api->delete('/{uuid}', 'Api\Projects\SupplierProjectTasksController@destroy');
            });

            $api->group(['prefix' => 'suppliers/tasks'], function($api) {
                $api->get('/', 'Api\System\SupplierUserTasksController@index');
                $api->post('/', 'Api\System\SupplierUserTasksController@store');
                $api->get('/{uuid}', 'Api\System\SupplierUserTasksController@show');
                $api->put('/{uuid}', 'Api\System\SupplierUserTasksController@update');
                $api->patch('/{uuid}', 'Api\System\SupplierUserTasksController@update');
                $api->delete('/{uuid}', 'Api\System\SupplierUserTasksController@destroy');
            });

            $api->group(['prefix' => 'supplier/quotes'], function($api) {
                $api->post('/', 'Api\Projects\SupplierQuoteDetailsController@store');
            });

            $api->group(['prefix' => 'suppliers'], function($api) {
                $api->get('/', 'Api\System\SuppliersController@index');
                $api->post('/', 'Api\System\SuppliersController@store');
                $api->get('/{uuid}', 'Api\System\SuppliersController@show');
                $api->put('/{uuid}', 'Api\System\SuppliersController@update');
                $api->patch('/{uuid}', 'Api\System\SuppliersController@update');
                $api->delete('/{uuid}', 'Api\System\SuppliersController@destroy');
            });


        });

    });

});



