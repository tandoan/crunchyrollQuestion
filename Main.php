<?php
$includePath = get_include_path();
$cwd = getcwd();
set_include_path($includePath . PATH_SEPARATOR . $cwd . '/interfaces');
require_once('HTTPFactory.php');
require_once('Evaluator.php');
require_once('WeightedDigraph.php');
require_once('Tarjan.php');
require_once('DijkstraShortestPath.php');

class Main
{
    private $tarjan;
    private $dsp;
    private $goalLink;
    private $graph;
    private $http;
    private $linksFetched;

    /**
     * Intended for the $linksFetched array, which stores true for a key if it has been fetched, else false
     * @param $array
     * @return bool
     */
    function linksToFetch($array)
    {
        return array_search(false, $array);
    }

    function evalLink($input)
    {
        return Evaluator::evaluate($input);
    }

    function processLinksPage($pageText)
    {
        $unParsedLinks = explode("\n", $pageText);
        return array_map(array($this, 'evalLink'), $unParsedLinks);
    }

    function init()
    {
        $this->tarjan = new Tarjan();
        $this->dsp = new DijkstraShortestPath();
        $this->goalLink = '';
        $this->deadEnds = array();
        $this->graph = new WeightedDiGraph();
        $this->http = HTTPFactory::create();
        $this->linksFetched = array();
        $this->startingLink = '';
    }

    /**
     * Accpets the initial expression, and crawls pages, building out a directed graph in the process
     * @param $initExpression
     */
    function crawl($initExpression)
    {
        $this->startingLink = $this->evalLink($initExpression);
        $this->linksFetched[$this->startingLink] = false;

        while ($link = $this->linksToFetch($this->linksFetched)) {
            //get a non-fetched link
            echo "Link to fetch is $link\n";

            $this->graph->addVertex($link);
            $pageText = $this->http->getFrom($link);
            $this->linksFetched[$link] = true;

            echo "Fetched:\n$pageText\n";
            if ($pageText === 'DEADEND') {
                $this->deadEnds[$link] = true;
            } elseif ($pageText === 'GOAL') {
                $this->goalLink = $link;
            } else {
                $parsedLinks = $this->processLinksPage($pageText);
                foreach ($parsedLinks as $parsedLink) {
                    if (!isset($this->linksFetched[$parsedLink])) {
                        $this->linksFetched[$parsedLink] = false;
                        if (false !== $this->graph->addVertex($parsedLink)) {
                            $this->graph->addEdge($link, $parsedLink);
                        }
                    }
                }
            }
        }
    }


    public function run($initInput)
    {
        $this->crawl($initInput);

        $answer = array();
        $answer["goal"] = $this->goalLink;
        $answer["node_count"] = $this->graph->getNumVertices();
        $answer["shortest_path"] = $this->dsp->getShortestPath($this->graph, $this->startingLink, $this->goalLink);
        $answer["directed_cycle_count"] = $this->tarjan->countCycles($this->graph);

        return json_encode($answer);
    }
}


$expression = 'abs(add(add(add(add(44181,188),32),142),add(subtract(41,25775),28)))';

$options = getopt("e:");
if($options['e']){
    $expression = $options['e'];
}
$m = new Main();
$m->init();
$json = $m->run($expression);
echo "Answer is: ";
echo $json;
echo "\n";