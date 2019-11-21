<?php


require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "navAdmin.php");
?>

<body class="home">
    <div class="container">
        <h1>Modificar: <?php echo $cinema->getName(); ?></h1>
        <form action="<?php echo FRONT_ROOT ?>Cinema/modifyCinema" method="post">
            <input id="id" name="id" type="hidden" value="<?php echo $cinema->getId(); ?>">
            <div class="form-group">
                <label for="status">Estado</label><br>
                <input type="hidden" name="status" value="0">
                <input type="checkbox" name="status" value="1" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" data-width="100" <?php if ($cinema->getStatus() == 1) echo "checked"; ?>>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Nombre de la Sala" value="<?php echo $cinema->getName(); ?>" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
            </div>
            <div class="form-group">
                <label for="seats">Nº de Asientos</label>
                <input id="seats" name="seats" placeholder="Cantidad de Asientos" value="<?php echo $cinema->countSeats(); ?>" type="number" required="required" class="form-control" min=1 max=100 title="Solo números entre 1 y 100">
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input id="price" name="price" type="number" class="form-control" value="<?php echo $cinema->getTicketPrice(); ?>">
            </div>
            <input id="idMovieTheater" name="idMovieTheater" type="hidden" value="<?php echo $cinema->getIdMovieTheater(); ?>">
            <div class="row justify-content-md-center">
                <div class="col col-lg-2">
                    <a class="btn btn-danger btn-block" href="<?php echo FRONT_ROOT; ?>MovieTheater/listCinemas" role="button">Cancelar</a>
                </div>
                <div class="col col-lg-4">
                    <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Continuar</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>