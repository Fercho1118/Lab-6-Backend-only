<?php

/**
 * Clase: MatchController
 * Descripción: Controlador que gestiona las operaciones CRUD y actualizaciones parciales para partidos de fútbol de La Liga utilizando una base de datos SQLite.
 */
class MatchController {
    /** @var PDO $db Conexión a la base de datos SQLite */
    private $db;

    /**
     * Constructor: establece la conexión PDO a la base de datos SQLite.
     */
    public function __construct() {
        $this->db = new PDO('sqlite:' . __DIR__ . '/../data/database.sqlite');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Obtiene todos los partidos de la base de datos.
     * Devuelve un arreglo JSON con todos los registros.
     */
    public function getAllMatches() {
        $stmt = $this->db->query("SELECT * FROM matches");
        $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($matches);
    }

    /**
     * Obtiene un partido específico por ID.
     * @param int $id ID del partido a buscar
     */
    public function getMatch($id) {
        $stmt = $this->db->prepare("SELECT * FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($match) {
            echo json_encode($match);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Partido no encontrado']);
        }
    }

    /**
     * Crea un nuevo partido utilizando datos enviados por POST en formato JSON.
     * Devuelve un mensaje y los datos del nuevo partido.
     */
    public function createMatch() {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->db->prepare("INSERT INTO matches (homeTeam, awayTeam, matchDate) VALUES (?, ?, ?)");
        $stmt->execute([$data['homeTeam'], $data['awayTeam'], $data['matchDate']]);
        $newId = $this->db->lastInsertId();
        echo json_encode([
            'message' => 'Partido creado',
            'match' => [
                'id' => $newId,
                'homeTeam' => $data['homeTeam'],
                'awayTeam' => $data['awayTeam'],
                'matchDate' => $data['matchDate']
            ]
        ]);
    }

    /**
     * Actualiza un partido existente completamente usando PUT.
     * @param int $id ID del partido a actualizar
     */
    public function updateMatch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->db->prepare("UPDATE matches SET homeTeam = ?, awayTeam = ?, matchDate = ? WHERE id = ?");
        $stmt->execute([$data['homeTeam'], $data['awayTeam'], $data['matchDate'], $id]);
        echo json_encode(['message' => 'Partido actualizado']);
    }

    /**
     * Elimina un partido por su ID.
     * @param int $id ID del partido a eliminar
     */
    public function deleteMatch($id) {
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Partido eliminado']);
    }

    /**
     * Aumenta en 1 la cantidad de goles del partido.
     * @param int $id ID del partido
     */
    public function incrementGoals($id) {
        $stmt = $this->db->prepare("UPDATE matches SET goals = goals + 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Gol registrado']);
    }
    
    /**
     * Aumenta en 1 la cantidad de tarjetas amarillas del partido.
     * @param int $id ID del partido
     */    
    public function incrementYellowCards($id) {
        $stmt = $this->db->prepare("UPDATE matches SET yellowCards = yellowCards + 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Tarjeta amarilla registrada']);
    }

    /**
     * Aumenta en 1 la cantidad de tarjetas rojas del partido.
     * @param int $id ID del partido
     */    
    public function incrementRedCards($id) {
        $stmt = $this->db->prepare("UPDATE matches SET redCards = redCards + 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Tarjeta roja registrada']);
    }
    
     /**
     * Establece el tiempo extra del partido.
     * @param int $id ID del partido
     */   
    public function setExtraTime($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->db->prepare("UPDATE matches SET extraTime = ? WHERE id = ?");
        $stmt->execute([$data['extraTime'], $id]);
        echo json_encode(['message' => 'Tiempo extra actualizado']);
    }
    
}
