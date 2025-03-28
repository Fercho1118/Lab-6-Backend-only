<?php
//Acá se incluye la clase MatchController que contiene toda la lógica de manejo de partidos
require_once '../src/MatchController.php';

//Se habilitan los CORS para permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

//Se maneja las solicitudes preflight (OPTIONS) necesarias para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

//Se obtiene la URI solicitada
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Se obtiene el método HTTP.
$method = $_SERVER['REQUEST_METHOD'];

//Esta es la instancia del controlador que manejará las peticiones
$controller = new MatchController();

//Rutas principales para /api/matches

//Se obtienen todos los partidos
if ($uri === '/api/matches' && $method === 'GET') {
    $controller->getAllMatches();

//Se crea un partido
} elseif ($uri === '/api/matches' && $method === 'POST') {
    $controller->createMatch();

//Rutas para /api/matches/{id}

} elseif (preg_match('#^/api/matches/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];

    //Se obtiene un partido específico según su id
    if ($method === 'GET') {
        $controller->getMatch($id);

     //Se actualiza un partido en específico según el id 
    } elseif ($method === 'PUT') {
        $controller->updateMatch($id);

    //Se elimina un partido en específico según el id
    } elseif ($method === 'DELETE') {
        $controller->deleteMatch($id);

    //Mensaje para método no permitido
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }

//Rutas para acciones especiales PATCH
} elseif (preg_match('#^/api/matches/(\d+)/(goals|yellowcards|redcards|extratime)$#', $uri, $matches)) {
    $id = $matches[1];
    $action = $matches[2];

    if ($method === 'PATCH') {
        //Ruta según el tipo de acción PATCH
        switch ($action) {

            //Si es un gol se incrementa en la base de datos según su id
            case 'goals':
                $controller->incrementGoals($id);
                break;
            
            //Si es una tarjeta amarilla se incrementa en la base de datos según su id
            case 'yellowcards':
                $controller->incrementYellowCards($id);
                break;
            
            //Si es una tarjeta roja se incrementa en la base de datos según su id
            case 'redcards':
                $controller->incrementRedCards($id);
                break;

            //Si se añade tiempo extra se incrementa en la base de datos según su id
            case 'extratime':
                $controller->setExtraTime($id);
                break;
        }
        
    //Mensaje para método no permitido
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }

//Ruta no encontrada
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
