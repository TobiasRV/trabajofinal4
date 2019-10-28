<?php
include_once(VIEWS_PATH . "header.php");
include_once(VIEWS_PATH . "nav.php");
?>

<div class="container">
  <h2 class="mb-4">Crear Cine</h2>
  <form action="<?php echo FRONT_ROOT ?>/Cinema/addCinema" method="post">
    <div class="form-group">
      <label for="name">Nombre</label>
      <input id="name" name="name" placeholder="Nombre del Cine" type="text" required="required" class="form-control">
    </div>
    <div class="form-group">
      <label for="address">Dirección</label>
      <input id="address" name="address" placeholder="Direccion del Cine" type="text" required="required" class="form-control">
    </div>
    <div class="form-group">
      <label for="seats">Nº Asientos</label>
      <input id="seats" name="seats" placeholder="Cantidad de Asientos" type="number" required="required" min="0" max="200" class="form-control">
    </div>
    <div class="form-group">
      <label for="price">Precio</label>
      <input id="price" name="price" placeholder="Precio de la Entrada" type="number" required="required" min="0" max="500" class="form-control">
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
              <th scope="col"><input type="checkbox" name="moviechecked[]" value="<?php echo $val->getTitle();?>" /></th>
              <th scope="row"><?php echo $val->getIdMovie(); ?></th>
              <td><?php echo $val->getTitle(); ?></td>
              <td>
               
              </td>
            </tr>
        </tbody>
      <?php }  ?>
      </table>

    </div>
    <div class="form-group">
      <button name="submit" type="submit" class="btn btn-primary">Cargar</button>
    </div>
  </form>
</div>
<?php include_once(VIEWS_PATH . "footer.php");?>