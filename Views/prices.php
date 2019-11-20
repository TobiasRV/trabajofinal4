<body class="home">

<html>
    <h1 align="center">TARIFAS</h1><br>

<?php
    foreach($listadoMT as $movieTheater)
    {
?>
    <div id="MainMenu">
        <div class="list-group panel">
            <a href="#why" align="center" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"><?php echo strtoupper($movieTheater->getName()); ?></a>
            <div class="collapse" id="why">
            <?php
                foreach($listadoC as $cinema)
                {
                    if($cinema->getIdMovieTheater() == $movieTheater->getId())
                    {
            ?>
                        <a href="" align="center" class="list-group-item" data-toggle="collapse" data-parent="#SubMenu1"><?php echo $cinema->getName() . "  $ " . $cinema->getTicketPrice(); ?></a>
                    <?php
                    }
                }
                    ?>
            </div>
        </div>
    </div>
<?php
    }
?>

<style>
.list-group-item[aria-expanded="true"]
{
    background-color: lightgrey !important;
    border-color: #aed248;

}
</style>

</html>

<?php 

include_once(VIEWS_PATH . "footer.php"); 

?>