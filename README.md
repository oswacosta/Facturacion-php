# 🧾 Sistema de Facturación PHP

Este proyecto es un sistema web de facturación de ventas desarrollado en PHP, MySQL, HTML, CSS y JavaScript. Permite gestionar clientes, productos y generar facturas de manera dinámica y eficiente.

---

## 📌 Funcionalidades

- Gestión de clientes
- Gestión de productos y stock
- Creación y visualización de facturas
- Cálculo automático de totales
- Almacenamiento persistente con MySQL
- Interfaz web amigable (HTML, CSS, JS)
- Control de stock al facturar

---

## 🛠️ Tecnologías utilizadas

- **PHP** – Lenguaje principal del lado del servidor
- **MySQL** – Base de datos relacional
- **HTML/CSS** – Estructura y estilos de la interfaz
- **JavaScript** – Lógica del cliente (dinamismo en formularios)
- **XAMPP** – Entorno local de desarrollo

---

## 🗃️ Estructura del proyecto

📁 src
│
├── 📁 clientes/ # Módulos para CRUD de clientes
├── 📁 productos/ # Módulos para CRUD de productos
├── 📁 facturas/ # Creación y detalles de facturas
├── 📁 sql/
│ └── informatic.sql # Base de datos para importar
├── index.php
├── procesar_factura_venta.php
└── README.md


---

## 💾 Base de datos

El archivo SQL necesario para importar la base de datos se encuentra en:

/sql/informatic.sql


Puedes importarlo desde **phpMyAdmin** o usando la consola MySQL:

```bash
mysql -u root -p informatic < sql/informatic.sql


🚀 Cómo ejecutar el proyecto
Clona el repositorio:

git clone https://github.com/oswacosta/facturacion-php.git

Coloca la carpeta en C:/xampp/htdocs/.

Importa el archivo informatic.sql en phpMyAdmin.

Inicia Apache y MySQL desde XAMPP.

Abre en tu navegador: http://localhost/facturacion-php/src/

👤 Autor
Nombre: Oswaldo Acosta

GitHub: @oswacosta
