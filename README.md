# Práctica P2.1 - DevLevel v1
**Asignatura:** Desarrollo Web en Entorno Servidor (DWS)  
**Curso:** 2 DAW  

---

## 1. Descripción del Proyecto
Esta aplicación web implementa la plataforma gamificada **DevLevel**, diseñada para gestionar tareas de desarrollo y medir el progreso del programador. Los usuarios acumulan puntos de experiencia (XP), aumentan su nivel y los desarrolladores *Junior* ascienden automáticamente a *Senior* al superar el umbral de 450 XP.

---

## 2. Credenciales de Prueba

| Rol | Usuario | Contraseña | Nivel Inicial |
| :--- | :--- | :--- | :--- |
| **Project Manager** | `manager` | `Manager2026!` | 5 |
| **Senior Developer** | `senior` | `Senior2026!` | 4 |
| **Junior Developer** | `junior` | `Junior2026!` | 1 |

---

## 3. Arquitectura y Estructura Modular
El proyecto está organizado en carpetas para separar la lógica del código de las vistas y rutas públicas:
- `config/`: Constantes del sistema (roles, umbrales de XP y timeouts de sesión).
- `src/`: Lógica de datos, autenticación, gamificación y utilidades.
- `public/`: Archivos accesibles desde el navegador (controladores de entrada y formularios).

---

## 4. Comprobaciones Técnicas y Verificaciones DevTools

1. **Flujo PRG (Post-Redirect-Get):**
   Al enviar el formulario de inicio de sesión o completar una tarea vía `POST`, la pestaña *Network* de DevTools muestra la respuesta inicial con código **302 Redirect**, seguida inmediatamente por una petición **GET** con código **200 OK** a la vista de destino.
   
2. **Cookies de Sesión Seguras:**
   En la pestaña *Application / Storage -> Cookies*, se comprueba que la cookie de sesión `PHPSESSID` y la cookie `devlevel_remember_user` incorporan activados los atributos de seguridad `HttpOnly` y `SameSite=Lax`.

3. **Protección contra Inyección XSS:**
   Se ha probado la inyección de la cadena `<script>alert('XSS')</script>` en los datos de entrada. Gracias a la función `htmlspecialchars()`, el navegador muestra el texto literalmente en pantalla como código escapado y no ejecuta el script.

4. **Promoción Automática en Caliente:**
   Iniciando sesión con la cuenta `junior` y completando tareas hasta acumular 450 XP o más, el sistema cambia dinámicamente el rol a `DEVELOPER_SENIOR` y muestra el mensaje de ascenso en la interfaz.
