# Lab 6: Backend only

<br />

<div align="center">
  <h1>La Liga Tracker</h1>
  <p><i>Conectando frontend y backend con PHP, SQLite y Docker</i></p>
</div>

---

## Objetivos

- **Aplicar conceptos de desarrollo backend.**
- **Conectar un frontend existente con un API REST.**
- **Practicar el uso de Docker para despliegue de aplicaciones.**
- **Diseñar y documentar una API RESTful.**
- **Implementar y consumir operaciones avanzadas como PATCH.**

---

## Descripción del Proyecto

Este laboratorio consistió en desarrollar un backend completo para una aplicación llamada **La Liga Tracker**, la cual permite **gestionar partidos de fútbol** de La Liga.

El objetivo principal fue crear una API RESTful que pueda ser consumida por un frontend ya existente (`LaLigaTracker.html`), realizando operaciones como:

- Obtener partidos
- Crear partidos
- Actualizar partidos
- Eliminar partidos

El backend fue construido en **PHP** y ejecutado dentro de un contenedor **Docker** que expone el servicio en el puerto **8080**. Los datos se almacenan en una base de datos **SQLite**.

---

## Endpoints Implementados

| Método | Endpoint                           | Descripción                              |
|--------|------------------------------------|------------------------------------------|
| GET    | `/api/matches`                     | Obtener todos los partidos               |
| GET    | `/api/matches/:id`                 | Obtener partido por ID                   |
| POST   | `/api/matches`                     | Crear un nuevo partido                   |
| PUT    | `/api/matches/:id`                 | Actualizar completamente un partido      |
| DELETE | `/api/matches/:id`                 | Eliminar un partido                      |
| PATCH  | `/api/matches/:id/goals`           | Registrar un gol                         |
| PATCH  | `/api/matches/:id/yellowcards`     | Registrar una tarjeta amarilla          |
| PATCH  | `/api/matches/:id/redcards`        | Registrar una tarjeta roja              |
| PATCH  | `/api/matches/:id/extratime`       | Establecer el tiempo extra              |

---

## Base de Datos (SQLite)

La base de datos utilizada es **SQLite**, almacenada localmente en el archivo `data/database.sqlite`. La estructura se define en el archivo `init.sql` y contiene la tabla `matches`.

### Requisitos

- Tener **SQLite** instalado en tu computadora
  - Se puede instalar desde: https://www.sqlite.org/download.html
 
### Crear la base de datos

1. Asegurarse de tener la carpeta `data/`
2. Ejecutar el siguiente comando desde la raíz del proyecto: sqlite3 data/database.sqlite < init.sql

## Docker

El backend corre en un contenedor Docker usando la imagen oficial de PHP 8.2 CLI. El `Dockerfile` permite iniciar el servidor PHP embebido en el puerto 8080
El contenedor se levante mediante los siguientes comandos:
- docker build -t laliga-tracker .
- docker run -d -p 8080:8080 laliga-tracker



## Estructura del Proyecto
Lab-6-Backend-only/
├── data/
│   └── database.sqlite
├── public/
│   └── index.php
├── src/
│   └── MatchController.php
├── init.sql
├── Dockerfile
├── swagger.yaml
├── README.md

## Anexos
- Screenshot de la parte 1:
![image](https://github.com/user-attachments/assets/0873b3a4-9adc-4b5e-b2f5-6c4ed845b61f)

---

## Contacto

- **Estudiante:** Fernando Rueda  
- **Carnet:** 23748  
- **Email:** rue3748@uvg.edu.gt

---

## Créditos

- Basado en [Best-README-Template](https://github.com/othneildrew/Best-README-Template).

