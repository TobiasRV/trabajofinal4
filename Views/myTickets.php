<body class="home">

<?php 

if ($userControl->checkSession() != false) 
{
    if ($_SESSION["loggedUser"]->getPermissions() == 2) 
    {
        include_once(VIEWS_PATH . "header.php");
        include_once(VIEWS_PATH . "navClient.php"); 
    }
}
?>


<html>
<h2 class="card-header info-color white-text text-center py-4">
    <strong>MIS TICKETS</strong>
</h2>
    <div class="container fluid p-0">
        <div class="row mt-3">
            <form class="form-inline" action="<?php echo FRONT_ROOT ?>Ticket/showTickets" method="POST">
                <div class="form-group">
                <label for="movie">Película:  </label>
                <select style="width:170px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" >
                            <option value="" disabled selected>Filtrar por película</option>
                            <?php foreach ($listadoM as $movie) { ?>
                                <option value=<?php echo $movie->getIdMovie(); ?> data-tokens="<?php echo $movie->getTitle(); ?>"><?php echo $movie->getTitle(); ?></option>
                            <?php } ?>
                        </select>
                </div>

                <div class="form-group"> 
                    <label for="date">Fecha:  </label>
                    <input class="form-control" id="date" name="date" placeholder="DD / MM / YYYY" type="text"/>
                </div>

                <br><button style="width:100%" class="btn btn-lg btn-secondary" type="submit">Filtrar</button>
            </form>
    </div>
    <table class="table table-striped table-dark">
        <tbody>
                <tr>
                    <th scope="row">ID Compra</th>
                
                    <th scope="row">Ticket N°</th>
                </tr>
                <?php
                    if($listadoT != null) 
                    {
                        if(is_array($listadoT))
                        {
                            foreach($listadoT as $t)
                            {
                        ?>
                            <tr>
                                <td><?php echo $t->getIdPurchase(); ?></td>
                                <td><?php echo $t->getIdTicket(); ?></td>
                            </tr>
                        <?php
                            }
                        }
                        else
                        {
                            ?>
                            <tr>
                                <td><?php echo $listadoT->getIdPurchase(); ?></td>
                                <td><?php echo $listadoT->getIdTicket(); ?></td>
                            </tr>
                            <?php
                        }
                    }
                        ?>
        </tbody>
    </table>

    <script>
        $(function() {
        $('.selectpicker').selectpicker();
        });
    </script>

    <script>
        $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options);
        })
    </script>



    <?php 
        include_once(VIEWS_PATH . "footer.php"); 
    ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>



</html>