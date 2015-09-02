<?php

require_once('CrawlerFactory.php');
require_once('Evaluator.php');
require_once('WeightedDigraph.php');
require_once('Tarjan.php');

$t = new Tarjan();

$goals = array();
$deadEnds = array();
$graph = new WeightedDiGraph();
$crawler = CrawlerFactory::createCrawler();
$initInput = 'abs(add(add(add(add(44181,188),32),142),add(subtract(41,25775),28)))';
$linksFetched = array();

/**
 * Intended for the $linksFetched array, which stores true for a key if it has been fetched, else false
 * @param $array
 * @return bool
 */
function linksToFetch($array){
    return array_search(false,$array);
}

$link = Evaluator::evaluate($initInput);
$startingLink = $link;
$linksFetched[$link] = false;


while($link = linksToFetch($linksFetched)){
    //get a non-fetched link

    echo "Link to fetch is $link\n";

    $graph->addVertex($link);
    $pageText = $crawler->fetchFrom($link);
    $linksFetched[$link] = true;

    echo "Link ($link) fetched:\n$pageText\n";
    if($pageText === 'DEADEND'){
        $deadEnds[$link] = true;
    } elseif($pageText === 'GOAL'){
        $goalLink = $link;
    } else {
        $unParsedLinks = explode("\n", $pageText);
        foreach($unParsedLinks as $unParsedLink){
            $parsedLink = Evaluator::evaluate($unParsedLink);
            if(!isset($linksFetched[$parsedLink])){
                $linksFetched[$parsedLink] = false;
                if(false !== $graph->addVertex($parsedLink) ) {
                    $graph->addEdge($link, $parsedLink);
                }
            }

        }
    }
}



$answer = array();
$answer["goal"] = $goalLink;
$answer["node_count"] = $graph->getNumVertices();
$answer["shortest_path"] = $graph->getShortestPath($startingLink, $goalLink);
$answer["directed_cycle_count"] = $t->countCycles($graph);
//
//echo "links feched is\n";
//print_r(count($linksFetched));
echo json_encode($answer);