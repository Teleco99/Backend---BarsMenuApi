<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## API de Cartas Digitales para Bares

Esta API está diseñada para permitir la creación y edición de cartas digitales para bares, ofreciendo una experiencia fluida y eficiente. Algunos de los aspectos destacados de esta API incluyen:

- **Creación y Edición de Cartas**: Permite a los administradores crear y modificar cartas digitales de forma intuitiva.
- **Soporte para Imágenes**: La API permite la carga y gestión de imágenes para productos, mejorando la presentación de las cartas.
- **Autenticación con Token**: Implementa un sistema de autenticación basado en tokens, garantizando que solo los usuarios autorizados puedan realizar cambios en las cartas.

La API está construida sobre el framework Laravel, que ofrece una sintaxis expresiva y elegante, facilitando el desarrollo y la gestión de proyectos web complejos.

## Próximas Mejoras

- **Nuevo Campo para Indicar si el Producto Tiene Imagen**: Añadir un campo booleano en la base de datos para cada producto, indicando si tiene una imagen asociada. Esto permitirá realizar peticiones de descarga de imágenes solo cuando sea necesario, optimizando el uso de recursos del servidor.
- **Reestructuración de Relaciones entre Producto, Menú y Administrador**: Modificar las relaciones entre las entidades para una mayor coherencia y precisión en la base de datos, asegurando que cada producto se asocie correctamente con un administrador y el menú correspondiente.

