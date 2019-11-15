<body class="home">

<?php 

require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");

?>
        <body>

  <div class="container">
    <h2 class="mb-4">Crear Cine</h2>
    <form action="<?php echo FRONT_ROOT ?>Cinema/addCinema" method="post">
      <div class="form-group">
        <label for="name">Nombre</label>
        <input class="form-control" type="text" id="name" name="name" placeholder="Nombre del Cine" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
      </div>
      <div class="form-group">
        <label for="address">Dirección</label>
        <input class="form-control" type="text" id="address" name="address" placeholder="Direccion del Cine" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
      </div>
      <div class="form-group">
        <label for="seats">Nº Asientos</label>
        <input id="seats" name="seats" placeholder="Cantidad de Asientos" type="number" required="required" class="form-control" min=1 max=50 title="Solo números entre 1 y 50">
      </div>
      <div class="form-group">
        <label for="price">Precio</label>
        <input id="price" name="price" placeholder="Valor de la Entrada" type="number" required="required" class="form-control" min=1 max=3000 title="Solo números entre 1 y 3000">
      </div>
      <div class="form-group">
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th scope="col">Id</th>
              <th scope="col">Nombre</th>
              <th scope="col">Generos</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($nowPlaying as $val) {  ?>
              <tr>
                <th scope="col"><input type="checkbox" name="moviechecked[]" value="<?php echo $val->getTitle(); ?>" /></th>
                <th scope="row"><?php echo $val->getIdMovie(); ?></th>
                <td><?php echo $val->getTitle(); ?></td>
                <td><?php
                      $generosPelicula = $val->getIdGenre();
                      foreach ($generosPelicula as $genero) {
                        foreach ($arrayGeneros as $gen) {
                          if ($gen->getId() == $genero) {
                            echo $gen->getName() . "<br>";
                          }
                        }
                      }
                      ?>
                </td>
              </tr>
          </tbody>
        <?php }  ?>
        </table>

      </div>

      <div class="form-group">
        <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Cargar</button>
      </div>
    </form>
  </div>
  <?php include_once(VIEWS_PATH . "footer.php"); ?>
    
    <?php } else {
        if ($_SESSION["loggedUser"]->getPermissions() == 2) {
            include_once(VIEWS_PATH . "index.php");
        }
    }
} else {
            include_once(VIEWS_PATH . "index.php");
}


?>


