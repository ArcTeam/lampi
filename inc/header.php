<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle avigation"><span class="navbar-toggler-icon"></span></button>
  <a class="navbar-brand" href="index.php">ASSOCIAZIONE CULTURALE "G.B.LAMPI" - ALTA ANAUNIA</a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">associazione</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="storia.php">la storia</a>
          <a class="dropdown-item" href="nome.php">il nome</a>
          <a class="dropdown-item" href="#"><del>lo statuto</del></a>
          <a class="dropdown-item" href="#"><del>organigramma</del></a>
          <a class="dropdown-item" href="#"><del>bilancio annuale</del></a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">attività</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#"><del>eventi</del></a>
          <a class="dropdown-item" href="#"><del>incontri</del></a>
          <a class="dropdown-item" href="#"><del>viaggi</del></a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><del>pubblicazioni</del></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">centro studi</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#"><del>Casa de Gentili</del></a>
          <a class="dropdown-item" href="#"><del>progetti</del></a>
          <a class="dropdown-item" href="#"><del>scopi della casa</del></a>
        </div>
      </li>
      <?php if(!isset($_SESSION['id'])){ ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> <span class="d-inline-block d-lg-none">login</span></a>
      </li>
      <?php }else{ ?>
      <li class="nav-item d-none d-lg-inline-block">
        <a class="nav-link toggleMenu toggleDesktop" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>

<?php if (isset($_SESSION['id'])) {?>
<div class="usrMenu bg-white closed animation pb-3">
  <div class="switchmenu toggleMenu cursor animation d-block d-lg-none"></div>
  <div class="menuList">
    <p class="m-0 p-3 bg-light text-muted border-top"><i class='fas fa-user fa-fw'></i> profilo utente</p>
    <ul>
      <li>
        <a href="#" class="text-dark animation" title="aggiorna i tuoi dati personali">
          <span class='animation'>></span> modifica dati
        </a>
      </li>
      <li>
        <a href="#" class="text-dark animation" title="modifica la tua password [ricordati di farlo regolarmente!]">
          <span class='animation'>></span> modifica password
        </a>
      </li>
    </ul>
    <p class="m-0 p-3 bg-light text-muted border-top"><i class="fas fa-plus-square"></i> inserisci</p>
    <ul>
      <li>
        <a href="#" class="text-dark animation" title="aggiungi un nuovo post">
          <span class='animation'>></span> post
        </a>
      </li>
      <li>
        <a href="#" class="text-dark animation" title="aggiungi un nuovo evento">
          <span class='animation'>></span> evento
        </a>
      </li>
      <li>
        <a href="#" class="text-dark animation" title="aggiungi un nuovo viaggio">
          <span class='animation'>></span> viaggio
        </a>
      </li>
      <li>
        <a href="#" class="text-dark animation" title="aggiungi una nuova pubblicazione">
          <span class='animation'>></span> bibliografia
        </a>
      </li>
      <?php if ($_SESSION['classe']===2) {?>
      <li>
        <a href="#" class="text-dark animation border-bottom" title="aggiungi un nuovo utente">
          <span class='animation'>></span> utente
        </a>
      </li>
      <?php } ?>
    </ul>
    <p class="m-0 p-3 bg-light text-muted border-top"><i class="fas fa-tools fa-fw"></i> funzioni di sistema</p>
    <ul>
      <?php if ($_SESSION['classe']===2) {?>
      <li>
        <a href="#" class="text-dark animation border-bottom" title="visualizza e gestisci gli utenti presenti nel database">
          <span class='animation'>></span> utenti
        </a>
      </li>
      <li>
        <a href="#" class="text-dark animation border-bottom" title="modifica o elimina una tag esistente">
          <span class='animation'>></span> tag
        </a>
      </li>
      <?php } ?>
      <li>
        <a href="logout.php" class="text-dark animation" title="termina sessione di lavoro ed esci dall'area riservata">
          <span class='animation'>></span> logout
        </a>
      </li>
    </ul>
  </div>
</div>
<?php } ?>
