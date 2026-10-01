# 🏋️ FIT BULL CENTER - Sistema de Gestión de Gimnasio

Sistema web para administrar un gimnasio: socios, planes y membresías, pagos y facturas, clases y reservas, control de accesos, equipos y mantenimientos, empleados y usuarios con permisos por rol.

Proyecto final de Sistema de Información, desarrollado con **Scrum**, prácticas de **Extreme Programming (XP)**, modelado **UML** y diseño completo de base de datos.

---

## 📋 Características principales

- **Socios:** registro, edición, búsqueda y ficha completa (número `SOC-XXXXX` automático, baja lógica).
- **Planes y membresías:** la fecha de fin se calcula según el plan y las membresías vencen solas cada día.
- **Pagos y facturas:** registro de ingresos con método de pago, anulación con motivo y factura `FAC-AAAA-NNNN`.
- **Clases, horarios y reservas:** validación de membresía vigente, capacidad máxima y horarios sin traslape por sala.
- **Accesos:** registro de entrada y salida con duración calculada automáticamente.
- **Equipos y mantenimientos:** inventario, categorías y mantenimientos preventivos y correctivos.
- **Empleados y usuarios:** personal, instructores y cuentas con rol Administrador o Recepcionista.
- **Dashboard** con indicadores del día y **dos reportes** para Power BI.

---

## 🧰 Tecnologías

| Capa | Tecnología |
|------|------------|
| Backend | PHP 7.4+ con PDO |
| Base de datos | MySQL 5.7+ / MariaDB 10.4+ (InnoDB) |
| Frontend | HTML, Bootstrap 5 |
| Reportes | Power BI (vistas SQL) |
| Gestión | Scrum (Product Backlog, Sprint Backlog, tablero) |
| Modelado | UML y modelo entidad-relación |

---

## 🚀 Instalación

### 1. Requisitos

- Apache con PHP 7.4 o superior (XAMPP o Laragon)
- MySQL 5.7+ o MariaDB 10.4+

### 2. Base de datos

Ejecuta los scripts **en este orden**:

| Orden | Archivo | Qué hace |
|-------|---------|----------|
| 1 | `01_crear_base_datos.sql` | Crea la base `si_if2` (utf8mb4) y muestra dónde se guardan los archivos de datos y de LOG |
| 2 | `si_if2.sql` | Crea las 15 tablas, índices, claves foráneas, 2 triggers y el evento diario |
| 3 | `02_datos_iniciales.sql` | Carga roles, usuarios, planes y datos de ejemplo para probar |
| 4 | `03_vistas_reportes.sql` | Crea las vistas que usan los reportes de Power BI |

Desde la terminal:

```bash
mysql -u root -p < 01_crear_base_datos.sql
mysql -u root -p si_if2 < si_if2.sql
mysql -u root -p si_if2 < 02_datos_iniciales.sql
mysql -u root -p si_if2 < 03_vistas_reportes.sql
```

> El evento `evt_vencer_membresias` necesita `event_scheduler = ON`. El script 01 ya lo activa; si reinicias MySQL, vuelve a activarlo o déjalo fijo en `my.ini`.

### 3. Conexión a la base de datos

Edita `config/db.php` con tus datos:

```php
<?php
$dbConfig = [
    'host'     => 'localhost',
    'dbname'   => 'si_if2',
    'user'     => 'root',
    'password' => '',
];
?>
```

### 4. Copiar el proyecto al servidor

- XAMPP: `C:\xampp\htdocs\PROYECTO-FINAL`
- Laragon: `C:\laragon\www\PROYECTO-FINAL`

### 5. Abrir el sistema

```
http://localhost/PROYECTO-FINAL/
```

---

## 👤 Usuarios de prueba

El campo de acceso se llama "email", pero se escribe el nombre de usuario indicado.

| Rol | Usuario | Contraseña |
|-----|---------|------------|
| Administrador | `admin@gimnasio.com` | `password` |
| Recepcionista | `dorischata@gmail.com` | `doris123` |

> ⚠️ Cambia ambas contraseñas después del primer ingreso (menú Usuarios → Editar).

---

## 📊 Estructura del proyecto

