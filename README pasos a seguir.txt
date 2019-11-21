Lista de pasos para que el programa salga andando:

0-En la carpeta del trabajo hay 2 archivos.ini, php.ini lo reemplazas en xampp\php y sendmail.ini en xampp\sendmail. (estos archivos permiten que mande el mail al comprar un ticket)

1-Copiamos todo el contenido del archivo data\moviepassDB.sql en nuestro workbench.

2-Chequeamos que no haya otra DB llamada Moviepass, en caso de haberla la eliminamos.

3-Ejecutamos el script de la workbench hasta los store procedures inclusive.

4-Ejecutamos los 2 inserts que se encuentras mas abajo en el script, este creara 2 usuarios, un administrador y un cliente.

5-Chequeamos que todas las controladoras usen base de datos, para hacer eso revisamos al principio de cada controller que los use DAO que no esten comentados sean los que solo dicen DAO, los DAOJson deben permanecer comentados(a no ser que quieras usar json pero eso para otro vidio).

6-Nos logeamos en la pagina con el usuario administrador User: "juanludu" Pass: "1234".

7-Al logearnos se cargara automaticamente la base de datos con: peliculas, generos, y peliculasXgeneros. Podes chequear si la carga anduvo usando un select.

8-Creamos un cine.

9-Aca podes crearle una funcion a una sala del cine ya creado para asi comprarla y poder probar el resto de la aplicacion.

10- Felicidades! Ya podes romper el codigo con tranquilidad.