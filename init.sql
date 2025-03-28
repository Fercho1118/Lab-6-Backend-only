--Se elimina la tabla "matches" si ya existe
DROP TABLE IF EXISTS matches;

--Se crea la tabla "matches" para almacenar datos de partidos de fútbol
CREATE TABLE matches (
  --ID autoincremental único para cada partido
  id INTEGER PRIMARY KEY AUTOINCREMENT,

  --Nombre del equipo local 
  homeTeam TEXT NOT NULL,

  --Nombre del equipo visitante 
  awayTeam TEXT NOT NULL,

  --Fecha del partido
  matchDate TEXT NOT NULL,

  --Goles registrados en el partido
  goals INTEGER DEFAULT 0,

  --Tarjetas amarillas registradas
  yellowCards INTEGER DEFAULT 0,

  -- Tarjetas rojas registradas
  redCards INTEGER DEFAULT 0,

  --Tiempo extra asignado al partido
  extraTime TEXT
);
