<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::get('stocks/excel/', 'ExcelController@stocks')->name('assets.excel');

// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/login')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    Route::delete('doctor/destroy', 'DoctorController@massDestroy')->name('doctor.massDestroy');
    Route::resource('doctor', 'DoctorController');

    // Assets
    Route::delete('assets/destroy', 'AssetsController@massDestroy')->name('assets.massDestroy');
    Route::resource('assets', 'AssetsController');
    Route::get('assets/{id}/history', 'AssetsController@history')->name('assets.history');
    // Asset Category
    Route::resource('category', 'AssetCategoryController');
    Route::resource('category/subcategory', 'SubCategoryController');
    Route::resource('category/subsubcategory', 'SubSubCategoryController');


    Route::delete('unit/destroy', 'UnitController@massDestroy')->name('unit.massDestroy');
    Route::resource('unit', 'UnitController');

    // Teams
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');
    Route::delete('chair/destroy', 'ChairController@massDestroy')->name('chair.massDestroy');
    Route::resource('chair', 'ChairController');

    // Stocks
    //Route::delete('stocks/destroy', 'StocksController@massDestroy')->name('stocks.massDestroy');
    Route::resource('stocks', 'StocksController')->only(['index', 'show']);
    Route::get('stock/in', 'StocksController@instock')->name('stock.in');
    Route::get('stock/out', 'StocksController@outstock')->name('stock.out');
    Route::get('stock/between', 'StocksController@betweenstock')->name('stock.between');

    // Importer
    Route::delete('importer/destroy', 'ImporterController@massDestroy')->name('importer.massDestroy');
    Route::resource('importer', 'ImporterController');

    // Transactions
//    Route::delete('transactions/destroy', 'TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::post('transactions/{stock}/storeStock', 'TransactionsController@storeStock')->name('transactions.storeStock');
    Route::resource('transactions', 'TransactionsController')->only(['index']);

    Route::post('stock/transaction/{id}/add', 'StockTransaction@add')->name('stock.transaction.add');
    Route::post('stock/transaction/{id}/remove', 'StockTransaction@remove')->name('stock.transaction.remove');
    Route::post('stock/transaction/{id}/between', 'StockTransaction@between')->name('stock.transaction.between');
    Route::post('stock/transaction/{id}/discard', 'StockTransaction@discard')->name('stock.transaction.discard');

    // Search
    Route::post('stock/search', 'StocksController@stockSearch')->name('stock.search');
    Route::post('stock/in/search', 'StocksController@instockSearch')->name('stock.in.search');
    Route::post('stock/out/search', 'StocksController@outstockSearch')->name('stock.out.search');
    Route::post('stock/between/search', 'StocksController@betweenstockSearch')->name('stock.between.search');
    Route::post('importer/search', 'ImporterController@importerSearch')->name('importer.search');
    Route::post('transaction/search', 'TransactionsController@transactionSearch')->name('transaction.search');
    Route::post('asset/search', 'AssetsController@assetSearch')->name('asset.search');


});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }

});
