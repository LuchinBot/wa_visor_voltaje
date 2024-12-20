# Monitor de Voltaje

Este proyecto permite monitorear el voltaje en tiempo real desde dispositivos conectados, mostrando los datos en un gráfico dinámico. Además, permite realizar consultas para obtener información histórica sobre los voltajes registrados.

## Requisitos Previos

Asegúrate de tener instalado lo siguiente:

- PHP: Para manejar el backend del proyecto.
- Node.js y npm: Para instalar las dependencias de JavaScript.
- Composer: Para gestionar las dependencias de PHP.
- Firebase: Se utiliza para almacenar y recuperar datos de voltaje.

## Instalación y Configuración

### 1. Dependencias

composer install
npm install

### 2. Firebase

Crea una carpeta y coloca ahí tus credenciales en formato JSON:

- storage/firebase/credential_firebase.json

### 3. Adicionales

- Instalar PHP 8.2.26: https://windows.php.net/download
- Descargar y habilitar Cacert en php.ini: https://curl.se/docs/caextract.html

Asegúrate de agregar la siguiente línea en tu archivo php.ini:

curl.cainfo = "C:\laragon\bin\php\php-8.2.26-nts-Win32-vs16-x64\cacert.pem"

---

Notas Finales

- Asegúrate de que todas las rutas y versiones sean correctas según tu entorno de desarrollo.
- Considera agregar ejemplos de uso o una sección de "Cómo Contribuir" si planeas que otros colaboren en tu proyecto.
