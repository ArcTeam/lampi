<?php
class SPARQLQueryDispatcher{
    private $endpointUrl;

    public function __construct(string $endpointUrl)
    {
        $this->endpointUrl = $endpointUrl;
    }

    public function query(string $sparqlQuery): array
    {

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Accept: application/sparql-results+json'
                ],
            ],
        ];
        $context = stream_context_create($opts);

        $url = $this->endpointUrl . '?query=' . urlencode($sparqlQuery);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}

$endpointUrl = 'https://query.wikidata.org/sparql';
$sparqlQueryString = <<< 'SPARQL'
SELECT ?dipinto ?luogo ?luogoLabel ?immagine WHERE {
  SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],en". }
        ?dipinto wdt:P31 wd:Q3305213.
        ?dipinto wdt:P170 wd:Q699740.
        OPTIONAL { ?dipinto wdt:P276 ?luogo. }
        OPTIONAL { ?dipinto wdt:P18 ?immagine. }
}
SPARQL;

$queryDispatcher = new SPARQLQueryDispatcher($endpointUrl);
$queryResult = $queryDispatcher->query($sparqlQueryString);

$folder = "../img/wiki/";
foreach ($queryResult['results']['bindings'] as $key => $value) {
  $img = $value['immagine']['value'];
  if ($img) {
    $out = end(explode('/',$img));
    system('wget -q '.$img.' -O '.$folder.$out);
  }
}
?>
