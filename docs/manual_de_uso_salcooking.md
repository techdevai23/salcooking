# 🧾 Manual de Uso de SalCooking

## Índice

1.  [Introducción](#1-introduccion)
2.  [Descripción General del Sistema](#2-descripcion-general-del-sistema)
    1.  [Acceso y Registro](#21-acceso-y-registro)
    2.  [Navegación Principal](#22-navegacion-principal)
    3.  [Buscar y Filtrar Recetas](#23-buscar-y-filtrar-recetas)
    4.  [Planificador de Dietas](#24-planificador-de-dietas)
    5.  [Lista de la Compra](#25-lista-de-la-compra)
    6.  [Trucos](#26-trucos)
    7.  [Planes](#27-planes)
    8.  [Ayuda y Preguntas Frecuentes](#28-ayuda-y-preguntas-frecuentes)
3.  [Niveles de Acceso](#3-niveles-de-acceso)
    1.  [Cuenta Prémium](#31-cuenta-premium)
4.  [Requisitos Previos](#4-requisitos-previos)
5.  [Primeros Pasos](#5-primeros-pasos)
    1.  [Acceso a la Aplicación](#51-acceso-a-la-aplicacion)
    2.  [Registro de un Nuevo Usuario](#52-registro-de-un-nuevo-usuario)
    3.  [Inicio de Sesión](#53-inicio-de-sesion)
    4.  [Gestión del Perfil de Usuario](#54-gestion-del-perfil-de-usuario)
    5.  [Búsqueda y Selección de Recetas (Funcionalidad detallada)](#55-busqueda-y-seleccion-de-recetas-funcionalidad-detallada)
    6.  [Planificación de Dietas Semanales (Funcionalidad detallada)](#56-planificacion-de-dietas-semanales-funcionalidad-detallada)
    7.  [Generación de la Lista de la Compra (Funcionalidad detallada)](#57-generacion-de-la-lista-de-la-compra-funcionalidad-detallada)
6.  [Ayuda, Soporte, Contacto y Gestiones](#6-ayuda-soporte-contacto-y-gestiones)
7.  [Gestión Periódica del Sistema (Orientada al Usuario)](#7-gestion-periodica-del-sistema-orientada-al-usuario)
    1.  [Usuario Final](#71-usuario-final)
    2.  [Administradores del Sistema](#72-administradores-del-sistema)
8.  [Consideraciones de Seguridad y Privacidad](#8-consideraciones-de-seguridad-y-privacidad)
9.  [Contacto y Soporte](#9-contacto-y-soporte)

---

## 1. Introducción

Bienvenido/a a SalCooking, la aplicación web diseñada para revolucionar la forma en que se planifica la alimentación. Esperamos que la disfrute y que le sea muy útil.

SalCooking tiene como objetivo principal facilitar la creación de menús semanales equilibrados y totalmente personalizados, teniendo en cuenta gustos personales, intolerancias, alergias y diversas condiciones de salud.
Con SalCooking, "El Arte de Cocinar: Planifica. Cocina. Cuida tu Salud." se convierte en una realidad accesible para todos.

Este manual de usuario proporciona una guía detallada sobre cómo utilizar la aplicación SalCooking, desde los requisitos básicos para su acceso hasta la gestión de sus funcionalidades principales.

## 2. Descripción General del Sistema

SalCooking es una aplicación web de planificación alimentaria personalizada. Su interfaz intuitiva y sus potentes funcionalidades permiten a los usuarios buscar recetas saludables adaptadas a sus preferencias y necesidades médicas (alergias, intolerancias y enfermedades), así como generar menús y listas de la compra automatizadas. La plataforma funciona por niveles de acceso: visitante, usuario registrado y usuario prémium, ofreciendo funcionalidades ampliadas en cada nivel. Está desarrollada bajo el patrón MVC y con un enfoque *mobile-first* para garantizar su uso desde cualquier dispositivo.

De manera resumida y a modo de repaso global, se realiza un pequeño recorrido por las funciones y características que ofrece la aplicación. Pueden verse más desarrolladas en el apartado [5. Primeros Pasos](#5-primeros-pasos).

### 2.1. Acceso y Registro

* **Visitar el sitio web:** `https://salcooking.free.nf/index.php`
* **Registro:**
    * Hacer clic en el botón "**Regístrate gratis**" en la esquina superior derecha.
    * Completar el formulario con los datos personales y preferencias alimentarias.
* **Inicio de sesión:**
    * Hacer clic en el icono de perfil de usuario para iniciar sesión.
    * Introducir el correo electrónico y contraseña.

### 2.2. Navegación Principal

Una vez dentro de la plataforma, se encontrará el menú principal con las siguientes secciones:

* **Inicio:** Página de entrada con bienvenida, presentación, acceso al buscador, acceso rápido a funciones principales y llamada a la acción (CTA) para registrarse.
* **Nuestra filosofía:** Se promueve una alimentación saludable, con recetas adaptadas a cada persona. Se cuenta con asesoramiento nutricional y culinario profesional.
* **Recetas:** Buscador de recetas con filtros básicos y, para usuarios prémium, filtros por enfermedades y alérgenos. Cada receta se muestra de manera dinámica en un carrusel e incluye ingredientes, pasos y etiquetas.
* **Dietas:** Función exclusiva para usuarios prémium que permite generar menús semanales adaptados a perfiles con condiciones de salud.
* **Trucos:** Blog con consejos prácticos de cocina y artículos sobre alimentación saludable, de acceso libre.
* **Planes:** Sección informativa sobre las diferencias entre usuarios (visitante, registrado y prémium) y cómo activar el plan de pago.
* **Ayuda:** Acceso a las preguntas frecuentes y enlaces a formularios de soporte.
* **Contáctanos:** Formulario para dudas, sugerencias o incidencias, con respuesta por correo electrónico. Incluso ofrece la posibilidad de realizar gestiones, como solicitar el código Prémium, mediante pago en una pasarela.
* **Perfil - Ajustes:** Permite editar datos, gestionar perfiles de salud, introducir el código prémium y consultar recetas favoritas.

### 2.3. Buscar y Filtrar Recetas

Se puede acceder a una amplia base de datos de recetas que pueden ser filtradas según diversos criterios como ingredientes, tiempo de preparación, tipo de plato y, fundamentalmente, por alergias, intolerancias alimentarias (gluten, lactosa, frutos secos, etc.) o enfermedades (diabetes, hipertensión, celiaquía, etc.).

Principalmente, se pueden buscar recetas de dos maneras:

* Desde la **barra superior de búsqueda**.
* Accediendo a la sección "**Recetas**" desde la barra de navegación o desde el menú desplegable lateral (en la versión de escritorio). En la vista móvil, solo existe un menú tipo hamburguesa en la esquina superior izquierda.

Una vez introducida la receta deseada, se llegará a una página de resultados. Si no hubiese ninguna receta cuyo título contenga las palabras escritas, se verá un mensaje que indica: “No se han encontrado recetas para esta búsqueda.” En caso contrario, se mostrará un carrusel con las recetas disponibles. Se sabrá el número total de recetas porque aparece al lado del título de esta página: “Resultados de recetas”.

Se pueden utilizar los siguientes **filtros y opciones**:

* **Filtros gratuitos disponibles** para refinar la búsqueda:
    * **Tipo de plato:** Entrante, principal, postre, desayuno, cena.
    * **Alérgenos a evitar:** Gluten, lactosa, frutos secos, etc.
    * **Porciones:** (para cuántos comensales está diseñada la receta).
* **Selector de ordenamiento:**
    * Por orden alfabético (ascendente y descendente).
    * Por cantidad de ingredientes que tiene la receta.
* **Filtros y búsquedas Prémium:**
    * Por enfermedad (colesterol o diabetes).
    * Teniendo en cuenta el perfil completo del usuario (alérgenos y enfermedades).
    * Por tiempo de preparación.
    * Búsqueda exclusiva para buscar o filtrar por ingrediente (ya que el buscador general solo busca por título de receta).
* **Visualización de resultados:** Se seleccionará la receta que se desee para ver los detalles completos.
* **Descarga de la receta:** Para guardar o imprimir (solo usuarios registrados y Prémium).

### 2.4. Planificador de Dietas

Permite elaborar planes de comidas semanales de forma automática, asegurando una dieta variada y equilibrada que cumple con los requisitos nutricionales y las restricciones de cada perfil.
(Disponible para usuarios Prémium)

* Acceder a la sección "**Dietas**" desde el menú principal, que es un planificador de recetas para toda la semana.
* Hacer clic en el botón “**Generar nueva dieta**” y seleccionar la franja que se desea consultar: desayuno, comida (entrante, plato principal y postre) o cena.
* Consultar recetas haciendo clic en la foto o día de la semana.
* Guardar el plan para futuras consultas y generación de listas de la compra.

### 2.5. Lista de la Compra

(Disponible para usuarios Prémium)
Permite descargar automáticamente una lista de la compra consolidada con todos los ingredientes agrupados y necesarios para las recetas incluidas en el plan semanal.

* Desde el planificador de dietas, una vez organizados los menús, hacer clic en "**Generar lista de la compra**".
* Revisar los ingredientes.
* Descargar o imprimir la lista para utilizarla al hacer las compras.

### 2.6. Trucos

Esta sección recopila consejos útiles y recomendaciones breves sobre cocina saludable.

* Los contenidos están organizados en forma de tarjetas con títulos y descripciones claras.
* Incluye ideas sobre sustitución de ingredientes, mejoras en técnicas de cocinado y consejos prácticos para el día a día.
* Está disponible para todos los usuarios, sin necesidad de estar registrado.

### 2.7. Planes

La sección **Planes** ofrece una explicación clara sobre los tres niveles de usuario disponibles en SalCooking, detallando las funcionalidades accesibles en cada uno. Esta información permite al visitante valorar si desea registrarse o adquirir una cuenta prémium.

### 2.8. Ayuda y Preguntas Frecuentes

La sección **Ayuda** está pensada para resolver dudas frecuentes de los usuarios y facilitar el uso de la aplicación. Para resolver dudas comunes, se puede visitar la sección de Preguntas Frecuentes (FAQ), donde se encontrará información detallada sobre el uso de la plataforma, funcionalidades y más.

* Incluye un bloque de **preguntas frecuentes (FAQ)** con respuestas organizadas por temas: suscripciones, recetas, perfiles, enfermedades, etc.
* Se explican los pasos básicos para registrarse, buscar recetas, crear perfiles o activar una cuenta prémium.
* Si el usuario no encuentra solución a su duda, desde esta misma sección puede acceder directamente al formulario de contacto de la plataforma.
* Todo el contenido está redactado de forma sencilla y accesible para facilitar la comprensión, incluso a usuarios con poca experiencia digital.

## 3. Niveles de Acceso

El sistema está estructurado en diferentes niveles de acceso:

* **Visitante:** Puede buscar recetas, ver ingredientes e identificar alérgenos, además de acceder a la sección de trucos de cocina. No puede descargar recetas ni filtrar por enfermedades.
* **Usuario Registrado:** Tiene acceso a funcionalidades adicionales como la creación de hasta dos perfiles de salud, descarga de recetas y personalización parcial de la experiencia.
* **Usuario Prémium:** Dispone de acceso completo al sistema, incluyendo filtros avanzados por enfermedades, generación de menús diarios o semanales, creación automática de listas de la compra y consulta de recetas incompatibles con ciertas patologías.

### 3.1. Cuenta Prémium

Se desarrollan con más detalle los servicios que se obtienen adquiriendo la cuenta Prémium.

**Beneficios:**

* Acceso a filtros avanzados por condiciones de salud.
* Planificador de menús personalizado.
* Generación automática de listas de la compra.
* Gestión de evolución de síntomas en su perfil de salud.
* Descarga de recetas y listas de la compra en formato PDF.

**Activación:**

* Hacer clic en "**Hazte Prémium**" en el perfil del usuario.
* Completar el formulario y realizar el pago a través de la plataforma externa.
* Se recibirá un código de activación que deberá introducirse en el perfil para activar las funcionalidades Prémium.

## 4. Requisitos Previos

Para utilizar SalCooking, los usuarios necesitarán cumplir con los siguientes requisitos básicos:

* **Dispositivo:** Un ordenador personal (de sobremesa o portátil), tableta o teléfono inteligente (*smartphone*) con capacidad para navegar por internet.
* **Conexión a Internet:** Se requiere una conexión a internet estable para acceder a la aplicación web y todas sus funcionalidades, ya que SalCooking opera como un servicio en línea.
* **Navegador Web:** Un navegador web moderno y actualizado. Se recomienda el uso de las últimas versiones de Google Chrome, Mozilla Firefox, Safari o Microsoft Edge para una experiencia óptima.
* **Entorno de Ejecución (para despliegue local/desarrollo):** Para aquellos usuarios o administradores que necesiten instalar o gestionar una instancia local de SalCooking (por ejemplo, para desarrollo o pruebas), se requerirá un entorno compatible con XAMPP, MariaDB (o MySQL) y PHP 8.4 o superior.
* **Registro de Usuario:** Para acceder a las funciones personalizadas y guardar información, los usuarios deben completar un proceso de registro creando una cuenta con un nombre de usuario y contraseña.

## 5. Primeros Pasos

### 5.1. Acceso a la Aplicación

Para comenzar a utilizar SalCooking, el usuario debe:

1.  Abrir su navegador web preferido.
2.  Ingresar la dirección URL de SalCooking en la barra de direcciones (ej: `http://localhost/index.php` para un entorno local, o la dirección del dominio público `https://salcooking.free.nf/`).
3.  Explorar la página de inicio para obtener una visión general de la aplicación.

### 5.2. Registro de un Nuevo Usuario

Para aprovechar muchas más funcionalidades de SalCooking, se recomienda crear una cuenta:

1.  En la página de inicio o en el menú de navegación, buscar y seleccionar la opción "**Registrarse**" o "**Crear Cuenta**".
2.  Completar el formulario de registro proporcionando la información solicitada (nombre, dirección de correo electrónico, contraseña). Es importante elegir una contraseña segura.
3.  Aceptar los términos y condiciones del servicio.
4.  Hacer clic en el botón de registro. Es posible que se requiera una verificación por correo electrónico.

### 5.3. Inicio de Sesión

Una vez registrado, el usuario puede iniciar sesión:

1.  Buscar y seleccionar la opción "**Iniciar Sesión**" o "**Login**".
2.  Ingresar el correo electrónico y la contraseña utilizados durante el registro.
3.  Hacer clic en el botón de inicio de sesión.
4.  Existe la posibilidad de que el sistema recuerde al usuario sin necesidad de iniciar sesión cada vez.
5.  También desde esta página se puede recuperar la contraseña si se ha olvidado.

### 5.4. Gestión del Perfil de Usuario

Una vez iniciada la sesión, el usuario puede acceder a la sección de "**Perfil**" o "**Ajustes de Perfil**" para:

* Completar o modificar datos personales: Nombre, edad, sexo, etc.
* Configurar condiciones de salud (si es usuario Prémium): Seleccionar alergias (ej: gluten, frutos secos, pescado), intolerancias y enfermedades (ej: colesterol, diabetes) de una lista predefinida o añadir nuevas si el sistema lo permite. Esta información es crucial para la personalización de recetas y dietas.
* Establecer preferencias alimentarias: Indicar gustos, aversiones o tipos de cocina preferidos.
* Gestionar la suscripción (para usuarios Prémium): Consultar el estado de la suscripción, opciones de pago y renovaciones.
* Cambiar contraseña.

### 5.5. Búsqueda y Selección de Recetas (Funcionalidad detallada)

La sección de "**Recetas**" permite\*:

* **Navegar por categorías:** Explorar recetas por tipo de plato (desayunos, almuerzos, cenas, postres), ingredientes principales, etc.
* **Utilizar filtros avanzados:** Afinar la búsqueda aplicando filtros por tiempo de preparación, número de raciones, dificultad y, lo más importante, por las condiciones de salud especificadas en el perfil activo.
* **Ver detalles de la receta:** Al seleccionar una receta, se muestra información completa incluyendo ingredientes, cantidades, instrucciones de elaboración paso a paso, información nutricional (si está disponible), tiempo estimado y posibles sustitutos de ingredientes para adaptarse a diferentes necesidades. También se puede descargar la ficha de la receta.

*\*No todos los usuarios pueden acceder a todas las funcionalidades; consultar: [3. Niveles de Acceso](#3-niveles-de-acceso).*

### 5.6. Planificación de Dietas Semanales (Funcionalidad detallada)

Esta es una de las funcionalidades estrella de SalCooking (beneficio exclusivo para usuarios Prémium):

1.  Acceder a la sección "**Dietas**" o "**Planificador Semanal**".
2.  Si no se ha iniciado sesión, el sistema redirigirá a la ventana de inicio de sesión (*login*).
3.  Seleccionar "**Generar nueva dieta**" (basada en las preferencias y restricciones del perfil activo).
4.  Revisar la dieta generada. Se pueden desglosar los platos por franjas horarias.
5.  La dieta se guarda y se puede consultar cuando sea necesario.
6.  Se pueden generar hasta cuatro dietas distintas, identificables por un número y la fecha de creación.

### 5.7. Generación de la Lista de la Compra (Funcionalidad detallada)

Esta función, junto con la clasificación de recetas por enfermedades, es una de las más útiles y originales, muy desconocida en otras aplicaciones similares.
El sistema se encarga no solo de sumar las cantidades de cada ingrediente en las diferentes recetas, sino de unificar en una unidad de medida (dependiendo de si son productos líquidos o sólidos) teniendo en cuenta factores de conversión, debido, como es sabido, a las innumerables medidas que se usan en un recetario (más allá de gramos o litros, existen tazas, pizcas, cucharas, etc.).

Una vez que se ha definido una dieta semanal:

1.  Desde la sección de la dieta guardada, buscar la opción "**Generar Lista de la Compra**".
2.  El sistema compilará automáticamente todos los ingredientes necesarios para las recetas incluidas en el plan, agrupándolos y mostrando las cantidades totales.
3.  La lista de la compra se puede visualizar en pantalla, descargar en formato PDF o imprimir.

## 6. Ayuda, Soporte, Contacto y Gestiones

Si el usuario encuentra alguna dificultad o tiene preguntas sobre el funcionamiento, SalCooking ofrece diferentes lugares y formas para resolverlos:

* **Sección de Ayuda/FAQ:** Incluye una sección dentro de la aplicación con respuestas a las preguntas más frecuentes.
* **Formulario de Contacto:** Se proporciona un formulario de contacto o una dirección de correo electrónico para que los usuarios puedan enviar sus consultas al equipo de soporte de SalCooking.
* **Gestiones más comunes:** En los mismos formularios es donde se solicita una cuenta Prémium, se expresa el deseo de cancelarla, se solicita un registro, etc.
* **Tutoriales:** Próximamente se crearán pequeños tutoriales en vídeo o guías paso a paso para las funcionalidades más complejas.

## 7. Gestión Periódica del Sistema (Orientada al Usuario)

### 7.1. Usuario Final

Desde la perspectiva del usuario final, SalCooking está diseñado para requerir una gestión mínima. Sin embargo, se recomiendan algunas acciones periódicas para mantener una buena experiencia:

* **Revisión y Actualización de Perfiles:** Es aconsejable que el usuario revise periódicamente la información de sus perfiles (alergias, intolerancias, enfermedades, preferencias). Las necesidades y condiciones de salud pueden cambiar con el tiempo, y mantener esta información actualizada es crucial para que SalCooking siga ofreciendo recomendaciones precisas y seguras.
* **Exploración de Nuevas Recetas y Contenido:** La base de datos de recetas y el contenido del blog pueden actualizarse con nuevas incorporaciones. Se anima a los usuarios a explorar la aplicación regularmente para descubrir nuevas opciones y consejos.
* **Gestión de la Suscripción (Usuarios Prémium):** Los usuarios con suscripciones de pago deben estar atentos a las fechas de renovación y a los métodos de pago para asegurar un acceso ininterrumpido a las funcionalidades Prémium.
* **Actualización del Navegador Web:** Mantener el navegador web actualizado a su última versión no solo mejora la seguridad, sino que también asegura la compatibilidad con las tecnologías web utilizadas por SalCooking.
* **Limpieza de Caché y Cookies (Ocasional):** En caso de experimentar problemas de visualización o funcionamiento anómalo, limpiar la caché y las *cookies* del navegador para el sitio de SalCooking puede resolver estos inconvenientes.
* **Seguridad de la Contraseña:** Se recomienda cambiar la contraseña periódicamente y utilizar contraseñas fuertes y únicas para proteger la cuenta.

### 7.2. Administradores del Sistema

Para los administradores de una instancia de SalCooking, la gestión periódica incluiría tareas más técnicas como:

* **Copias de seguridad periódicas de la base de datos:** Fundamental para prevenir la pérdida de datos.
* **Revisión de los registros (*logs*) del servidor:** Para detectar y solucionar posibles errores o actividades sospechosas.
* **Actualización del software del servidor:** Mantener actualizados PHP, MariaDB, Apache y el propio sistema operativo del servidor.
* **Ampliación de la base de datos:** Añadir nuevas recetas, ingredientes, condiciones médicas y contenido al blog según se detecten nuevas necesidades o se planifiquen expansiones del contenido.
* **Monitorización del rendimiento:** Asegurar que la aplicación funciona de manera fluida y eficiente.

## 8. Consideraciones de Seguridad y Privacidad

SalCooking se compromete a proteger la información personal y de salud de sus usuarios. Se recomienda a los usuarios:

* No compartir sus credenciales de acceso (usuario y contraseña).
* Cerrar sesión al finalizar el uso de la aplicación, especialmente en dispositivos compartidos.
* Revisar la política de privacidad de SalCooking para entender cómo se gestionan sus datos.

## 9. Contacto y Soporte

Si se necesita ayuda adicional o se desean enviar comentarios, es posible ponerse en contacto con el equipo de SalCooking a través de:

* **Formulario de contacto:** `https://salcooking.free.nf/contacto.php`
* **Correo electrónico:** `soporte@salcooking.free.nf`

---

Este manual está diseñado para ayudar a aprovechar al máximo todas las funcionalidades que ofrece SalCooking. Si tiene sugerencias o necesita asistencia adicional, no dude en contactar al equipo de soporte.