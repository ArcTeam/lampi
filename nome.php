<?php
session_start();
require("class/function.php");
$bannerBg = randomBg();
?>
<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="bannerWrap position-fixed bg-white lozad" data-background-image="img/background/<?php echo $bannerBg; ?>">
      <div class="bannerTitle">
        <h1>L'origine del nome</h1>
      </div>
    </div>
    <div class="mainContent bg-white">
      <div class="container">
        <div class="row">
          <div class="col-md-5 imgLampi p-5">
            <img src="img/401px-Giovanni_Battista_Lampi_autoritratto_Innsbruck.jpg" alt="autoritratto" class="img-fluid rounded">
            <small>
              <a rel="nofollow" class="external free mr-3" href="http://www.tirolerportraits.it/de/Portraits-suchen.aspx?ctl00_ContentPlaceHolderHaupt_RadGrid1ChangePage=39" title="fonte primaria dell'immagine [link esterno]">Tirolerportraits</a>
              <a href="https://commons.wikimedia.org/w/index.php?curid=51392264" title="licenza di utilizzo [link esterno]">pubblico dominio</a>
            </small>
          </div>
          <div class="col-md-7 py-5">
            <h4>Il nome</h4>
            <p>Il nome dell'Associazione deriva da quello del famoso pittore <a href="https://it.wikipedia.org/wiki/Giovanni_Battista_Lampi" class="" title="Pagina di Wikipedia dedicata all'artista [link esterno]" target="_blank">Giovanni Battista Lampi</a>, nato a Romeno il 31 dicembre 1751 e morto a Vienna l'11 febbraio 1830.<br>Di seguito la scheda biografica di Roberto Pancheri, socio dell'Associazione e massimo esperto della figura del Lampi.</p>
            <hr>
            <p>In Val di Non si possono ammirare le opere giovanili del Lampi a:</p>
            <ul>
              <li>
                <a href="https://goo.gl/maps/Bn19MmFV9W22" target="_blank" title="Vedi su Google Maps [link esterno]"><i class="fas fa-map-marker-alt"></i></a>
                Sanzeno, Basilica dei Santi Martiri: Pala dei Martiri Anauniesi (1775)
              </li>
              <li>
                <a href="https://goo.gl/maps/mcGoiMvke7C2" target="_blank" title="Vedi su Google Maps [link esterno]"><i class="fas fa-map-marker-alt"></i></a>
                Cavareno, Chiesa di Santa Maria Maddalena: Maddalena Penitente (1776)
              </li>
              <li>
                <a href="https://goo.gl/maps/EU5xfsKQToE2" target="_blank" title="Vedi su Google Maps [link esterno]"><i class="fas fa-map-marker-alt"></i></a>
                Cles, convento francescano: Cristo morto (1779)
              </li>
              <li>
                <a href="https://goo.gl/maps/FAo7nGKvJoL2" target="_blank" title="Vedi su Google Maps [link esterno]"><i class="fas fa-map-marker-alt"></i></a>
                Romeno, affreschi nella volta del presbiterio della Chiesa di S. Maria Assunta (1773 c.a.)
              </li>
            </ul>
          </div>
        </div>
        <hr>
        <div class="row mt-5">
          <div class="col">
            <h3>Giovanni Battista Lampi<br><small>(Romeno, 31 dicembre 1751 – Vienna, 11 febbraio 1830)</small></h3>
            <blockquote class="blockquote mb-5 text-justify">
              <p>Figlio di Matthias Lamp, modesto pittore originario della Val Pusteria, e di Margherita Lorenzoni di Cles, Giovanni Battista nasce il 31 dicembre 1751 a Romeno in Val di Non, all'epoca territorio del principato vescovile di Trento.</p>
              <p>Appresi i rudimenti della pittura dal padre, tra il 1768 e il 1772 viene inviato a perfezionarsi a Salisburgo, dove opera il cugino Pietro Antonio Lorenzoni, anch'egli pittore. A Salisburgo il giovane Lamp (il cognome sarà italianizzato in "Lampi" solo nel 1782) viene collocato a bottega presso il pittore Franz Xaver König e successivamente presso il suo collega Franz Nikolaus Streicher. Al suo rientro in patria inizia un'attività autonoma, rivelando una spiccata propensione per la ritrattistica. Protetto dai principi vescovi Cristoforo Sizzo e Pietro Vigilio Thun – di cui esegue alcuni ritratti – apre bottega a Trento, dove diviene in breve tempo uno dei pittori prediletti dell'aristocrazia. Frattanto il pittore ha modo di completare la propria formazione a Verona, dove frequenta l'Accademia di Pittura e Scultura e stringe amicizia con il frescante tiepolesco Francesco Lorenzi. Durante il periodo trentino esegue numerosi ritratti all'insegna di un mimetismo scrupoloso e diligente, secondo un orientamento realistico che culmina nell'effigie del vescovo di Sutri e Nepi Gerolamo Luigi Crivelli del 1779, dove compare significativamente una mosca a <i>trompe-l'oeil</i>. All'ottavo decennio del secolo risalgono anche alcune tele di soggetto sacro: la pala dei <i>Santi Martiri Anauniesi</i>, dipinta nel 1775 per la chiesa pievana di Sanzeno; la <i>Maddalena penitente</i> di Cavareno, del 1776; e il <i>San Luigi Gonzaga</i> di Santa Croce del Bleggio, risalente all'anno successivo.</p>
              <p>Dopo un breve soggiorno a Rovereto, dal 1780 Lampi è attivo in Tirolo, dove esegue i ritratti degli abati di Stams e di Wilten, tuttora conservati nelle rispettive abbazie. L'anno successivo dipinge anche la pala di <i>Sant'Egidio intercessore</i> per la chiesa di Igls e la pala della <i>Predicazione di Sant'Andrea Apostolo</i> per la chiesa di Aldeno: si tratta delle ultime opere di carattere sacro eseguite dall'artista, che da questo momento si dedicherà pressoché esclusivamente al ritratto. A Innsbruck posa per lui l'arciduchessa Maria Elisabetta d'Asburgo-Lorena, che gli apre in tal modo la strada a una serie di prestigiose commissioni da parte della Casa d'Austria.</p>
              <p>Nel 1781 l'arciduchessa Marianna lo invita a Klagenfurt per essere a sua volta ritratta, ma la vera meta di Lampi è Vienna, dove giunge con la moglie Anna Maria Franchi e i due figli nel 1783. Sulle rive del Danubio, durante un quinquennio di continua ascesa professionale, la sua pittura si sprovincializza aggiornandosi sugli orientamenti estetici internazionali, nel clima illuminato dell'età giuseppina. A questo periodo risalgono alcune importanti commissioni provenienti dalla corte imperiale, tra cui il ritratto della duchessa Elisabeth Wilhelmine von Württemberg, noto in più versioni. Vanno inoltre ricordati i ritratti a grandezza naturale dell'imperatore Giuseppe II e del cancelliere Kaunitz, eseguiti su incarico dell'Accademia di Arti Figurative. Grazie alla protezione del suo presidente, il tirolese Josef von Sperges, nel 1785 Lampi viene cooptato tra i membri dell'istituto e l'anno successivo viene nominato professore di pittura di storia. Al 1787 risale il ritratto in veste pubblica del barone Sperges, che segna la piena adesione di Lampi al gusto neoclassico.</p>
              <div class="float-right clearfix ml-3 p-1 border rounded" style="width:210px;">
                <a href="https://commons.wikimedia.org/wiki/File:Catherine_II_by_J.B.Lampi_(Deutsches_Historisches_Museum).jpg#/media/File:Catherine_II_by_J.B.Lampi_(Deutsches_Historisches_Museum).jpg" class="d-block" target="_blank">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/0/01/Catherine_II_by_J.B.Lampi_%28Deutsches_Historisches_Museum%29.jpg" alt="Catherine II by J.B.Lampi (Deutsches Historisches Museum).jpg" class="img-fluid rounded" width="200">
                </a>
                <small class="d-block">Ritratto della zarina Caterina II</small>
                <small>
                  <a rel="nofollow" class="external free" href="https://www.dhm.de/en/ausstellungen/permanent-exhibition/epochs/1789-1871.html" target="_blank">Risorsa originale</a>,
                <a href="https://commons.wikimedia.org/w/index.php?curid=36203617"  target="_blank">Pubblico dominio</a>
                </small>
              </div>
              <p>Tra il 1788 e il 1789 il pittore soggiorna a Varsavia, facendo incetta di commissioni tra le famiglie dell'aristocrazia. È accolto benevolmente dal re Stanislao Augusto Poniatowski, del quale esegue alcuni ritratti. Ritornato a Vienna, viene incaricato di ritrarre il nuovo imperatore Leopoldo II. Frattanto porta a termine alcuni dipinti iniziati in Polonia, tra i quali il ritratto di Sophie de Witt come vestale, oggi al Castello del Buonconsiglio.</p>
              <p>Nell'autunno del 1791, su invito del principe di Tauride Grigorj Potëmkin, si reca a Jassy in Moldavia: di qui parte alla volta di San Pietroburgo, dove giunge nel gennaio del 1792. Il soggiorno russo durerà quasi sei anni e segnerà il culmine del successo per il ritrattista trentino, che divenne il pittore ufficiale di Caterina II, immortalata in un grandioso ritratto a tutta altezza destinato a divenire la sua icona più nota e fastosa.
              Ottenuto il favore della sovrana, tutte le porte gli sono aperte: riceve commissioni dai principali esponenti della corte e viene protetto dall'ultimo favorito della zarina, il principe Platon Zubov. Nel 1794 diviene membro onorario della locale Accademia di Belle Arti, di cui redige un piano di riforma. Nel 1796 Lampi firma due capolavori assoluti, i ritratti dei fratelli Platon e Valerian Zubov nel parato dell'ordine di Sant'Andrea il Primo Chiamato. La morte della zarina, avvenuta il 16 novembre dello stesso anno, e l'avvento al trono dell'eccentrico Paolo I lo inducono a fare ritorno in Austria.</p>
              <p>A Vienna Lampi riprende l'insegnamento all'Accademia e diviene in breve tempo uno dei ritrattisti più richiesti dall'aristocrazia mitteleuropea, contendendo il primato al collega Heinrich Füger. Per la sua conclamata fedeltà alla Casa d'Austria e per i suoi meriti artistici, il 4 settembre 1798 viene nominato cavaliere dell'impero con diploma dell'imperatore Francesco II. L'alto riconoscimento trova un corrispettivo nell'esecuzione di numerosi ritratti di esponenti della famiglia imperiale, tra cui risaltano i due grandi ritratti di Francesco II e della seconda moglie Maria Teresa di Borbone realizzati per l'abbazia di Sankt Lambrecht in Stiria. In questi anni si cimenta, sia pure occasionalmente, con la pittura di storia: ne è significativa testimonianza, nel 1803, la <i>Fuga delle vestali da Roma</i>, piccola opera nota in due redazioni. Di argomento storico e religioso sono pure alcuni disegni coevi, realizzati a penna e acquerello.</p>
              <div class="float-right clearfix ml-3 p-1 border rounded" style="width:210px;">
                <img src="img/lampi_tomba.jpg" alt="La tomba di Giovanni Battista Lampi nel Zentralfriedhof di Vienna, opera dello scultore Josef Klieber" class="img-fluid rounded" width="200">
                </a>
                <small class="d-block">La tomba di Giovanni Battista Lampi nel Zentralfriedhof di Vienna, opera dello scultore Josef Klieber</small>
                <small>
                  By <a href="//commons.wikimedia.org/wiki/User:Papergirl" title="User:Papergirl">Papergirl</a> - <span class="int-own-work" lang="en">Own work</span><br><a href="https://creativecommons.org/licenses/by-sa/4.0" title="Creative Commons Attribution-Share Alike 4.0">CC BY-SA 4.0</a> - <a href="https://commons.wikimedia.org/w/index.php?curid=66258099">Link</a>
                </small>
              </div>


              <p>Durante la burrascosa stagione delle invasioni napoleoniche, Lampi si mantiene su posizioni lealiste e partecipa alla difesa del patrimonio artistico di Vienna in veste di colonnello della Legione accademica. Nel 1806 esegue su commissione dell'ambasciatore russo Andrej Razumovskij il celebre ritratto di Antonio Canova. Al biennio 1812-1814 risalgono i due spettacolari ritratti a figura intera dei principi Schwarzenberg, conservati nel castello di Hluboká nad Vltavou in Moravia, che documentano l'adesione del pittore ai dettami del gusto Impero.</p>
              <p>Durante il Congresso di Vienna si collocano le ultime commissioni di rilievo portate a termine dal pittore, che l'11 gennaio 1815 ha l'onore di ricevere nel proprio studio la visita della zarina Elisabetta e del re di Baviera Massimiliano I accompagnato dalla consorte. Prosegue frattanto il suo magistero all'Accademia, presso la quale nel 1819 istituisce un premio destinato agli studenti che frequentano la scuola del nudo. Tra i suoi allievi si annoverano i futuri protagonisti della pittura austriaca dell'Ottocento: Leopold Kupelwieser, Peter Fendi, Johann Ender, Franz Eybl e Ferdinand Georg Waldmüller. Nel 1822 si ritira dall'insegnamento e affida la direzione dell'<i>atelier</i> al figlio Giovanni Battista junior.</p>

              <p>Negli anni della vecchiaia l'artista soggiorna sovente nella cittadina termale di Baden: qui nel 1824 ritrae il proprio medico curante, Anton Franz Rollett. Le sue condizioni di salute vanno tuttavia peggiorando, tanto che sarà il figlio maggiore a eseguire materialmente la grande pala dell'<i>Assunta</i>, inviata in dono alla chiesa parrocchiale di Romeno nel 1825.</p>
              <p>Il 30 agosto 1826 l'anziano maestro riceve la medaglia al merito civile. Due anni dopo, in segno di riconoscenza, dona all'imperatore la sua ultima opera, l'autoritratto al cavalletto, prendendo definitivamente congedo dai pennelli. L'artista si spegne a Vienna l'11 febbraio 1830. La sua eredità artistica sarà raccolta dai due figli, entrambi pittori: Giovanni Battista junior (Trento, 1775 – Vienna, 1837) e Francesco (Klagenfurt, 1782 – Varsavia, 1852).</p>
              <footer class="blockquote-footer">di Roberto Pancheri <cite title="Source Year">maggio 2012</cite></footer>
            </blockquote>
          </div>
        </div>
        <hr>
        <div class="row mt-5 galleryWrap"></div>
        <hr>
        <div class="row mb-5">
          <div class="col">
            <h3>Bibliografia essenziale:</h3>
            <ul>
              <li><span class="font-weight-bold">L. Rosati</span>, <span class="font-italic">Notizie storiche intorno ai pittori Lampi</span>, <span>Trento 1925;</span></li>
              <li><span class="font-weight-bold">A. Morassi</span>, <span class="font-italic">Giambattista Lampi e i suoi figli</span>, <span>in "Dedalo", VII, 1927, n. 3, pp. 568-597;</span></li>
              <li><span class="font-weight-bold">AA.VV</span>, <span class="font-italic">Giovanni Battista Lampi (1751-1830)</span>, <span>catalogo della mostra (Trento, Castello del Buonconsiglio), a cura di N. Rasmo, Trento 1951;</span></li>
              <li><span class="font-weight-bold">N. Rasmo</span>, <span class="font-italic">Giambattista Lampi pittore</span>, <span>Trento 1957 (riedito nella "Collana Artisti Trentini", IV, Trento 1977);</span></li>
              <li><span class="font-weight-bold">AA.VV</span>, <span class="font-italic">Un ritrattista nell’Europa delle corti. Giovanni Battista Lampi 1751-1830</span>, <span>catalogo della mostra (Trento, Castello del Buonconsiglio), a cura di F. Mazzocca, R. Pancheri, A. Casagrande, Trento 2001;</span></li>
              <li><span class="font-weight-bold">R. Pancheri</span>, <span class="font-italic">Lampi, Giovanni Battista</span>, <span>in <i>Dizionario Biografico degli Italiani</i>, vol. LXIII, 2004, <i>ad vocem</i>;</span></li>
              <li><span class="font-weight-bold">R. Pancheri</span>, <span class="font-italic">Giovanni Battista Lampi alla corte di Caterina II di Russia</span>, <span>Trento 2011</span></li>
            </ul>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      $(document).ready(function() {
        var endpointUrl = 'https://query.wikidata.org/sparql';
        var sparqlQuery = "SELECT ?dipinto ?luogo ?luogoLabel ?immagine WHERE {\n" +
        "  SERVICE wikibase:label { bd:serviceParam wikibase:language \"[AUTO_LANGUAGE],en\". }\n" +
        "  ?dipinto wdt:P31 wd:Q3305213.\n" +
        "  ?dipinto wdt:P170 wd:Q699740.\n" +
        "  OPTIONAL { ?dipinto wdt:P276 ?luogo. }\n" +
        "  OPTIONAL { ?dipinto wdt:P18 ?immagine. }\n" +
        "}";

        wikiApi( endpointUrl, sparqlQuery, function( data ) {
          imgList = data.results.bindings;
          imgList.forEach(function(v,i){
            if (v.immagine) {
              ext = v.immagine.value.split('.').pop();
              if (ext != 'tif') {
                $("<div/>",{id:'img'+i,class:'col-4 col-lg-3 p-0 imgDiv galleryItem lozadImg'})
                .attr("data-background-image",v.immagine.value+"?width=300")
                .appendTo('.galleryWrap');
              }
            }
          })
          wrapImgWidth()
          galleryObserver.observe();
        });
      });
      window.addEventListener("orientationchange", function() {
        window.setTimeout(function() { wrapImgWidth() }, 200);
      }, false);
    </script>
  </body>
</html>
