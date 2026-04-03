# ´URN´ BPMN Empresarial — Laravel 10 + bpmn-js ´URN´

Aplicación web para gestionar procesos BPMN: crear, editar, visualizar y exportar diagramas directamente desde el navegador.

Desarrollada como prueba técnica para demostrar el dominio de **Laravel 10**, **MVC**, **buenas prácticas SOLID** e integración de librerías JavaScript modernas con **Vite**.

---

##  Vistas del sistema

| Pantalla | Descripción |
|---|---|
| **Index** | Listado de procesos con búsqueda y paginación |
| **Create** | Editor BPMN interactivo + formulario de datos |
| **Edit** | Carga el diagrama guardado para modificarlo |
| **Show** | Visualizador de solo lectura + exportar `.bpmn` |

---

##  Stack tecnolOgico

| Capa | Tecnología |
|---|---|
| Backend | Laravel 10 (PHP 8.1+) |
| Base de datos | MySQL 8+ |
| Frontend bundler | Vite |
| Librería BPMN | bpmn-js (npm) |
| UI | Bootstrap 5 + Bootstrap Icons |
| Lenguaje de vistas | Blade (Laravel) |

---

##  Funcionalidades implementadas

### Requeridas
- [x] Tabla `processes` con todos los campos especificados
- [x] Listado de procesos (index)
- [x] Crear proceso con editor BPMN funcional
- [x] Editar proceso cargando el XML guardado
- [x] Ver proceso en modo solo lectura (`NavigatedViewer`)
- [x] Guardar y recuperar XML en campo `bpmn_xml`

### Extras (puntos adicionales)
- [x] Validación de campos con **Form Requests** separados
- [x] Diseño responsive y limpio con **Bootstrap 5**
- [x] Exportar diagrama como archivo **.bpmn**
- [x] Búsqueda de procesos por nombre
- [x] Paginación con persistencia de búsqueda
- [x] Botón flotante en móvil (FAB)
- [x] Palette de herramientas horizontal en móvil con scroll

---

##  Arquitectura del proyecto

El proyecto sigue el patrón **MVC** nativo de Laravel aplicando principios **SOLID**:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProcessController.php     # Responsabilidad única: solo orquesta
│   └── Requests/
│       ├── StoreProcessRequest.php   # Validación separada (SRP)
│       └── UpdateProcessRequest.php  # Open/Closed: extensible sin tocar el controlador
├── Models/
│   └── Process.php                   # Modelo con $fillable explícito
│
resources/
├── js/
│   ├── app.js                        # Bootstrap JS global
│   ├── bpmn-editor.js                # Solo para crear/editar (SRP)
│   └── bpmn-viewer.js                # Solo para visualizar (SRP)
├── css/
│   └── app.css                       # Variables corporativas + responsive
└── views/
    ├── layouts/app.blade.php         # Layout base reutilizable
    └── processes/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php
```

### Decisiones de diseño destacadas

- **Form Requests separados** para store y update: la validación no vive en el controlador.
- **Route Model Binding**: Laravel resuelve el modelo automáticamente, sin `Process::find($id)` manual.
- **JS por responsabilidad**: el editor y el viewer son archivos independientes — solo se cargan donde se necesitan.
- **Vite con entrypoints separados**: carga optimizada por vista.
- **Export sin librerías extra**: la exportación `.bpmn` usa una `Response` HTTP con headers correctos, sin dependencias innecesarias.

---

##  Instalación y configuración local

### Requisitos previos

Asegúrate de tener instalado:

| Herramienta | Versión mínima |
|---|                       ---|
| PHP         | 8.1 o superior |
| Composer    |       2.x      |
| Node.js     | 18.x o superior|
| npm         | 9.x o superior |
| MySQL       | 8.0 o superior |
| Git         | cualquier versión reciente |

---

### Paso 1 — Clonar el repositorio

```bash
git clone https://github.com/urbanoURN/BPMN_Empresarial.git
cd BPMN_Empresarial
```

---

### Paso 2 — Instalar dependencias PHP

```bash
composer install
```

---

### Paso 3 — Instalar dependencias JavaScript

```bash
npm install
```

---

### Paso 4 — Configurar el entorno

Copia el archivo de entorno y genera la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

---

### Paso 5 — Configurar la base de datos

Abre el archivo `.env` y edita estas líneas con tus credenciales MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bpmn_empresarial   # Nombre de tu base de datos
DB_USERNAME=root            # Tu usuario MySQL
DB_PASSWORD=                # Tu contraseña MySQL
```

