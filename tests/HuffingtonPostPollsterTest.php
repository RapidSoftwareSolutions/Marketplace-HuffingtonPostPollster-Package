<?php
namespace Tests;

require_once(__DIR__ . '/../src/Models/checkRequest.php');

class HuffingtonPostPollsterTest extends BaseTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testRoutes($url) {
        $response = $this->runApp("POST", '/api/HuffingtonPostPollster/'.$url);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function dataProvider() {
        return [
            ['getPolls'],
            ['getSinglePoll'],
            ['getQuestions'],
            ['getSingleQuestion'],
            ['getSingleQuestionCleanResponses'],
            ['getSingleQuestionRawResponses'],
            ['getCharts'],
            ['getSingleChart'],
            ['getPollsterChartData'],
            ['getPollsterChartTrendlinesData'],
            ['getTags']
        ];
    }
}