## Temática del TPE
concesionaria de autos

## Descripción
Este TPE consiste en gestionar información de vehículos, tanto nuevos como usados.  
Se planteó una base de datos que permite:  
- Registrar vehículos y sus características.  
- Consultar detalles sobre el vehículo.  
- Registrar marca de vehículo.  
- Consultar detalles sobre la marca.  

El objetivo es poder organizar y acceder fácilmente a la información de los vehículos según diferentes criterios, usando relaciones entre tablas.

## Cómo desplegar el sitio
Instrucciones para importar la base de datos en **PHPMyAdmin**:

1. Abre **phpMyAdmin** en tu navegador.  
2. Crea una nueva base de datos llamada `db_concesionaria`.  
3. Selecciona la base de datos `db_concesionaria`.  
4. Haz clic en la pestaña **Importar**.  
5. Haz clic en **Seleccionar archivo** y elige el archivo `database/db_concesionaria.sql` de este proyecto.  
6. Presiona **Continuar** para importar las tablas y datos.

## Manejo de sesiones
- **Usuario:** `webadmin`  
- **Contraseña:** `webadmin`

## Manejo de URLs
- [http://localhost/tpeweb2/concesionaria](http://localhost/tpeweb2/concesionaria) → muestra tanto vehículos como marcas  
- [http://localhost/tpeweb2/vehiculos](http://localhost/tpeweb2/vehiculos) → muestra solo vehículos  
- [http://localhost/tpeweb2/marcas](http://localhost/tpeweb2/marcas) → muestra solo las marcas  
- [http://localhost/tpeweb2/login](http://localhost/tpeweb2/login) → muestra formulario de inicio de sesión
