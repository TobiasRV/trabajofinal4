<body class="home">
    <div class="container">
        <h1>Crear Cine</h1>
        <form action="<?php echo FRONT_ROOT ?>MovieTheater/viewCreateMovieTheaterTwo" method="post">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Nombre del Cine" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input class="form-control" type="text" id="address" name="address" placeholder="Direccion del Cine" required pattern="[A-Za-z0-9 ]{1,40}" title="Solo letras o números (máximo 40 caracteres)">
            </div>

            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col col-lg-2">
                        <a class="btn btn-danger btn-block" href="<?php echo FRONT_ROOT; ?>" role="button">Cancelar</a>
                    </div>
                    <div class="col col-lg-4">
                        <button name="submit" type="submit" class="btn btn-primary btn-success btn-block">Continuar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <?php if ($msj != null) { ?>
        <script>
            swal({
                title: "Error!",
                text: "<?php echo $msj; ?>",
                icon: "warning",
            });
        </script>
    <?php } ?>

    <?php include_once(VIEWS_PATH . "footer.php");
