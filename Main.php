<?php
$includePath = get_include_path();
$cwd = getcwd();
set_include_path($includePath . PATH_SEPARATOR . $cwd.'/interfaces');
require_once('HTTPFactory.php');
require_once('Evaluator.php');
require_once('WeightedDigraph.php');
require_once('Tarjan.php');
require_once('DijkstraShortestPath.php');

class Main {

    /**
     * Intended for the $linksFetched array, which stores true for a key if it has been fetched, else false
     * @param $array
     * @return bool
     */
    function linksToFetch($array){
        return array_search(false,$array);
    }

    function evalLink($input){
        return Evaluator::evaluate($input);
    }

    function processLinksPage($pageText){
        $unParsedLinks = explode("\n", $pageText);
        return array_map(array($this, 'evalLink'), $unParsedLinks);
    }

    public function run($initInput = 'abs(add(add(add(add(44181,188),32),142),add(subtract(41,25775),28)))'){
        $tarjan = new Tarjan();
        $dsp = new DijkstraShortestPath();
        $goalLink = '';

        $deadEnds = array();
        $graph = new WeightedDiGraph();
        $http = HTTPFactory::create();
        $linksFetched = array();


        $startingLink = $this->evalLink($initInput);
        $linksFetched[$startingLink] = false;


        // Do some crawling, build a directed graph along the way
        while($link = $this->linksToFetch($linksFetched)){
            //get a non-fetched link
            echo "Link to fetch is $link\n";

            $graph->addVertex($link);
            $pageText = $http->getFrom($link);
            $linksFetched[$link] = true;

            echo "Fetched:\n$pageText\n";
            if($pageText === 'DEADEND'){
                $deadEnds[$link] = true;
            } elseif($pageText === 'GOAL'){
                $goalLink = $link;
            } else {
                $parsedLinks = $this->processLinksPage($pageText);
                foreach($parsedLinks as $parsedLink){
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
        $answer["shortest_path"] = $dsp->getShortestPath($graph, $startingLink, $goalLink);
        $answer["directed_cycle_count"] = $tarjan->countCycles($graph);

        $return = json_encode($answer);
        echo $return;
        return $return;
    }
}

$m = new Main();
$m->run();