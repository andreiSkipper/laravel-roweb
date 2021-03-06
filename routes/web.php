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

Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // products
    Route::get('/products', ['as' => 'products', 'uses' => 'ProductsController@index']);
    Route::get('/products-delete/{id}', ['as' => 'products-delete', 'uses' => 'ProductsController@delete']);
    Route::match(['post', 'get'], '/products-edit/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@update']);

    // carts
    Route::get('/carts', ['as' => 'carts', 'uses' => 'CartsController@index']);
    Route::get('/carts-delete/{id}', ['as' => 'carts-delete', 'uses' => 'CartsController@delete']);
    Route::match(['post', 'get'], '/carts-edit/{id}', ['as' => 'carts-edit', 'uses' => 'CartsController@update']);
    Route::post('/carts-add', ['as' => 'carts-add', 'uses' => 'CartsController@create']);
});

// Generate a login URL
Route::get('/facebook/login', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    // Send an array of permissions to request
    $login_url = $fb->getLoginUrl(Config::get('constants.facebook_permissions'));

    // Obviously you'd do this in blade :)
    echo '<a href="' . $login_url . '">Login with Facebook</a>';
});

// Endpoint that is redirected to after an authentication attempt
Route::get('/facebook/callback', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (!$token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        if (!$helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }

    if (!$token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    $fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string)$token);

    // Get basic info on the user from Facebook.
    try {
        $response = $fb->get('/me?fields=id,name,email');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    $facebook_user = $response->getGraphUser();

    $user = \App\Http\Models\User::createFacebookUser($facebook_user);

    // Log the user into Laravel
    Auth::login($user);

    return redirect('/')->with('message', 'Successfully logged in with Facebook');
});

Route::any('{query}', function () {
    return redirect('/');
})->where('query', '.*');