```
PROYECTO-FINAL/
├── config/db.php              # Conexión PDO
├── includes/                  # init, auth, header, footer
├── socios/  membresias/  planes/  pagos/  facturas/
├── clases/  horarios/  reservas/
├── empleados/  usuarios/  equipos/  mantenimientos/  accesos/
├── index.php                  # Página de bienvenida
├── login.php  logout.php
├── dashboard.php              # Dashboard principal (después del login)
├── si_if2.sql                 # Esquema de la base de datos
├── 01_crear_base_datos.sql    # Creación de la BD y ubicación de archivos
├── 02_datos_iniciales.sql     # Roles, usuarios y datos de ejemplo
├── 03_vistas_reportes.sql     # Vistas para Power BI
└── README.md
```

---

## 🔐 Roles y permisos

| Función | Administrador | Recepcionista |
|---------|:-------------:|:-------------:|
| Dashboard | ✅ | ✅ |
| Socios | ✅ | ✅ |
| Membresías | ✅ | ✅ |
| Pagos | ✅ | ✅ |
| Facturas | ✅ | ✅ |
| Reservas | ✅ | ✅ |
| Accesos | Solo consulta | Registra entradas y salidas |
| Planes | ✅ | ❌ |
| Clases y horarios | ✅ | ❌ |
| Empleados | ✅ | ❌ |
| Usuarios | ✅ | ❌ |
| Equipos y mantenimientos | ✅ | ❌ |

---

## 🛠️ Reglas de negocio implementadas

- El correo es único entre usuarios, empleados y socios.
- El número de socio (`SOC-XXXXX`) es único y automático.
- Fecha de fin de membresía = fecha de inicio + duración del plan.
- Una membresía activa con fecha de fin pasada se marca como vencida (evento diario).
- Solo se reserva una clase con membresía activa y cupo disponible.
- Un socio no puede reservar dos veces el mismo horario en la misma fecha.
- No puede haber dos clases en la misma sala, día y hora.
- Solo ingresa un socio con membresía activa y sin una entrada abierta.
- Solo se factura un pago en estado "pagado", y una sola vez.
- Un mantenimiento correctivo pone el equipo en "mantenimiento"; al cerrarlo vuelve a "operativo" (triggers).
- Los socios no se borran: se desactivan para conservar el historial.

---

## 🔒 Seguridad

- Autenticación por sesión y control de acceso por rol
- Tokens CSRF en los formularios
- Contraseñas con `password_hash`
- Escape de salida HTML con la función `e()`
- Consultas preparadas con PDO
- `config/db.php` excluido del repositorio con `.gitignore`

---

## 📈 Reportes (Power BI)

Se diseñaron dos reportes que se alimentan de vistas SQL:

1. **Ingresos y membresías:** ingresos por mes y método de pago, ticket promedio, membresías por plan, estado y próximas a vencer.
   Vistas: `vw_ingresos`, `vw_membresias_plan`.
2. **Ocupación de clases y asistencia:** ocupación por clase, reservas por día, asistencia sobre reservas y accesos por hora.
   Vistas: `vw_ocupacion_clases`, `vw_estado_reservas`, `vw_accesos_hora`.

Para conectarlos: Power BI Desktop → Obtener datos → MySQL → servidor `localhost`, base `si_if2` y selecciona las vistas.

---

## 🗂️ Metodología y documentación

- **Scrum:** Product Backlog de 14 historias de usuario; el Sprint 1 incluye US-01 a US-06 (inicio de sesión, socios, membresías, planes, pagos y accesos).
- **XP:** estándares de codificación, diseño simple, refactorización (carpeta `includes/`) y entregas pequeñas.
- **UML:** casos de uso, clases, secuencia y actividad.
- **Base de datos:** diseño conceptual, lógico (normalizado hasta 3FN) y físico.

La documentación completa está en `Documentacion_FitBull_Center.docx`.

---

## 🐛 Solución de problemas

**Error de conexión a la base de datos**
- Verifica que MySQL esté corriendo y revisa `config/db.php`.
- Confirma que la base `si_if2` existe.

**No puedo iniciar sesión**
- Verifica que ejecutaste `02_datos_iniciales.sql` (sin él no existen roles ni usuarios).
- Escribe `admin` en el campo de usuario, no un correo.

**Las membresías no vencen solas**
- Revisa que el planificador de eventos esté activo: `SHOW VARIABLES LIKE 'event_scheduler';`

**Pantalla en blanco**
- Activa `display_errors` en `php.ini` y revisa los logs de Apache.

---

**Versión:** 1.1
**Última actualización:** Septiembre de 2026
**Autor:** [Tu nombre]