Luego crea la base de datos en MySQL:

```MySql
CREATE DATABASE bpmn_empresarial CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Paso 6 — Ejecutar migraciones y datos de ejemplo

```bash
# Solo migraciones
php artisan migrate

# Migraciones + datos de ejemplo (recomendado para ver el sistema funcionando)
php artisan migrate --seed
```

---

### Paso 7 — Compilar los assets

```bash
# Modo desarrollo (con hot reload) Pruebas Locales
npm run dev

# Modo producción (para entrega final) *Pruebas* en Vivo
npm run build
```

---

### Paso 8 — Levantar el servidor

```bash
php artisan serve
```

Abre tu navegador en: **http://localhost:8000**

---

##  Datos de ejemplo (Seeder)

El proyecto incluye un seeder con **3 procesos BPMN de ejemplo** para que puedas ver el sistema funcionando sin necesidad de crear datos manualmente.

Para ejecutarlo de forma aislada:

```bash
php artisan db:seed --class=ProcessSeeder
```

Para reiniciar la base de datos con datos frescos:

```bash
php artisan migrate:fresh --seed
```

---

##  Rutas disponibles

| Método | URI | Acción | Descripción |
|---|---|---|---|
| GET | `/processes` | index | Listado con búsqueda y paginación |
| GET | `/processes/create` | create | Formulario + editor BPMN |
| POST | `/processes` | store | Guardar nuevo proceso |
| GET | `/processes/{id}` | show | Ver diagrama en solo lectura |
| GET | `/processes/{id}/edit` | edit | Editar proceso existente |
| PUT | `/processes/{id}` | update | Actualizar proceso |
| DELETE | `/processes/{id}` | destroy | Eliminar proceso |
| GET | `/processes/{id}/export` | export | Descargar archivo `.bpmn` |

---

##  Comandos útiles de desarrollo

```bash
# Ver todas las rutas registradas
php artisan route:list

# Limpiar caché de configuración
php artisan config:clear

# Limpiar caché de vistas
php artisan view:clear

# Reiniciar base de datos con seeders
php artisan migrate:fresh --seed

# Compilar assets para producción
npm run build
```

---

##  Variables de entorno importantes

| Variable | Descripción | Valor por defecto |
|---|---|---|
| `APP_NAME` | Nombre de la app | `BPMN Empresarial` |
| `APP_ENV` | Entorno | `local` |
| `APP_DEBUG` | Modo debug | `true` |
| `APP_URL` | URL base | `http://localhost:8000` |
| `DB_CONNECTION` | Motor de BD | `mysql` |
| `DB_DATABASE` | Nombre de la BD | `bpmn_empresarial` |
| `DB_USERNAME` | Usuario MySQL | `root` |
| `DB_PASSWORD` | Contraseña MySQL | _(vacío)_ |

---

##  Cómo usar el editor BPMN

1. Ve a **Nuevo Proceso** desde el navbar o el botón flotante (móvil)
2. Completa el nombre y descripción del proceso
3. En el canvas del editor:
   - **Arrastra** elementos del panel de herramientas al canvas
   - **Conecta** elementos pasando el cursor sobre uno hasta ver el punto de conexión
   - **Doble clic** sobre cualquier elemento para editarlo
   - Usa los botones de la toolbar: **deshacer**, **rehacer**, **centrar vista**
4. Haz clic en **Guardar Proceso** — el XML se extrae automáticamente y se persiste en la base de datos

Para **exportar** un diagrama como archivo `.bpmn`, entra en la vista de detalle (solo lectura) y haz clic en **Exportar .bpmn**.

---

##  Autor

Desarrollado como prueba técnica — **[Edinson Urbano]**

- GitHub: https://github.com/urbanoURN
- Portafolio: https://portafoliourn.netlify.app/
- Email: edinsondevurn@gmail.com

---

##  Licencia??

Este proyecto fue desarrollado con fines de evaluación tecnica.