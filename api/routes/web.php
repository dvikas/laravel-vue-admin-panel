<?php

Route::get('/', 'ApiDocsController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/invoice/{uuid}/{userUuid}', 'HomeController@invoice')->name('invoice');
Route::get('/api-settings', 'HomeController@apiSettings')->name('apiSettings');
Route::post('/login/auth/google', 'Api\Auth\SocialAuthController@index')->middleware('guest');
//Route::get('/login/auth/google/callback', 'Api\LoginController@test')->middleware('guest');

Route::get('/pdf', function(){
    $pdf = PDF::loadView('invoice');
    return $pdf->download('invoice'.uniqid().'.pdf');
});

Route::get('/proposal/{supplierProjectTaskUuid}/{supplierUuid}', 'Api\Projects\ProposalController@show');
Route::post('/proposal/{supplierProjectTaskUuid}/{supplierUuid}', 'Api\Projects\ProposalController@store');


//Route::get( '/login/{social}', 'AuthenticationController@getSocialRedirect' )
//    ->middleware('guest');
//Route::get( '/login/{social}/callback', 'AuthenticationController@getSocialCallback' )
//    ->middleware('guest');