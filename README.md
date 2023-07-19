# doc24
Para ejecutar este proyecto es necesario utilizar apache o cualquier otro servicio puede usar el paquete XAMP
Guardarlo en htdoc
y enviar un post con los datos:
url: localhost:8000/api.php/update-persona/id/brand
Datos de la persona (en el body de la solicitud)
nombre, apellido, edad, telefono

En la cabecera el Token (existe una funcion para obtener uno. Tambien con post enviando
cliente_id y secret_id a la direccion localhost:8000/api.php?route=login)

Y recuerde que debe configurar los datos de la BD en config.ini



