# Sistema de Reserva de Entradas de Cine - PHP

Este es un sistema de reserva de entradas de cine desarrollado en PHP, con un frontend construido con Bootstrap, CSS, HTML y JavaScript, y una base de datos MySQL. El proyecto ha sido personalizado y mejorado por Renso Abraham Mamani.

El sistema permite a los usuarios consultar las películas recientes, reservar y cancelar entradas, y verificar el estado de sus reservas. El objetivo es proporcionar una plataforma sencilla para que las personas puedan comprar entradas de cine de forma fácil y accesible desde cualquier lugar.

## Proyecto inspirado en:
- **https://github.com/aman05382/movie_ticket_booking_system_php?tab=readme-ov-file**

## Características

- **Panel de Administración:** Un panel completo para gestionar películas, funciones, reservas y comentarios de los usuarios.
- **CRUD de Películas:** Funcionalidad completa para Crear, Leer, Actualizar y Eliminar (CRUD) películas en el catálogo.
- **Gestión de Funciones:** Sistema para añadir, editar y eliminar horarios y salas para cada película.
- **Horario Dinámico:** La página de horarios se actualiza dinámicamente desde la base de datos, mostrando las funciones disponibles por fecha.
- **Selección de Asientos:** Interfaz interactiva para que los usuarios seleccionen sus asientos.
- **Simulación de Asientos Ocupados:** Para una experiencia más realista, algunos asientos aparecen como ocupados.
- **Simulación de Pago:** Un flujo de pago mejorado que simula métodos de pago populares en Perú, como Yape y Plin.
- **Modo Oscuro:** Un interruptor para cambiar entre el tema claro y oscuro.

### Simulación de Pago

El sistema incluye una simulación de pago con métodos peruanos. Al reservar una entrada, se presentarán las siguientes opciones:

<p align="center">
  <img src="img/yape-logo.png" width="80" alt="Yape">
  &nbsp;&nbsp;&nbsp;&nbsp;
  <img src="img/plin-logo.png" width="80" alt="Plin">
</p>

-   **Yape y Plin:** Muestra un código QR para una simulación de pago.
-   **Tarjeta de Crédito/Débito:** Muestra un formulario para una simulación de pago con tarjeta.

## Resolucion del Caso Práctico y Fundamentación
Este sistema de reserva de entradas de cine fue desarrollado aplicando los conocimientos adquiridos a lo largo del curso, incluyendo el manejo de entornos de desarrollo web con servidor local y bases de datos MySQL, la implementación de operaciones CRUD, y buenas prácticas de seguridad y arquitectura.

Se configuró un entorno local usando XAMPP para integrar Apache, PHP y MySQL, facilitando las pruebas y el desarrollo. Se aplicó un diseño modular básico inspirado en el patrón MVC, separando la lógica de negocio, la interfaz y el control, lo que permitió un código más organizado y mantenible.

El sistema utiliza PDO con consultas preparadas para proteger la base de datos contra inyecciones SQL y maneja un sistema de autenticación seguro con contraseñas hasheadas, mejorando la protección de los datos de los usuarios.

Para la experiencia de usuario, se diseñó una interfaz responsiva con Bootstrap, que incluye funcionalidades avanzadas como la selección interactiva de asientos, simulación visual de asientos ocupados y un flujo de pago con métodos populares en Perú (Yape y Plin) mediante códigos QR, así como opción para pagos con tarjeta simulados.

Se usó control de versiones con Git, trabajando con ramas para desarrollar nuevas funcionalidades y resolver problemas de forma ordenada y colaborativa, lo que facilitó la mejora continua del proyecto.

En resumen, este proyecto no solo cumple con los requisitos funcionales del sistema de reservas, sino que también refleja la aplicación práctica de los contenidos del curso, integrando herramientas, metodologías y buenas prácticas para crear una solución robusta, segura y escalable.

## Desarrollado Por

-   **Renso Abraham Mamani Mamani**
