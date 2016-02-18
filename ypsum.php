<?
header("Content-Type: text/plain;charset=utf-8");
header("Access-Control-Allow-Origin: *");

$textao = [];
$urls = [];
$feed = simplexml_load_file("https://medium.com/feed/tag/geracao-y");

foreach($feed->children()->children() as $books) {
    if($books->link != "") array_push($urls, $books->link);
}

$dom = new DOMDocument;

for ($i = 0; $i < $_GET['p']; $i++) {
  $dom->loadHTML(file_get_contents($urls[array_rand($urls)]));
  $paragraphs = $dom->getElementsByTagName('p');
  $paragraphs = iterator_to_array($paragraphs);

  $textContent = $paragraphs[array_rand($paragraphs)]->textContent;

  if($textContent != "" && !in_array($textContent, $os)){
    array_push($textao, $textContent);
  } else {
    $i--;
  }

}

foreach($textao as $text){
  echo $text . "\n". "\n";
}
