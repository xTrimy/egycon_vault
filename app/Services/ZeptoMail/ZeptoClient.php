<?php

namespace App\Services\ZeptoMail;

class ZeptoClient
{
    private string $apiKey;
    private string $apiUrl;
    private string $apiVersion;
    private string $apiError;
    private int $apiStatusCode;
    private string $apiResponse;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = env('ZEPTO_API_URL', 'https://api.zeptomail.com');
        $this->apiVersion = env('ZEPTO_API_VERSION', 'v1.1');
    }


    public function sendEmail(array $message)
    {
        $apiUrl = $this->apiUrl."/{$this->apiVersion}/email";
        $apiMethod = "POST";
        $apiHeaders = [
            "Authorization: {$this->apiKey}",
            "Content-Type: application/json"
        ];
        $body = json_encode($message);
        $this->apiResponse = $this->sendRequest($body, $apiUrl, $apiMethod, $apiHeaders);
        return $this->apiResponse;
    }

    private function sendRequest($request, $url, $method, $headers){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $this->apiError = curl_error($ch);
            $this->apiStatusCode = 500;
        } else {
            $this->apiStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }
        curl_close($ch);
        return $result;
    }

    public function getApiError()
    {
        return $this->apiError;
    }

    public function getApiStatusCode()
    {
        return $this->apiStatusCode;
    }

    public function getApiResponse()
    {
        return $this->apiResponse;
    }




}