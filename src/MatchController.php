<?php

class MatchController {
    private $matches = [];

    public function __construct() {
        //partidos de ejemplo
        $this->matches = [
            1 => ['id' => 1, 'homeTeam' => 'Barcelona', 'awayTeam' => 'Osasuna', 'matchDate' => '2025-03-27'],
            2 => ['id' => 2, 'homeTeam' => 'Atlético', 'awayTeam' => 'Sevilla', 'matchDate' => '2025-04-11']
        ];
    }

    public function getAllMatches() {
        echo json_encode(array_values($this->matches));
    }

    public function getMatch($id) {
        if (isset($this->matches[$id])) {
            echo json_encode($this->matches[$id]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Partido no encontrado']);
        }
    }

    public function createMatch() {
        $data = json_decode(file_get_contents("php://input"), true);
        $newId = max(array_keys($this->matches)) + 1;
        $data['id'] = $newId;
        $this->matches[$newId] = $data;
        echo json_encode(['message' => 'Partido creado', 'match' => $data]);
    }

    public function updateMatch($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($this->matches[$id])) {
            $data['id'] = $id;
            $this->matches[$id] = $data;
            echo json_encode(['message' => 'Partido actualizado']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Partido no encontrado']);
        }
    }

    public function deleteMatch($id) {
        if (isset($this->matches[$id])) {
            unset($this->matches[$id]);
            echo json_encode(['message' => 'Partido eliminado']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Partido no encontrado']);
        }
    }
}
