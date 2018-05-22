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
//官网路由
Route::get('/', 'WebsiteController@getIndex');
Route::get('index', 'WebsiteController@getIndex');
Route::get('advert', 'WebsiteController@getAdvert');
Route::get('web', 'WebsiteController@getWeb');
Route::get('news/dt', 'WebsiteController@getNewsDt');
Route::get('news/zx', 'WebsiteController@getNewsZx');
Route::get('new/{id}', 'WebsiteController@getNew');
Route::get('help', 'WebsiteController@getHelp');
Route::get('protocol', 'WebsiteController@getProtocol');


Route::get('admin/login', 'WebsiteController@getLoginAdmin');
Route::get('login/{type}', 'WebsiteController@getLogin');
Route::get('register/{type}', 'WebsiteController@getRegister');

// 站长后台路由
Route::group(['prefix' => 'webmaster', 'namespace' => 'Webmaster'], function (){
    //登陆注册
    Route::post('login.json', 'AuthController@postLogin');
    Route::post('register.json', 'AuthController@postRegister');
    Route::put('logout.json', 'AuthController@putLogout');

    Route::get('data.json', 'DataController@getData');

    Route::get('websites.json', 'WebsiteController@getWebsites');
    Route::get('website/{id}.json', 'WebsiteController@getWebsite');
    Route::put('website/{id}.json', 'WebsiteController@putWebsite');
    Route::post('website.json', 'WebsiteController@postWebsite');

    Route::get('ads.json', 'AdsController@getAds');
    Route::get('myads.json', 'AdsController@getMyads');
    Route::get('myad/{id}.json', 'AdsController@getMyad');
    Route::put('myad/{id}.json', 'AdsController@putMyad');
    Route::post('myad.json', 'AdsController@postMyad');

    Route::get('earnings/{type}.json', 'MoneyController@getEarnings');
    Route::get('rewards.json', 'MoneyController@getRewards');
    Route::get('moneys.json', 'MoneyController@getMoneys');

    Route::get('user.json', 'UserController@getUser');
    Route::get('bank.json', 'UserController@getBank');
    Route::put('user.json', 'UserController@putUser');
    Route::put('bank.json', 'UserController@putBank');
    Route::put('passwd.json', 'UserController@putPasswd');

    Route::get('messages.json', 'MessageController@getMessages');
    Route::get('message/{id}.json', 'MessageController@getMessage')->where('id', '[0-9]+');

    //页面
    Route::any('/', 'HomeController@index');
    Route::any('{all}', 'HomeController@index')->where('all', '.*');
});


// 广告主后台路由
Route::group(['prefix' => 'advertiser', 'namespace' => 'Advertiser'], function (){

    Route::post('login.json', 'AuthController@postLogin');
    Route::post('register.json', 'AuthController@postRegister');
    Route::put('logout.json', 'AuthController@putLogout');

    Route::get('data.json', 'DataController@getData');

    //类型
    Route::get('adspositions', 'AdspositionApiController@getAdspositions');

    //素材包
    Route::get('packages.json', 'PackageController@getPackages');
    Route::get('package/{id}.json', 'PackageController@getPackage');
    Route::put('package/{id}.json', 'PackageController@putPackage');
    Route::put('package/item/{id}.json', 'PackageController@putPackageItem');
    Route::post('package', 'PackageController@postPackage');

    //媒体中心
    Route::get('matters.json', 'MatterController@getMatters');
    Route::post('matter.json', 'MatterController@postMatter');

    //广告
    Route::get('ads.json', 'AdsController@getAds');
    Route::get('ad/{id}.json', 'AdsController@getAd');
    Route::post('ad.json', 'AdsController@postAd');
    Route::put('ad/{id}.json', 'AdsController@putAd');

    Route::get('expends/{tyep}.json', 'ExpendController@getExpends');
    Route::get('recharges.json', 'RechargeController@getRecharges');
    Route::get('recharge/{id}.json', 'RechargeController@getRecharge');
    Route::put('recharge/{id}.json', 'RechargeController@putRecharge');
    Route::post('recharge.json', 'RechargeController@postRecharge');

    Route::get('loginlogs.json', 'UserController@getLoginlogs');
    Route::get('user.json', 'UserController@getUser');
    Route::put('user.json', 'UserController@putUser');
    Route::put('passwd.json', 'UserController@putPasswd');

    Route::get('messages.json', 'MessageController@getMessages');
    Route::get('message/{id}.json', 'MessageController@getMessage')->where('id', '[0-9]+');;

    //页面
    Route::any('/', 'HomeController@index');
    Route::any('{all}', 'HomeController@index')->where('all', '.*');
});

