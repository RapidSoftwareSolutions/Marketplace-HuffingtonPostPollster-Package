<?php

$app->post('/api/HuffingtonPostPollster/getCharts', function ($request, $response) {
    /** @var \Slim\Http\Response $response */
    /** @var \Slim\Http\Request $request */
    /** @var \Models\checkRequest $checkRequest */

    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }

    $url = $settings['apiUrl'] . "/charts";

    $param = [];

    if (isset($postData['args']['cursor']) && strlen($postData['args']['cursor']) > 0) {
        $param['cursor'] = $postData['args']['cursor'];
    }
    if (!empty($postData['args']['tags'])) {
        if (is_array($postData['args']['tags'])) {
            $tags = implode(',', $postData['args']['tags']);
        }
        else {
            $tags = $postData['args']['tags'];
        }
        $param['tags'] = $tags;
    }
    if (isset($postData['args']['electionDate']) && strlen($postData['args']['electionDate']) > 0) {
        $date = new DateTime($postData['args']['electionDate']);
        $param['election_date'] = $date->format('Y-m-d');
    }

    try {
        /** @var GuzzleHttp\Client $client */
        $client = $this->httpClient;
        $vendorResponse = $client->get($url, [
            'query' => $param
        ]);
        $vendorResponseBody = $vendorResponse->getBody()->getContents();
        if ($vendorResponse->getStatusCode() == 200) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_decode($vendorResponse->getBody());
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            if (empty($vendorResponseBody)) {
                $result['contextWrites']['to']['status_msg'] = $vendorResponse->getReasonPhrase();
            } else {
                $result['contextWrites']['to']['status_msg'] = is_array($vendorResponseBody) ? $vendorResponseBody : json_decode($vendorResponseBody);
            }
        }
    } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
        $vendorResponseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        if (empty($vendorResponseBody)) {
            $result['contextWrites']['to']['status_msg'] = $exception->getResponse()->getReasonPhrase();
        } else {
            $result['contextWrites']['to']['status_msg'] = $vendorResponseBody;
        }
    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
