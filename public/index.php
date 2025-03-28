<?php
require_once '../src/MatchController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$controller = new MatchController();

if ($uri === '/api/matches' && $method === 'GET') {
    $controller->getAllMatches();
} elseif ($uri === '/api/matches' && $method === 'POST') {
    $controller->createMatch();
} elseif (preg_match('#^/api/matches/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];
    if ($method === 'GET') {
        $controller->getMatch($id);
    } elseif ($method === 'PUT') {
        $controller->updateMatch($id);
    } elseif ($method === 'DELETE') {
        $controller->deleteMatch($id);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} elseif (preg_match('#^/api/matches/(\d+)/(goals|yellowcards|redcards|extratime)$#', $uri, $matches)) {
    $id = $matches[1];
    $action = $matches[2];

    if ($method === 'PATCH') {
        switch ($action) {
            case 'goals':
                $controller->incrementGoals($id);
                break;
            case 'yellowcards':
                $controller->incrementYellowCards($id);
                break;
            case 'redcards':
                $controller->incrementRedCards($id);
                break;
            case 'extratime':
                $controller->setExtraTime($id);
                break;
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
