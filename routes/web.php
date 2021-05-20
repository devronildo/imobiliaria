<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */
    Route::get('/', 'WebController@home')->name('home');

    /** Página Destaque */
    Route::get('/destaque', 'WebController@spotlight')->name('spotlight');

    /** Página de Locação */
    Route::get('/quero-alugar', 'WebController@rent')->name('rent');

    /** Página de Locaçãp - Específica de um imóvel */
    Route::get('/quero-alugar/{slug}', 'WebController@rentProperty')->name('rentProperty');

    /** Página de Compra */
    Route::get('/quero-comprar', 'WebController@buy')->name('buy');

    /** Página de Compra - Específica de um imóvel */
    Route::get('/quero-comprar/{slug}', 'WebController@buyProperty')->name('buyProperty');

    /** Página Inicial */
    Route::match(['post', 'get'], '/filtro', 'WebController@filter')->name('filter');

    /** Página de Experiências */
    Route::get('/experiencias', 'WebController@experience')->name('experience');

    /** Página de Experiências - Específica de uma categoria */
    Route::get('/experiencias/{slug}', 'WebController@experienceCategory')->name('experienceCategory');

    /** Página Inicial */
    Route::get('/contato', 'WebController@contact')->name('contact');
    Route::post('/contato/sendEmail', 'WebController@sendEmail')->name('sendEmail');
    Route::get('/contato/sucesso', 'WebController@sendEmailSuccess')->name('sendEmailSuccess');
});

Route::group(['prefix' => 'component', 'namespace' => 'Web', 'as' => 'component.'], function () {

    Route::post('main-filter/search', 'FilterController@search')->name('main-filter.search');
    Route::post('main-filter/category', 'FilterController@category')->name('main-filter.category');
    Route::post('main-filter/type', 'FilterController@type')->name('main-filter.type');
    Route::post('main-filter/neighborhood', 'FilterController@neighborhood')->name('main-filter.neighborhood');
    Route::post('main-filter/bedrooms', 'FilterController@bedrooms')->name('main-filter.bedrooms');
    Route::post('main-filter/suites', 'FilterController@suites')->name('main-filter.suites');
    Route::post('main-filter/bathrooms', 'FilterController@bathrooms')->name('main-filter.bathrooms');
    Route::post('main-filter/garage', 'FilterController@garage')->name('main-filter.garage');
    Route::post('main-filter/price-base', 'FilterController@priceBase')->name('main-filter.priceBase');
    Route::post('main-filter/price-limit', 'FilterController@priceLimit')->name('main-filter.priceLimit');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /** Formulário de Login */
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Rotas Protegidas */
    Route::group(['middleware' => ['auth']], function () {

        /** Dashboard Home */
        Route::get('home', 'AuthController@home')->name('home');

        /** Usuários */
        Route::get('users/team', 'UserController@team')->name('users.team');
        Route::resource('users', 'UserController');

        /** Empresas */
        Route::resource('companies', 'CompanyController');

        /** Imóveis */
        Route::post('properties/image-set-cover', 'PropertyController@imageSetCover')->name('properties.imageSetCover');
        Route::delete('properties/image-remove', 'PropertyController@imageRemove')->name('properties.imageRemove');
        Route::resource('properties', 'PropertyController');

        /** Contratos */
        Route::post('contracts/get-data-owner', 'ContractController@getDataOwner')->name('contracts.getDataOwner');
        Route::post('contracts/get-data-acquirer',
            'ContractController@getDataAcquirer')->name('contracts.getDataAcquirer');
        Route::post('contracts/get-data-property',
            'ContractController@getDataProperty')->name('contracts.getDataProperty');
        Route::resource('contracts', 'ContractController');
    });

    /** Logout */
    Route::get('logout', 'AuthController@logout')->name('logout');

});