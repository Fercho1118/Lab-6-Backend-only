# Lab 6: Backend only

<br />

<div align="center">
  <h1>La Liga Tracker</h1>
  <p><i>Conectando frontend y backend con PHP y Docker</i></p>
</div>

---

## Objetivos

- **Aplicar conceptos de desarrollo backend.**
- **Conectar un frontend existente con un API REST.**
- **Practicar el uso de Docker para despliegue de aplicaciones.**

---

## Descripción del Proyecto

Este laboratorio consistió en desarrollar un backend completo para una aplicación llamada **La Liga Tracker**, la cual permite gestionar partidos de fútbol de La Liga.

El objetivo principal fue crear una API RESTful que pueda ser consumida por un frontend ya existente (`LaLigaTracker.html`), realizando operaciones como:

- Obtener partidos
- Crear partidos
- Actualizar partidos
- Eliminar partidos

El backend fue construido en **PHP** y ejecutado dentro de un contenedor **Docker** que expone el servicio en el puerto **8080**.

---

## Endpoints Implementados

| Método | Endpoint              | Descripción                    |
|--------|-----------------------|--------------------------------|
| GET    | `/api/matches`        | Obtener todos los partidos     |
| GET    | `/api/matches/:id`    | Obtener partido por ID         |
| POST   | `/api/matches`        | Crear nuevo partido            |
| PUT    | `/api/matches/:id`    | Actualizar un partido existente|
| DELETE | `/api/matches/:id`    | Eliminar un partido            |

---

## Docker

El backend corre en un contenedor Docker usando la imagen oficial de PHP 8.2 CLI. El `Dockerfile` permite iniciar el servidor PHP embebido en el puerto 8080


## Estructura del Proyecto
Lab-6-Backend-only/
├── public/
│   └── index.php
├── src/
│   └── MatchController.php
├── Dockerfile
├── README.md


---

## Contacto

- **Estudiante:** Fernando Rueda  
- **Carnet:** 23748  
- **Email:** rue3748@uvg.edu.gt

---

## Créditos

- Basado en [Best-README-Template](https://github.com/othneildrew/Best-README-Template).

