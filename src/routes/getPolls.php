<?php

$app->post('/api/HuffingtonPostPollster/getPolls', function ($request, $response) {
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

    $url = $settings['apiUrl'] . "/polls";

    $param = [];

    if (isset($postData['args']['cursor']) && strlen($postData['args']['cursor']) > 0) {
        $param['cursor'] = $postData['args']['cursor'];
    }
    if (isset($postData['args']['tags']) && strlen($postData['args']['tags']) > 0) {
        $param['tags'] = $postData['args']['tags'];
    }
    if (isset($postData['args']['question']) && strlen($postData['args']['question']) > 0) {
        $param['question'] = $postData['args']['tags'];
    }
    if (isset($postData['args']['sort']) && strlen($postData['args']['sort']) > 0) {
        $param['sort'] = $postData['args']['sort'];
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
