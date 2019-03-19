<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle avigation"><span class="navbar-toggler-icon"></span></button>
  <a class="navbar-brand" href="index.php">ASSOCIAZIONE CULTURALE "G.B.LAMPI"</a>
  <a class="toggleMenu toggleDesktop d-lg-none" href="#"><i class="fas fa-bars"></i></a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">associazione</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item tip" href="storia.php" title="Un interessante racconto su come è nata la nostra associazione" data-placement="left">la storia</a>
          <a class="dropdown-item tip" href="nome.php" title="Scopri chi era Giovan Battista Lampi" data-placement="left">il nome</a>
          <a class="dropdown-item tip" href="#" title="Leggi lo statuto dell'associazione" data-placement="left"><del>lo statuto</del></a>
          <a class="dropdown-item tip" href="organigramma.php" title="Il consiglio direttivo nel corso degli anni" data-placement="left">organigramma</a>
          <a class="dropdown-item tip" href="amministrazione.php" title="amministrazione trasparente" data-placement="left">amministrazione trasparente</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">attività</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item tip" href="#" data-placement="left" title="leggi i post scritti dai nostri soci"><del>articoli</del></a>
          <a class="dropdown-item tip" href="#" data-placement="left" title="mostre, seminari, conferenze, presentazioni e altro ancora"><del>eventi</del></a>
          <a class="dropdown-item tip" href="#" data-placement="left" title="parti con noi"><del>viaggi</del></a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link tip" href="#" data-placement="bottom" title="scopri, leggi o scarica le nostre pubblicazioni"><del>pubblicazioni</del></a>
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
        <a class="nav-link p-2" href="login.php"><i class="fas fa-sign-in-alt"></i> <span class="d-inline-block d-lg-none">login</span></a>
      </li>
      <?php }else{ ?>
      <li class="nav-item d-none d-lg-inline-block">
        <a class="nav-link toggleMenu toggleDesktop p-2" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>

<?php if (isset($_SESSION['id'])) {?>
<div class="usrMenu bg-white closed animation pb-3">
  <div class="menuList">
    <p class="m-0 p-3 bg-light text-muted border-top"><i class='fas fa-user fa-fw'></i> profilo utente</p>
    <ul>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="aggiorna i tuoi dati personali"><span class='animation'>></span> modifica dati</a>
      </li>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="modifica la tua password [ricordati di farlo regolarmente!]"><span class='animation'>></span> modifica password</a>
      </li>
    </ul>
    <p class="m-0 p-3 bg-light text-muted border-top"><i class="fas fa-sitemap"></i> sezioni del sito</p>
    <ul>
      <li>
        <a href="post.php" class="text-dark animation tip" data-placement="left" title="gestisci post"><span class='animation'>></span> post</a>
      </li>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="gestisci eventi"><span class='animation'>></span> eventi</a>
      </li>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="gestisci viaggi"><span class='animation'>></span> viaggi</a>
      </li>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="gestisci pubblicazioni"><span class='animation'>></span> bibliografia</a>
      </li>
      <?php if ($_SESSION['classe']===2) {?>
      <li>
        <a href="rubrica.php" class="text-dark animation border-bottom tip" data-placement="left" title="gestisci rubrica"><span class='animation'>></span> rubrica</a>
      </li>
      <?php } ?>
    </ul>
    <p class="m-0 p-3 bg-light text-muted border-top"><i class="fas fa-tools fa-fw"></i> funzioni di sistema</p>
    <ul>
      <?php if ($_SESSION['classe']===2) {?>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="visualizza e gestisci gli utenti presenti nel database"><span class='animation'>></span> utenti</a>
      </li>
      <li>
        <a href="#" class="text-dark animation tip" data-placement="left" title="modifica o elimina una tag esistente"><span class='animation'>></span> tag</a>
      </li>
      <li>
        <a href="link.php" class="text-dark animation tip" data-placement="left" title="gestisci i link consigliati"><span class='animation'>></span> link consigliati</a>
      </li>
      <?php } ?>
      <li>
        <a href="logout.php" class="text-dark animation tip" data-placement="left" title="termina sessione di lavoro ed esci dall'area riservata"><span class='animation'>></span> logout</a>
      </li>
    </ul>
  </div>
</div>
<?php } ?>
