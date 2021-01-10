<?php

namespace lumilock\lumilockGateway\App\Traits;

use GuzzleHttp\Client;

trait ConsumeExternalService
{
    /**
     * Send request to any service
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        try {
            $client = new Client([
                'base_uri'  =>  $this->baseUri,
                'http_errors' => false
            ]);

            if (isset($this->secret)) {
                $headers['Authorization_secret'] = $this->secret;
            }
            $promise = $client->requestAsync($method, $requestUrl, [
                'form_params' => $formParams,
                'headers'     => $headers,
                'synchronous' => false,
                'timeout' => 10
            ]);

            return $promise->wait()->getBody()->getContents();
            //https://github.com/guzzle/guzzle/issues/1127
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
