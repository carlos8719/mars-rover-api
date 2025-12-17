# Mars Rover API

API REST desarrollada en Laravel que simula el movimiento de un rover sobre un planeta cuadrado de 200x200, interpretando una secuencia de comandos y detectando obstáculos antes de cada movimiento.
El objetivo del proyecto es demostrar diseño orientado a dominio, claridad de lógica y facilidad de testeo.
---
## Requisitos

- PHP >= 8.1
- Composer
- Laravel 11
- No se requiere base de datos

---

## Instalación y arranque

### 1. Clonar o descargar el proyecto

```bash
git clone https://github.com/tuusuario/mars-rover-api.git
cd mars-rover-api
```
### 2. Instalar dependencias

```bash
composer install
```

### 3. configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```
### 4. Iniciar el servidor de desarrollo

```bash
php artisan serve
```
### - El servidor estará disponible en:
```html
http://127.0.0.1:8000
```
---

## API

### EndPoint princial
```bash
POST /api/rover/move
```
### Request Body (JSON)

```json
{
  "position": { "x": 0, "y": 0 },
  "direction": "N",
  "commands": "FFRFFFRL",
  "obstacles": [
    { "x": 3, "y": 2 }
  ]
}
```

| Campo                   | Descripción                            |
| ----------------------- | -------------------------------------- |
| position.x / position.y | Posición inicial del rover.            |
| direction               | Dirección inicial (`N`, `E`, `S`, `W`).|
| commands                | Secuencia de comandos (`F`, `L`, `R`). |
| obstacles               | Lista de obstáculos opcional.          |

### Comandos
| Comando                 | Descripción                            |
| ----------------------- | -------------------------------------- |
| F /Avanza               | 1 unidad en la dirección actual.       |
| L                       | Gira 90° a la izquierda.               |
| R                       |Gira 90° a la derecha.                  |

Los comandos se ejecutan uno a uno y en orden.
Si se detecta un obstáculo o el rover intenta salir del grid, la ejecución se detiene y se informa.

### Response

```json
{
  "x": 2,
  "y": 3,
  "direction": "E",
  "obstacleDetected": false
}
```

### Si se detecta un obstáculo:

```json
{
  "x": 0,
  "y": 1,
  "direction": "N",
  "obstacleDetected": true
}
```
---
## Testing

```bash
php artisan test
```
### Los tests cubren:

- Movimiento del rover.
- Detección de obstáculos.
- Abortado de ejecución ante límites u obstáculos.

### Ejemplo de test de API

```php
$this->postJson('/api/rover/move', [
    'position' => ['x' => 0, 'y' => 0],
    'direction' => 'N',
    'commands' => 'FFR',
    'obstacles' => [['x' => 0, 'y' => 2]]
])
->assertStatus(200)
->assertJson([
    'x' => 0,
    'y' => 1,
    'obstacleDetected' => true
]);
```

- Cada test define su propio escenario, lo que asegura determinismo y repetibilidad.
---
## Conclusión

### La solución prioriza:

- Claridad y separación de responsabilidades (dominio vs. API).
- Testabilidad completa.
- Cumplimiento estricto del enunciado.
- Evita overengineering y mantiene enfoque en la lógica de negocio.
