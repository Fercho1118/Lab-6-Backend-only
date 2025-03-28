<?php

class MatchController {
    private $db;

    public function __construct() {
        $this->db = new PDO('sqlite:' . __DIR__ . '/../data/database.sqlite');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllMatches() {
        $stmt = $this->db->query("SELECT * FROM matches");
        $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($matches);
    }

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

    public function updateMatch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->db->prepare("UPDATE matches SET homeTeam = ?, awayTeam = ?, matchDate = ? WHERE id = ?");
        $stmt->execute([$data['homeTeam'], $data['awayTeam'], $data['matchDate'], $id]);
        echo json_encode(['message' => 'Partido actualizado']);
    }

    public function deleteMatch($id) {
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Partido eliminado']);
    }

    public function incrementGoals($id) {
        $stmt = $this->db->prepare("UPDATE matches SET goals = goals + 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Gol registrado']);
    }
    
    public function incrementYellowCards($id) {
        $stmt = $this->db->prepare("UPDATE matches SET yellowCards = yellowCards + 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Tarjeta amarilla registrada']);
    }
    
    public function incrementRedCards($id) {
        $stmt = $this->db->prepare("UPDATE matches SET redCards = redCards + 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Tarjeta roja registrada']);
    }
    
    public function setExtraTime($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->db->prepare("UPDATE matches SET extraTime = ? WHERE id = ?");
        $stmt->execute([$data['extraTime'], $id]);
        echo json_encode(['message' => 'Tiempo extra actualizado']);
    }
    
}
