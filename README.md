# Sistema de Reserva de Entradas de Cine - PHP

Este es un sistema de reserva de entradas de cine desarrollado en PHP, con un frontend construido con Bootstrap, CSS, HTML y JavaScript, y una base de datos MySQL. El proyecto ha sido personalizado y mejorado por Renso Abraham Mamani.

El sistema permite a los usuarios consultar las películas recientes, reservar y cancelar entradas, y verificar el estado de sus reservas. El objetivo es proporcionar una plataforma sencilla para que las personas puedan comprar entradas de cine de forma fácil y accesible desde cualquier lugar.

## Características

- **Panel de Administración:** Un panel completo para gestionar películas, funciones, reservas y comentarios de los usuarios.
- **CRUD de Películas:** Funcionalidad completa para Crear, Leer, Actualizar y Eliminar (CRUD) películas en el catálogo.
- **Gestión de Funciones:** Sistema para añadir, editar y eliminar horarios y salas para cada película.
- **Horario Dinámico:** La página de horarios se actualiza dinámicamente desde la base de datos, mostrando las funciones disponibles por fecha.
- **Selección de Asientos:** Interfaz interactiva para que los usuarios seleccionen sus asientos.
- **Simulación de Asientos Ocupados:** Para una experiencia más realista, algunos asientos aparecen como ocupados.
- **Simulación de Pago:** Un flujo de pago mejorado que simula métodos de pago populares en Perú, como Yape y Plin.
- **Modo Oscuro:** Un interruptor para cambiar entre el tema claro y oscuro.

## Instalación

Para este proyecto, se utilizó [XAMPP](https://www.apachefriends.org/).

1.  Abre **PHPMyAdmin**.
2.  Crea una nueva base de datos (por ejemplo, `cinema_db`).
3.  Importa `database/cinema_db.sql` para crear las tablas iniciales.
4.  Importa `database/showtimes.sql` para crear la tabla de funciones.
5.  Abre `connection.php` y actualiza el nombre de la base de datos y la contraseña si es necesario.
6.  Ve a la carpeta `admin`, abre `config.php` y actualiza el nombre de la base de datos y la contraseña.

## Uso

### Acceso al Panel de Administrador

-   **Usuario:** 123
-   **Contraseña:** 123

### Simulación de Pago

El sistema incluye una simulación de pago con métodos peruanos. Al reservar una entrada, se presentarán las siguientes opciones:

<p align="center">
  <img src="img/yape-logo.png" width="80" alt="Yape">
  &nbsp;&nbsp;&nbsp;&nbsp;
  <img src="img/plin-logo.png" width="80" alt="Plin">
</p>

-   **Yape y Plin:** Muestra un código QR para una simulación de pago.
-   **Tarjeta de Crédito/Débito:** Muestra un formulario para una simulación de pago con tarjeta.

## Desarrollado Por

-   **Renso Abraham Mamani**

## Imágenes del Sistema

<img src="img/screenshot/1.png" width="45%">
<img src="img/screenshot/2.png" width="45%">
<img src="img/screenshot/3.png" width="45%">
<img src="img/screenshot/4.png" width="45%">
<img src="img/screenshot/13.png" width="45%">
<img src="img/screenshot/14.png" width="45%">
<img src="img/screenshot/15.png" width="45%">
<img src="database/ER.png" width="90%">
