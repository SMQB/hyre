<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API Routes
$router->group(['prefix' => 'api'], function () use ($router){

    // User Registration and Authentication
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    // Protected Routes
    $router->group(['middleware' => ''], function () use ($router) {

        // User Profile
        $router->get('/user', 'AuthController@user');
        $router->post('/logout', 'AuthController@logout');

        // CRUD for Client Profiles
        $router->get('clients', 'ProfileController@index');
        $router->get('clients/{id}', 'ProfileController@index');
        $router->post('clients', 'ProfileController@store');
        $router->put('clients/{id}', 'ProfileController@update');
        $router->delete('clients/{id}', 'ProfileController@destroy');

        // CRUD for Coaching Sessions
        $router->get('sessions', 'CoachingSessionController@index');
        $router->get('sessions/{id}', 'CoachingSessionController@show');
        $router->post('sessions', 'CoachingSessionController@store');
        $router->put('sessions/{id}', 'CoachingSessionController@update');
        $router->delete('sessions/{id}', 'CoachingSessionController@destroy');
        
        // Analytics for Coaches
        $router->get('/analytics/total-sessions', 'AnalyticsController@totalSessions');
        $router->get('/analytics/client-progress', 'AnalyticsController@clientProgress');

        // Client Session Logic
        $router->get('/sessions/uncompleted', 'CoachingSessionController@uncompleted');
        $router->post('/sessions/{session}/complete', 'CoachingSessionController@complete');
    });
    
    $router->post('prompts', 'PromptController@create');
    $router->get('prompts', 'PromptController@index');
    //$router->post('evaluate', 'EvaluationController@evaluate');
    
});