<?php

require 'vendor/autoload.php';
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();

// Middleware for security
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "secure" => true,
    "users" => [
        "admin" => "password"
    ]
]));

// Set content type and headers globally (like helmet)
$app->add(function (Request $request, Response $response, $next) {
    $response = $next($request, $response);
    $response = $response->withHeader('Content-Type', 'application/json')
                         ->withHeader('Access-Control-Allow-Origin', '*');
    return $response;
});

// Rate Limiting (you can use a middleware or custom logic)
$app->add(function (Request $request, Response $response, $next) {
    // Simple rate limiting logic (for example purpose)
    $ip = $request->getServerParams()['REMOTE_ADDR'];
    $limit = 100; // Max requests
    $timeWindow = 60 * 60; // 1 hour
    // In production, use Redis or database to track requests per IP
    // if request count > $limit, respond with error

    return $next($request, $response);
});

// Define Routes
$app->group('/api', function () use ($app) {
    // Article Routes
    $app->get('/articles', \ArticleController::class . ':getAllArticles');
    $app->post('/articles', \ArticleController::class . ':createArticle');

    // Auth Routes
    $app->post('/register', \AuthController::class . ':register');
    $app->post('/login', \AuthController::class . ':login');
});

// Global Error Handling
$app->addErrorMiddleware(true, true, true);

// Start the application
$app->run();
