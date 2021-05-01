<?php
require 'feed.php';
header("Cache-Control: no-cache");
$url = 'https://www.blv.admin.ch/';
$feed = new feed($url,'BLV');
$feed->author = 'BLV';
$rawData = file_get_contents('https://www.blv.admin.ch/blv/de/home/lebensmittel-und-ernaehrung/rueckrufe-und-oeffentliche-warnungen/_jcr_content/par/downloadlist_1976929218.content.paging-1.html');
$filteredData = (explode('</ul>',(explode('<ul class="list-unstyled">',$rawData,)[1]))[0]);
$list = explode('<li>',$filteredData);
$skipFirst = false;
foreach($list as $item){
	if($skipFirst){
		$link = ('https://www.blv.admin.ch'.(explode('"',substr($item,9))[0]));
		$title = (explode('"',(explode('title="',$item)[1]))[0]);
		$rawText = (explode('</a>',(explode('class="icon icon--before icon--pdf">',$item)[1]))[0]);
		$text = ((explode('<span class="text-dimmed">',$rawText)[0]).(substr((explode('<span class="text-dimmed">',$rawText)[1]),0,-7)));
		$rssItem = $feed->newItem($link,$title);
		$rssItem->content = $text;
		$rssItem->contentType = 'html';
		$rssItem->link = $link;
	}
	$skipFirst = true;
}
$rawData = file_get_contents('https://www.blv.admin.ch/blv/de/home/lebensmittel-und-ernaehrung/rueckrufe-und-oeffentliche-warnungen/_jcr_content/par/downloadlist.content.paging-1.html');
$filteredData = (explode('</ul>',(explode('<ul class="list-unstyled">',$rawData,)[1]))[0]);
$list = explode('<li>',$filteredData);
$skipFirst = false;
foreach($list as $item){
	if($skipFirst){
		$link = ('https://www.blv.admin.ch'.(explode('"',substr($item,9))[0]));
		$title = (explode('"',(explode('title="',$item)[1]))[0]);
		$rawText = (explode('</a>',(explode('class="icon icon--before icon--pdf">',$item)[1]))[0]);
		$text = ((explode('<span class="text-dimmed">',$rawText)[0]).(substr((explode('<span class="text-dimmed">',$rawText)[1]),0,-7)));
		$rssItem = $feed->newItem($link,$title);
		$rssItem->content = $text;
		$rssItem->contentType = 'html';
		$rssItem->link = $link;
	}
	$skipFirst = true;
}
$feed->printFeed();
