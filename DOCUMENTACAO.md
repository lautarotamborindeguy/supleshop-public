# SupleStore

## Integrantes

Lautaro Tamborindeguy

## Objetivo del sistema

SupleStore es un sistema web para una tienda de suplementos deportivos. El objetivo es permitir que los visitantes vean productos activos en el catálogo, filtren por categoría, agreguen ítems al carrito y envíen un pedido por WhatsApp. El sistema también incluye un área administrativa protegida por inicio de sesión para gestionar productos.

## Tecnologías utilizadas

- HTML5 semántico
- CSS3
- JavaScript puro
- PHP puro
- MySQL
- PDO para conexión con la base de datos
- Sesiones PHP para login administrativo
- localStorage para el carrito

## Funcionalidades

- Inicio público con presentación de la tienda.
- Catálogo público de productos activos.
- Búsqueda pública por nombre, descripción o categoría.
- Filtro público por categoría.
- Carrito de compras con JavaScript y localStorage.
- Confirmación de pedidos con descuento de stock y envío por WhatsApp.
- Página Sobre.
- Página Contacto con validación simple en JavaScript.
- Acceso administrativo con sesión PHP.
- Panel administrativo protegido.
- CRUD completo de productos:
  - Alta
  - Listado
  - Actualización
  - Eliminación
  - Búsqueda

## Estructura de páginas

Las páginas principales usan extensión `.php` porque combinan HTML5 semántico con recursos de backend en PHP, como includes, sesiones y conexión con MySQL.

- `index.php`: página inicial.
- `produtos.php`: catálogo público de productos.
- `carrinho.php`: carrito de compras.
- `checkout.php`: formulario final del pedido.
- `checkout_process.php`: validación del carrito y descuento de stock.
- `sobre.php`: información sobre el proyecto y la tienda.
- `contato.php`: contacto con validación de campos.
- `login.php`: acceso administrativo.
- `logout.php`: cierre de sesión.
- `admin/dashboard.php`: panel administrativo.
- `admin/produtos/index.php`: listado y búsqueda de productos.
- `admin/produtos/create.php`: alta de producto.
- `admin/produtos/edit.php`: edición de producto.
- `admin/produtos/delete.php`: eliminación de producto.

## Estructura de la base de datos

Base de datos: `suple_store`

### Tabla `users`

- `id`: clave primaria.
- `username`: nombre del usuario administrador.
- `password`: contraseña encriptada.
- `created_at`: fecha de creación.

### Tabla `categories`

- `id`: clave primaria.
- `name`: nombre de la categoría.
- `created_at`: fecha de creación.

### Tabla `products`

- `id`: clave primaria.
- `category_id`: clave foránea hacia `categories.id`.
- `name`: nombre del producto.
- `description`: descripción del producto.
- `price`: precio en pesos uruguayos (UYU).
- `stock`: stock.
- `image`: nombre del archivo de imagen.
- `active`: estado del producto.
- `created_at`: fecha de creación.

## Relación entre tablas

La tabla `categories` se relaciona con la tabla `products` en una relación 1 a N.

Una categoría puede tener varios productos, pero cada producto pertenece a una sola categoría.

Ejemplo:

- Categoría: Creatinas
- Productos: Creatina Monohidratada 300g, Creatina Monohidratada 1kg

La clave foránea `products.category_id` referencia la clave primaria `categories.id`.

## Cómo ejecutar localmente

1. Instalar un entorno local con PHP y MySQL, como XAMPP, WAMP o Laragon.
2. Copiar la carpeta del proyecto en la carpeta pública del servidor local.
3. Crear la base de datos importando el archivo `database/database.sql` en MySQL.
4. Revisar los datos de conexión en `includes/db.php`:
   - host: `localhost`
   - base de datos: `suple_store`
   - usuario: `root`
   - contraseña: vacía por defecto
5. Acceder a `index.php` desde el navegador.
6. Para acceder al panel administrativo:
   - URL: `login.php`
   - Usuario: `admin`
   - Contraseña: `admin123`

## Capturas del sistema

### Inicio

Captura del Inicio.

### Catálogo público

Captura del catálogo de productos.

### Carrito

Captura del carrito.

### Finalizar pedido

Captura de la pantalla para finalizar el pedido.

### Acceso administrativo

Captura del acceso administrativo.

### CRUD de productos

Captura del CRUD.

## Funcionamiento del carrito y checkout

El carrito es controlado por el archivo `assets/js/cart.js`. Cuando el usuario hace clic en "Agregar al carrito", JavaScript lee los atributos `data-id`, `data-name`, `data-price`, `data-stock` y `data-image` del botón.

Los productos se guardan en un array de objetos con:

- `id`
- `name`
- `price`
- `stock`
- `image`
- `quantity`

Ese array se guarda en `localStorage`, por eso el carrito sigue disponible al navegar entre páginas. JavaScript también actualiza el contador del carrito, renderiza los ítems en `carrinho.php`, recalcula subtotales y total general.

Al finalizar el pedido, `assets/js/cart.js` envía los productos a `checkout_process.php`. Ese endpoint valida que los productos existan, revisa que haya stock suficiente y descuenta las cantidades en MySQL dentro de una transacción. Si no hay stock suficiente, el pedido se bloquea y el carrito no se limpia. Si el stock se actualiza correctamente, el sistema abre WhatsApp con el detalle del pedido precargado.

El número de WhatsApp de la tienda está definido en `assets/js/cart.js` mediante la constante `STORE_WHATSAPP_PHONE`.

## Funcionamiento del acceso administrativo

El acceso administrativo está en `login.php`. El sistema consulta la tabla `users` usando PDO y verifica la contraseña con `password_verify()`.

Cuando el acceso es correcto, PHP crea variables de sesión:

- `$_SESSION['user_id']`
- `$_SESSION['username']`

Las páginas administrativas usan `requireLogin()` del archivo `includes/auth.php`. Si no existe un usuario con sesión iniciada, el sistema redirige a `login.php`.

## Validaciones implementadas

- Campos vacíos en el acceso administrativo.
- Campos vacíos en el alta y la edición de productos.
- Precio numérico y mayor que cero.
- Stock numérico y mayor o igual a cero.
- Correo electrónico válido al finalizar el pedido.
- Teléfono válido en el checkout.
- Carrito vacío bloqueado en el checkout.
- Stock suficiente antes de confirmar el pedido.
- Formulario de contacto con validación de campos y correo electrónico.

## Mejoras futuras

- Guardar pedidos en MySQL.
- Crear combos de productos.
- Agregar método de pago.
- Carga real de imágenes.
- Panel con estadísticas.

## Checklist de la consigna

- HTML5 semántico: cumplido.
- `header`, `nav`, `main`, `section`, `article`, `aside`, `footer`: cumplido.
- CSS3 con clases, IDs, Box Model, Flexbox, posicionamiento, hover y responsividad: cumplido.
- JavaScript con variables, operadores, decisiones, repeticiones, arrays, funciones, objetos, DOM, eventos y validaciones: cumplido.
- PHP y MySQL: cumplido.
- PDO: cumplido.
- Mínimo 2 tablas relacionadas: cumplido con `categories` y `products`.
- Clave primaria y clave foránea: cumplido.
- Acceso administrativo con sesiones: cumplido.
- CRUD completo de productos: cumplido.
- Alta, listado, actualización, eliminación y búsqueda: cumplido.
- Inicio, alta, listado, Sobre y Contacto: cumplido.
- Carrito con localStorage: cumplido.
- Confirmación de pedidos con descuento de stock y envío por WhatsApp: cumplido.
