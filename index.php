<?php

// autoloader for Composer
require 'vendor/autoload.php';

// instanciate Slim
$app = new Slim\App();

// basic authentication
$app->add(new \Slim\Middleware\HttpBasicAuthentication(array(
    // everything inside this root path uses the authentication
    "path" => "/api",
    // deactivate HTTPS usage (for simplicity)
    "secure" => false,
    // users (name and password), credentials will be passed via request header, see the client.html for more info
    "users" => [
        "testuser" => "Pa55W0rd123",
    ],
    "error" => function ($request, $response, $arguments) {
        // return the 401 "unauthorized" status code when auth error occurs
        return $response->withStatus(401);
    }
)));

// grouping the /api route, see Slim's group() method documentation for more
$app->group('/api', function () use ($app) {

    $data = ['And again', 9876543210];

    // api route "test" which just gives back some demo data
    $app->get('/test', function ($request, $response, $args) use ($data) {
        return $response->withJson([
            'Text' => $data[0], 
            'Numbers' => $data[1] 
        ]);
    });
});

$app->run();
