<?php
header("Content-Type: text/plain;charset=utf-8");
header("Access-Control-Allow-Origin: *");

$textao = [];
$turls = [];
$urls = [];
$feed = simplexml_load_file("https://medium.com/feed/tag/geracao-y");

foreach($feed->children()->children() as $tags) {
    if($tags->link != "") array_push($urls, $tags->link);
}

$dom = new DOMDocument;

for ($i = 0; $i < $_GET['p']; $i++) {
  $url = $urls[array_rand($urls)];
  $dom->loadHTML(file_get_contents($url));
  $paragraphs = $dom->getElementsByTagName('p');
  $paragraphs = iterator_to_array($paragraphs);

  $textContent = $paragraphs[array_rand($paragraphs)]->textContent;

  if($textContent != "" && !in_array($textContent, $os)){
    array_push($textao, $textContent);
    array_push($turls, $url);
  } else {
    $i--;
  }
}

if ($_GET['json'] == 1) {
  echo "{\"textao\":[";

  if ($_GET['p'] > 0) {
    echo "{\"paragraph\":\"" . $textao[0] . "\",";
    echo "\"url\":\"" . $turls[0] . "\"}";
  }

  for ($i = 1; $i < $_GET['p']; $i++) {
    echo ",{\"paragraph\":\"" . $textao[$i] . "\",";
    echo "\"url\":\"" . $turls[$i] . "\"}";
  }
  echo "]}";
} else {
  foreach($textao as $text){
    echo $text . "\n". "\n";
  }
}
