<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GuzzleService
{
    public function get($url)
    {
        $guzzle = new Client();
        try {
            return json_decode($guzzle->get($url)->getBody()->getContents());
        } catch (RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            switch($statusCode) {
                case 400:
                    $message = "400 Bad Request Response from" . $url;
                    break;
                case 404:
                    $message = "404 Not Found Response from " . $url;
                    break;
                default:
                    $message = $e->getMessage();
            }

            return $message;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
