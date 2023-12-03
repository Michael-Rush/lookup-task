<?php

namespace App\Services;

use App\Services\Interfaces\LookupUser;

class XblLookup implements LookupUser
{
    public function __construct()
    {
        $this->guzzleService = new GuzzleService();
    }

    public function getUser($id_type, $user_id): array
    {
        //Url for all Xbl lookups
        $url = "https://ident.tebex.io/usernameservices/3/username/{$user_id}";

        //If username, URL needs type variable appending
        if($id_type == 'username') {
            $url .= '?type=username';
        }

        //Get response using guzzle service
        $response = $this->guzzleService->get($url);

        //If error present, return that gracefully
        if(isset($response->error)) {
            return [
                'success' => false,
                'errors' => $response->error->message
            ];
        }

        //Return user information
        return [
            'username' => $response->username,
            'id' => $response->id,
            'avatar' => $response->meta->avatar
        ];
    }
}