//总后台数据
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){

    Route::post('login.json', 'AuthController@postLogin');
    Route::put('logout', 'AuthController@putLogout');

    Route::get('home/webmaster/earning/hour.json', 'IndexController@getWebmasterEarningHour');

    //站长管理
    Route::get('webmasters.json', 'WebmasterController@getWebmasters');
    Route::get('webmaster/{id}.json', 'WebmasterController@getWebmaster')->where('id', '[0-9]+');
    Route::put('webmaster/{id}.json', 'WebmasterController@putWebmaster')->where('id', '[0-9]+');
    Route::get('webmaster/loginlogs.json', 'WebmasterController@getWebmasterLoginlogs');

    Route::get('banks.json', 'WebmasterBankController@getBanks');
    Route::get('webmaster/bank/{id}.json', 'WebmasterBankController@getWebmasterBank')->where('id', '[0-9]+');
    Route::put('webmaster/bank/{id}.json', 'WebmasterBankController@putWebmasterBank')->where('id', '[0-9]+');

    Route::get('webmaster/notes/{id}.json', 'WebmasterNoteController@getWebmasterNotes')->where('id', '[0-9]+');
    Route::post('webmaster/note/{id}.json', 'WebmasterNoteController@postWebmasterNote')->where('id', '[0-9]+');

    Route::get('webmaster/ads.json', 'WebmasterAdsController@getWebmasterAds');
    Route::get('webmaster/ad/{id}.json', 'WebmasterAdsController@getWebmasterAd')->where('id', '[0-9]+');
    Route::put('webmaster/ad/{id}.json', 'WebmasterAdsController@putWebmasterAd')->where('id', '[0-9]+');

    Route::get('webmaster/websites.json', 'WebmasterWebsiteController@getWebmasterWebsites');
    Route::get('webmaster/website/{id}.json', 'WebmasterWebsiteController@getWebmasterWebsite')->where('id', '[0-9]+');
    Route::put('webmaster/website/{id}.json', 'WebmasterWebsiteController@putWebmasterWebsite')->where('id', '[0-9]+');

    Route::get('webmaster/earning/day/{webmaster_ad_id}.json', 'WebmasterEarningController@getEarningDay')->where('webmaster_ad_id', '[0-9]+');
    Route::get('webmaster/earning/hour/{webmaster_ad_id}.json', 'WebmasterEarningController@getEarningHour')->where('webmaster_ad_id', '[0-9]+');
    Route::get('webmaster/earning/hour/chart/{webmaster_ad_id}.json', 'WebmasterEarningController@getEarningHourChart')->where('webmaster_ad_id', '[0-9]+');
    Route::get('webmaster/earning/click/{webmaster_ad_id}.json', 'WebmasterEarningController@getEarningClick')->where('webmaster_ad_id', '[0-9]+');

    Route::get('webmaster/category/{id}.json', 'WebmasterCategoryController@getWebmasterCategory')->where('id', '[0-9]+');
    Route::put('webmaster/category/{id}.json', 'WebmasterCategoryController@putWebmasterCategory')->where('id', '[0-9]+');
    Route::post('webmaster/category.json', 'WebmasterCategoryController@postWebmasterCategory');

    Route::get('webmaster/categorys.json', 'WebmasterCategoryController@getWebmasterCategorys');
    Route::get('webmaster/category/{id}.json', 'WebmasterCategoryController@getWebmasterCategory')->where('id', '[0-9]+');
    Route::put('webmaster/category/{id}.json', 'WebmasterCategoryController@putWebmasterCategory')->where('id', '[0-9]+');
    Route::post('webmaster/category.json', 'WebmasterCategoryController@postWebmasterCategory');
    

    Route::get('webmaster/moneys.json', 'WebmasterMoneyController@getWebmasterMoneys');
    
    //联盟广告
    Route::get('alliances.json', 'AllianceController@getAlliances');
    Route::get('alliance/{id}.json', 'AllianceController@getAlliance')->where('id', '[0-9]+');
    Route::put('alliance/{id}.json', 'AllianceController@putAlliance')->where('id', '[0-9]+');
    Route::post('alliance.json', 'AllianceController@postAlliance');
    Route::get('alliance/spendings.json', 'AllianceController@getSpendings');

    //广告管理
    Route::get('advertisers.json', 'AdvertiserController@getAdvertisers');
    Route::get('advertiser/{id}.json', 'AdvertiserController@getAdvertiser')->where('id', '[0-9]+');
    Route::put('advertiser/{id}.json', 'AdvertiserController@putAdvertiser')->where('id', '[0-9]+');
    Route::get('advertiser/loginlogs.json', 'AdvertiserController@getLoginlogs');

    Route::get('advertiser/ads.json', 'AdvertiserAdController@getAdvertiserads');
    Route::get('advertiser/ad/{id}.json', 'AdvertiserAdController@getAdvertiserad')->where('id', '[0-9]+');
    Route::put('advertiser/ad/{id}.json', 'AdvertiserAdController@putAdvertiserad')->where('id', '[0-9]+');
    Route::post('advertiser/ad.json', 'AdvertiserAdController@postAdvertiserad');

    Route::get('advertiser/matters.json', 'MatterController@getMatters');
    Route::post('advertiser/matter.json', 'MatterController@postMatter');

    Route::get('advertiser/expends.json', 'AdvertiserExpendController@getExpends');

    Route::get('advertiser/packages.json', 'AdvertiserPackageController@getPackages');
    Route::get('advertiser/package/{id}.json', 'AdvertiserPackageController@getPackage')->where('id', '[0-9]+');
    Route::put('advertiser/package/{id}.json', 'AdvertiserPackageController@putPackage')->where('id', '[0-9]+');
    Route::post('advertiser/package.json', 'AdvertiserPackageController@postPackage');

    //联盟流量
    Route::get('alliance/fluxs.json', 'AllianceFluxController@getAllianceFluxs');
    Route::get('alliance/flux/{id}.json', 'AllianceFluxController@getAllianceFlux')->where('id', '[0-9]+');
    Route::put('alliance/flux/{id}.json', 'AllianceFluxController@putAllianceFlux')->where('id', '[0-9]+');
    Route::post('alliance/flux.json', 'AllianceFluxController@postAllianceFlux');
    Route::get('alliance/flux/expends/day.json', 'AllianceFluxExpendController@getExpendsDay');
    Route::get('alliance/flux/expends/hour.json', 'AllianceFluxExpendController@getExpendsHour');

    //财物管理
    Route::get('takemoneys.json', 'TakemoneyController@getTakemoneys');
    Route::get('takemoney/{id}.json', 'TakemoneyController@getTakemoney')->where('id', '[0-9]+');
    Route::put('takemoney/{id}.json', 'TakemoneyController@putTakemoney')->where('id', '[0-9]+');

    Route::get('rewards.json', 'RewardController@getRewards');
    Route::get('reward/{id}.json', 'RewardController@getReward')->where('id', '[0-9]+');
    Route::put('reward/{id}.json', 'RewardController@putReward')->where('id', '[0-9]+');
    Route::post('reward.json', 'RewardController@postReward');

    Route::get('recharges.json', 'RechargeController@getRecharges');
    Route::get('recharge/{id}.json', 'RechargeController@getRecharge')->where('id', '[0-9]+');
    Route::put('recharge/{id}.json', 'RechargeController@putRecharge')->where('id', '[0-9]+');

    Route::get('service/earnings.json', 'ServiceController@getEarnings');
    Route::get('busine/earnings.json', 'BusineController@getEarnings');

    //会员管理
    Route::get('users.json', 'UserController@getUsers');
    Route::get('user/{id}.json', 'UserController@getUser')->where('id', '[0-9]+');
    Route::put('user/{id}.json', 'UserController@putUser')->where('id', '[0-9]+');
    Route::post('user.json', 'UserController@postUser');

    Route::get('departments.json', 'DepartmentController@getDepartments');
    Route::get('department/{id}.json', 'DepartmentController@getDepartment')->where('id', '[0-9]+');
    Route::put('department/{id}.json', 'DepartmentController@putDepartment')->where('id', '[0-9]+');
    Route::post('department.json', 'DepartmentController@postDepartment');

    //系统设置
    Route::get('setting.json', 'SettingController@getSetting');
    Route::put('setting.json', 'SettingController@putSetting');

    //消息中心
    Route::get('messages.json', 'MessageController@getMessages');
    Route::get('message/{id}.json', 'MessageController@getMessage')->where('id', '[0-9]+');
    Route::put('message/{id}.json', 'MessageController@putMessage')->where('id', '[0-9]+');
    Route::post('message.json', 'MessageController@postMessage');


    Route::get('articles.json', 'ArticleController@getArticles');
    Route::get('article/{id}.json', 'ArticleController@getArticle')->where('id', '[0-9]+');
    Route::put('article/{id}.json', 'ArticleController@putArticle')->where('id', '[0-9]+');
    Route::post('article.json', 'ArticleController@postArticle')->where('id', '[0-9]+');

    Route::get('article/categorys.json', 'ArticleCategoryController@getCategorys');
    Route::get('article/category/{id}.json', 'ArticleCategoryController@getCategory')->where('id', '[0-9]+');
    Route::put('article/category/{id}.json', 'ArticleCategoryController@putCategory')->where('id', '[0-9]+');
    Route::post('article/category/{id}.json', 'ArticleCategoryController@postCategory')->where('id', '[0-9]+');

    //个人资料
    Route::get('user.json', 'UserController@getMyUser');
    Route::put('user.json', 'UserController@putMyUser');

    Route::get('/', 'HomeController@index');
    Route::any('{all}', 'HomeController@index')->where('all', '.*');

});