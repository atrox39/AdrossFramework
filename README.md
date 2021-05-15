# Custom minimalist php Framework
[Ignorar esto: Numero 27]

Bienvenido al Framework en su version 1.0

Adross Framework no es mas que una serie de herramientas minimalistas para la creación, administración tanto de bases de datos
como de plantillas y rutas.

Si bien este framework es sumamente minimalista se espera que el usuario pueda contar con herramientas precisas para las tareas simples
como lo son:

- Plantillas (en desarrollo pero casi funcional)
- Vistas
- Rutas
- Modelos

Su utilidad actual cuenta con Vistas, Rutas y plantillas.

La estructura principal de un proyecto con este framework es la siguiente:

- lib
    - Adross
        - App.class.php
        - Config.class.php
        - Database.class.php
        - Route.class.php
        - Router.class.php
        - Schema.class.php
        - Template.class.php
- models
    - Base.model.php
- public
- routes
- views
    - templates
        - main.html
- autoload.class.php
- config.json
- manage.php
- index.php

Con esta estructura el framework funciona correctamente, y si es eliminado algun archivo este no funcinara de manera correcta.

Como usarlo:

### Paso 1

Modificar el archivo - views/templates/main.html

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title><?= isset($title) ? $title : "Adross Framework" ?></title>
</head>
<body>
    <?= $body ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js" integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
```
Inicialmente viene con esta estructura, pero puede cambiarse ya que se utiliza boostrap 4 y jquery para el frontend en esta plantilla.

Tambien se pueden observar un par de variables:
- $body
- $title

$body es enviada a traves de - lib/Adross/App.class.php - Por el metodo Render el cual le enviara la vista seleccionada

$title es enviada a traves de - lib/Adross/Router.class.php - Por el metodo get() el cual recibe 2 parametros: la ruta y una funcion con los parametros $req, $res
$res es quien contiene la funcion render la cual nos permite enviar el nombre de la vista y un contexto;

```
$app->router->get('/about', function($req, $res){ // Primer parametro la ruta, segundo parametro la funcion
    $res->render('about', ["title"=>"About"]); // Render permite mostrar una vista y envia el contexto en modo array en este caso la variable Titulo con el texto About
});
```

### Paso 2

Configurar config.json

```
{
    "debug":"true",
    "database_deploy":{
        "host":"localhost",
        "user":"root",
        "password":"",
        "database":"nombrebasedatos"
    },
    "database_dev":{
        "host":"localhost",
        "user":"root",
        "password":"",
        "database":"nombrebasedatos"
    },
    "main_template":"templates/main.html"
}
```

El archivo de config.json esta originalmente de esta forma, puedes alterar la ruta de main_template por otra template principal.

### Paso 3

Creamos una vista llamada index.html en la carpeta views

```
<h1>Vista index</h1>
```

### Paso 4
Para la estructura principal de un proyecto es necesario que el archivo index.php tenga una estructura como esta:

```
<?php
include_once('autoload.class.php');
use Adross\App;

// TODO

// Routes
$app->router->get('/', function($req, $res){
    $res->render('index');
});

$app->Check(); // Verifica las rutas, es necesario ejecutar esta funcion siempre al finalizar todas las rutas.
?>
```
Felicidades, primera pagina creada con AdrossFramework

ahora para visualizar accedemos desde la consola CMD a la carpeta de nuestro proyecto y escribimos

```
php -S localhost:8000
```

y listo tenemos nuestro proyecto.

A programar!!!

# Ejemplo de modelo

```
<?php
namespace Models;
use Adross\Schema;

// Use this model for examples

class Base extends Schema
{
    public function __construct($force=false)
    {
        parent::__construct();
        $this->schemaname = "tb_posts";
        $this->columns =
        [
            [
                "name"=>"title",
                "type"=>"VARCHAR",
                "size"=>30
            ],
            [
                "name"=>"description",
                "type"=>"TEXT",
            ],
            [
                "name"=>"user",
                "type"=>"INTEGER",
                "attrib"=>"UNSIGNED"
            ],
            [
                "name"=>"timestamp",
                "type"=>"TIMESTAMP",
            ],
        ];
        
        /*$this->foreigns = [[
            "foreign"=>[
                "model_schema_name"=> $this->table_prefix.'tablename',
                "relation_name"=>"SAMPLE",
                "root"=>"user",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]];*/
        $this->start($force);
    }
}
```

Como podemos observar esta es la base de todo modelo en el framework.

Cuenta con nombre_clase.model.php como estructura.

Se añadieron los archivos Procfile y composer.json para que el framework sea compatible con heroku, tambien es necesario recalcar el uso de .htaccess redireccionando a index constantemente.