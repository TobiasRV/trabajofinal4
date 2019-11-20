


<html>
<h1 align="center">MIS TICKETS</h1>
<body class="home">
            <form class="form-inline" action="<?php echo FRONT_ROOT ?>Ticket/searchTickets" method="POST">
            <label for="date">Fecha de Compra:  </label>
                    <input class="form-control" style="width:1349px" id="date" name="date"  placeholder="DD / MM / YYYY" type="text"/>
                <label for="movie">Película:  </label>
                <select style="width:170px" class="form-control selectpicker" data-live-search="true" id="movie" name="movie" >
                            <option value="" disabled selected>Filtrar por película</option>
                            <?php foreach ($listadoM as $movie) { ?>
                                <option value=<?php echo $movie->getIdMovie(); ?> data-tokens="<?php echo $movie->getTitle(); ?>"><?php echo $movie->getTitle(); ?></option>
                            <?php } ?>
                        </select>

                <br><br><button style="width:100%" class="btn btn-lg btn-secondary" type="submit">Filtrar</button>
            </form>

    <table class="table table-hover table-condensed table-bordered table-dark">
        <tbody>
                <tr>
                    <th scope="row">ID Compra</th>
                    
                    <th scope="row">Ticket N°</th>

                    <th scope="row">Codigo Qr</th>
                    
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
                                <td><img src="https://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=<?php echo $t->getIdTicket(); ?>&choe=UTF-8"></td>
                                
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
                                <td><?php QRcode::png("a");?></td>
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