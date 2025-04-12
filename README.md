# SalCooking

**SalCooking** es una aplicación web diseñada para facilitar la planificación semanal de la alimentación, con menús equilibrados y personalizados, teniendo muy en cuenta la salud: sus alergias, intolerancias, y enfermedades, además de generar listas de la compra automáticas, todo ello desde una interfaz sencilla y adaptable a diferentes perfiles de usuario.

## 🧩 Características principales

- Búsqueda de recetas básica y avanzada
- Creación de perfiles personalizados
- Generación de dietas semanales
- Listado automático de la compra
- Blog de trucos de cocina
- Acceso segmentado por tipo de usuario (visitante, básico, prémium)

## 🔧 Tecnologías utilizadas

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 8.x
- **Base de datos:** MariaDB (vía HeidiSQL)
- **Entorno local:** XAMPP sobre Windows
- **Modelo de arquitectura:** MVC
- **Herramientas de prototipado:** Balsamiq, Draw.io

## 🚀 Cómo instalar el proyecto en local

1. Clona el repositorio:
    ```bash
    git clone https://github.com/tu-usuario/salcooking.git
    ```
    oscartechdevai@gmail.com 

2. Copia el contenido a la carpeta de tu servidor local:
    ```
    C:/xampp/htdocs/salcooking
    ```

3. Inicia Apache y MySQL desde XAMPP.

4. Crea la base de datos `salcooking` en HeidiSQL y ejecuta el script de creación desde `/sql/`.

5. Accede a la aplicación:
    ```
    http://localhost/salcooking/index.php?page=inicio
    ```

## 📁 Estructura del proyecto

```
salcooking/
├── controllers/        → Lógica de control por módulos
├── models/             → Acceso a la base de datos
├── views/              → Vistas HTML con integración PHP
├── styles/             → Hojas de estilo CSS
├── scripts/            → Scripts JavaScript (por añadir)
├── img/, pdf/, logos/  → Recursos estáticos
├── sql/                → Estructura e inserciones SQL
├── docs/               → Documentos del proyecto (memoria, arquitectura...)
├── index.php           → Enrutador principal con ?page=
├── README.md
└── .gitignore
```

## 🐧 Despliegue en Linux

Aunque el desarrollo se ha realizado en Windows, se contempla el despliegue en una máquina virtual Linux con stack LAMP, lo cual facilitará la futura migración a un servidor en la nube (la mayoría funcionan sobre Linux). Esto asegura compatibilidad, escalabilidad y cumplimiento de los módulos del ciclo formativo.

## 🔐 Requisitos

- PHP 8 o superior
- MariaDB 10+
- Apache 2.4+
- Navegador moderno (Chrome, Firefox, Edge)

## 📄 Licencia

Este proyecto está desarrollado como parte del TFG del ciclo DAW2 y su uso está destinado a fines educativos.
