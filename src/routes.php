<?php
$routes = [
    'metadata',
    'getPolls',
    'getSinglePoll',
    'getQuestions',
    'getSingleQuestion',
    'getSingleQuestionCleanResponses',
    'getSingleQuestionRawResponses',
    'getCharts',
    'getSingleChart',
    'getPollsterChartData',
    'getPollsterChartTrendlinesData',
    'getTags'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

