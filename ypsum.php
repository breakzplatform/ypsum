<?php
header("Content-Type: text/plain;charset=utf-8");
header("Access-Control-Allow-Origin: *");

// Detect which response mode to use
$mode = 'plain-text';

if ($_GET['json']) {
  $mode = 'json';
}

// Build the textao
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

// Serve the textao
switch ($mode) {
  case 'json':
    header('Content-type: application/json');
    $jsonRoot = array('textao' => []);
    for ($i = 0; $i < $_GET['p']; $i++) {
      array_push($jsonRoot['textao'], array('paragraph' => $textao[$i], 'url' => $urls[$i]));
    }
    echo json_encode($jsonRoot);
  break;

  case 'plain-text':
  default:
    foreach($textao as $text){
      echo $text . "\n". "\n";
    }
  break;
}
