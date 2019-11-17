<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
     </button>
     <a class="navbar-brand" href="<?php echo FRONT_ROOT ?>" id="fuente-nav">
          <img src="<?php echo FRONT_ROOT; ?>Views/img/popcornnav.png" width="30" height="30" class="d-inline-block align-top" alt="">
          Movie<font color="red">Pass</font>
     </a>

     <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
               <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>Movie/showMovies">Cartelera</a>
               </li>
               <li class="nav-item">
               </li>
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Ingresar
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                         <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>User/signUpForm"><i class="fas fa-user-plus"></i> Registrarse</a>
                         <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>User/logInForm"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
                    </div>
               </li>
          </ul>
     </div>
</nav>