<!-- modificar -->

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
     <span class="navbar-text">
            <a class="navbar-brand" href=<?php echo FRONT_ROOT?>><strong>Movie</strong>Pass</a>
     </span>
     
     <ul class="navbar-nav ml-auto">
          
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>Movie/showMovies">Cartelera</a>
          </li>
          <!-- <li class="nav-item">
               <a class="nav-link" href="<?php //echo FRONT_ROOT?>Purchase/showCart">Carrito</a>
          </li> -->
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>Purchase/purchaseStep1">Comprar tickets</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>User/userProfile">Perfil (<?php echo $_SESSION["loggedUser"]->getUserName() ?>)</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>Ticket/showTickets">Mis Tickets</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>User/logOut" onclick="return confirm('¿Está seguro que desea cerrar sesión?');">Cerrar Sesión</a>
          </li>
     </ul>
</nav>
<script>
     $(function(){
    $('a#<?php echo FRONT_ROOT?>User/logOut').click(function(){
        if(confirm('¿Está seguro que desea cerrar sesión?')) {
            return true;
        }

        return false;
    });
});
</script>

