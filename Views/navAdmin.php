<!-- modificar -->

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
     <span class="navbar-text">
            <a class="navbar-brand" href=<?php echo FRONT_ROOT?>><strong>Movie</strong>Pass</a>
     </span>
     
     <ul class="navbar-nav ml-auto">
          
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>Movie/showMovies">Cartelera</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>Cinema/formAddCinema">Cargar Cine</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>Cinema/listCinemas">Listar Cines</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>User/userProfile">Perfil</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT?>User/logOut">Logout</a>
          </li>
     </ul>
</nav>