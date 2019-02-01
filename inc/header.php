<div class="mainHeader bg-white fixed-top shadow">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <a class="navbar-brand" href="index.php">ASSOCIAZIONE CULTURALE "G.B.LAMPI" - ALTA ANAUNIA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">associazione</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">la storia</a>
              <a class="dropdown-item" href="#">lo statuto</a>
              <a class="dropdown-item" href="#">il nome</a>
              <a class="dropdown-item" href="#">organigramma</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">attività</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">eventi</a>
              <a class="dropdown-item" href="#">incontri</a>
              <a class="dropdown-item" href="#">viaggi</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">pubblicazioni</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">centro studi</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Casa de Gentili</a>
              <a class="dropdown-item" href="#">progetti</a>
              <a class="dropdown-item" href="#">scopi della casa</a>
            </div>
          </li>
          <?php if(!isset($_SESSION['id'])){ ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> <span class="d-inline-block d-lg-none">login</span></a>
          </li>
          <?php }else{ ?>
          <li class="nav-item d-none d-xl-inline-block">
            <a class="nav-link toggleMenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="usrMenu bg-white closed animation pb-3">
  <div class="switchmenu toggleMenu cursor animation d-block d-xl-none border"> <i class="fas fa-plus"></i> </div>
  <div class="menuList">
    <p class="m-0 p-3 bg-light text-muted border-top"><i class='fas fa-user fa-fw'></i> dati personali</p>
    <ul>
      <li><a href="#" class="text-dark animation"><span class='animation'>></span> modifica dati</a></li>
      <li><a href="#" class="text-dark animation"><span class='animation'>></span> modifica password</a></li>
    </ul>
    <p class="m-0 p-3 bg-light text-muted border-top"><i class="fas fa-plus-square"> inserisci</i></p>
    <ul>
      <li><a href="#" class="text-dark animation"><span class='animation'>></span> post</a></li>
      <li><a href="#" class="text-dark animation"><span class='animation'>></span> evento</a></li>
      <li><a href="#" class="text-dark animation"><span class='animation'>></span> viaggio</a></li>
      <li><a href="#" class="text-dark animation"><span class='animation'>></span> bibliografia</a></li>
      <li><a href="#" class="text-dark animation border-bottom"><span class='animation'>></span> utente</a></li>
    </ul>
  </div>
</div>
