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

Route::get('LOGtfAAJckFnhCQR', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/test', 'Front\Home@test');
Route::get('/page404', 'Front\Home@page404');
Route::get('/site_under_maintenance', 'Front\Home@maintenance');
Route::get('/IPblock', 'Front\Home@ipblock');

Route::group(['prefix' => '', 'middleware' => ['web', 'maintenance', 'checkip']], function () {
    Route::get('/', 'Front\Home@index');
    Route::post('/unlock', 'Front\Home@unlock');
    Route::post('/saveNetwork', 'Front\Home@saveNetwork');
    Route::get('/roadmap', 'Front\Home@roadmap');
    Route::get('/logout', 'Front\Home@logout');
    Route::get('/convPrice/{id}', 'Front\Home@convPrice');

    //Liquidity
    Route::get('/liquidity', 'Front\Dex@index');
    Route::post('/addPair', 'Front\Dex@addPair');
    Route::post('/getPair', 'Front\Dex@getPair');
    Route::get('/addLiquidity', 'Front\Dex@addLiquidity');
    //Swap
    Route::post('/getCurrency', 'Front\Dex@getCurrency');
    Route::get('/swap', 'Front\Dex@swap');
    Route::get('/swap_history', 'Front\Dex@swap_history');
    //Stake
    Route::get('/staking', 'Front\Dex@staking');
    Route::get('/stake_history', 'Front\Dex@stake_history');
    //Presale
    Route::get('/presale', 'Front\Dex@presale');
    Route::group(['middleware' => ['user_session']], function () {
        Route::post('/createTransaction', 'Front\Dex@createTransaction');
        Route::get('/removeLiquidity/{id}', 'Front\Dex@removeLiquidity');
        //History
        Route::get('/transactionHistory/{id}', 'Front\Dex@transaction_history');
    });
});


/******************* Admin Controller routes ***********************/
$admin_redirect = ADMINURL;
Route::get($admin_redirect.'/addwhitelistIp', 'Admin\Basic@addwhitelistIp');
Route::group(['prefix' => $admin_redirect, 'middleware' => ['web', 'checkip', 'whitelist']], function () {
    //Admin panel
    Route::get('/', 'Admin\Basic@index');
    Route::get('/walletDetails/{id}', 'Admin\Basic@index1');
    Route::post('/adminLogin', 'Admin\Basic@adminLogin');
    Route::get('/adminLogin', 'Admin\Basic@index');
    Route::get('tfaVerification/{id}', 'Admin\Basic@tfaVerification');
    Route::post('tfaLogin', 'Admin\Basic@tfaLogin');
    Route::get('/logout', 'Admin\Basic@logout');
    //Forgot Password
    Route::post('/forgotPassword', 'Admin\Basic@forgotPassword');
    Route::post('/forgotPattern', 'Admin\Basic@forgotPattern');
    Route::post('/checkResetEmail', 'Admin\Basic@checkResetEmail');
    Route::get('/resetPassword/{id}/{token}', 'Admin\Basic@resetPassword');
    Route::get('/resetPattern/{id}/{token}', 'Admin\Basic@resetPattern');
    Route::post('/updatePassword', 'Admin\Basic@updatePassword');
    Route::post('/updatePattern', 'Admin\Basic@updatePattern');

    Route::group(['middleware' => ['admin_session', 'active_admin']], function () {
        //Profile actions
        Route::get('/profile', 'Admin\Basic@viewProfile');
        Route::post('/updateProfile', 'Admin\Basic@updateProfile');
        Route::post('/enableDisableTFa', 'Admin\Basic@enableDisableTFa');
        Route::get('/checkPassword', 'Admin\Basic@checkPassword');
        Route::post('/changePassword', 'Admin\Basic@changePassword');
        //Site settings actions
        Route::get('/settings', 'Admin\Basic@adminSettings');
        Route::post('/updateSite', 'Admin\Basic@updateSite');
        //Decrease notification count
        Route::get('/decreaseNotifyCount', 'Admin\Basic@decreaseNotifyCount');
        //Dashboard view actions
        Route::get('/viewnewuser', 'Admin\Users@viewnewuser');
        //User actions
        Route::get('/viewuser', 'Admin\Users@userList');
        Route::get('/userHistory/{id}', 'Admin\Users@userHistory');
        //Subadmin Actions
        Route::post('/checkUsernameExists', 'Admin\Basic@checkUsernameExists');
        Route::post('/checkEmailExists', 'Admin\Basic@checkEmailExists');
        Route::get('/loginHistory', 'Admin\Basic@loginHistory');
        Route::get('/viewSubadmin', 'Admin\Basic@viewSubadmin');
        Route::get('/subadminStatus/{id}', 'Admin\Basic@subadminStatus');
        Route::get('/addSubadmin', 'Admin\Basic@addSubadmin');
        Route::post('/updateSubadmin', 'Admin\Basic@updateSubadmin');
        Route::get('/updateSubadmin', 'Admin\Basic@index');
        Route::get('/subadminEdit/{id}', 'Admin\Basic@subadminEdit');
        Route::get('/deleteSubadmin/{id}', 'Admin\Basic@deleteSubadmin');
        //IP block actions
        Route::get('/viewBlockIp', 'Admin\Basic@viewBlockIp');
        Route::get('/blockHistory', 'Admin\Basic@blockHistory');
        Route::get('/ipAddrStatus/{id}', 'Admin\Basic@ipAddrStatus');
        Route::get('/ipAddrDelete/{id}', 'Admin\Basic@ipAddrDelete');
        Route::post('/addIpAddress', 'Admin\Basic@addIpAddress');
        //IP whitelist actions
        Route::get('/viewWhitelistIp', 'Admin\Basic@viewWhitelistIp');
        Route::get('/whitelistipAddrStatus/{id}', 'Admin\Basic@whitelistipAddrStatus');
        Route::get('/whitelistipAddrDelete/{id}', 'Admin\Basic@whitelistipAddrDelete');
        Route::post('/whitelistaddIpAddress', 'Admin\Basic@whitelistaddIpAddress');
        //FAQ actions
        Route::get('/viewfaq', 'Admin\Basic@viewFaq');
        Route::get('/faqStatus/{id}', 'Admin\Basic@faqStatus');
        Route::get('/faqEdit/{id}', 'Admin\Basic@faqEdit');
        Route::get('/addFaq', 'Admin\Basic@faqEdit');
        Route::post('/updateFaq', 'Admin\Basic@faqUpdate');
        Route::get('/faqDelete/{id}', 'Admin\Basic@faqDelete');
        //CMS actions
        Route::get('/cmsadd', 'Admin\Basic@cmsAdd');
        Route::post('/cmsadded', 'Admin\Basic@cmsadded');
        Route::get('/viewcms/{type}', 'Admin\Basic@viewCms');
        Route::get('/cmsStatus/{id}', 'Admin\Basic@cmsStatus');
        Route::get('/cmsEdit/{id}', 'Admin\Basic@cmsEdit');
        Route::post('/updateCms', 'Admin\Basic@cmsUpdate');
        //Email actions
        Route::get('/viewemail', 'Admin\Basic@viewEmail');
        Route::get('/emailEdit/{id}', 'Admin\Basic@emailEdit');
        Route::post('/updateEmail', 'Admin\Basic@emailUpdate');
        //Roadmap
        Route::get('/viewRoadmap', 'Admin\Basic@viewRoadmap');
        Route::get('/roadmapEdit/{id}', 'Admin\Basic@roadmapEdit');
        Route::post('/updateRoadmap', 'Admin\Basic@roadmapUpdate');
        //CSV
        Route::get('/csv/{id}', 'Admin\Basic@csv');

        Route::get('/connectWallet', 'Admin\Dex@connectWallet');
        Route::post('/unlockWallet', 'Admin\Dex@unlockWallet');
        Route::post('/saveAdminNetwork', 'Admin\Dex@saveAdminNetwork');
        Route::get('/disconnectWallet', 'Admin\Dex@disconnectWallet');        
        //Pairs
        Route::get('/viewPairs', 'Admin\Dex@viewPairs');
        Route::get('/pairHistory/{id}/{id1}', 'Admin\Dex@pairHistory');
        Route::get('/pairEdit/{id}', 'Admin\Dex@pairEdit');
        Route::get('/addPair', 'Admin\Dex@pairEdit');
        Route::post('/updatePair', 'Admin\Dex@updatePair');
        Route::post('/createPair', 'Admin\Dex@createPair');
        Route::post('/addStakingPair', 'Admin\Dex@addStakingPair');
        Route::get('/staking_history', 'Admin\Dex@staking_history');
        Route::get('/swap_history', 'Admin\Dex@swap_history');
        Route::get('/transactionHistory/{id}', 'Admin\Dex@transaction_history');
        Route::get('/presale', 'Admin\Dex@presale');
        Route::post('/setpresaleTime', 'Admin\Dex@setpresaleTime');
        Route::post('/setpresalePrice', 'Admin\Dex@setpresalePrice');
        Route::post('/setMinmax', 'Admin\Dex@setMinmax');
    });
});