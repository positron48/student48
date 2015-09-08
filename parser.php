<?
require("parts/simple_html_dom.php");
$html = file_get_html('http://www.google.ru/movies?near=%D0%BB%D0%B8%D0%BF%D0%B5%D1%86%D0%BA');

foreach($html->find('a') as $element) 
{
	if($element->href[0] == '/')
       $element->href = 'http://google.ru'.$element->href;
}
foreach($html->find('img') as $element) 
{
	if($element->src[0] == '/')
       $element->src = 'http://google.ru'.$element->src;
}

$html->find('div[id=gbar]',0)->outertext='';
$html->find('div[id=guser]',0)->outertext='';
$html->find('div[id=left_nav]',0)->outertext='';
$html->find('div[id=bottom_search]',0)->outertext='';
$html->find('body center',-1)->outertext='';

$res = $html->find('div[id=movie_results]',0)->outertext;
$html->find('div[id=results]',0)->outertext = $res;

$html->find('body',0)->tag .= ' style="padding-left:20px;"';

echo $html;

?>