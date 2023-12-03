<?php

namespace App\Services;

use App\Services\Interfaces\LookupUser;

class SteamLookup implements LookupUser
{
    public function __construct()
    {
        $this->guzzleService = new GuzzleService();
    }

    public function getUser($id_type, $user_id): array
    {
        //Url for all steam lookups
        $url = "https://ident.tebex.io/usernameservices/4/username/{$user_id}";

        //Get response using guzzle service
        $response = $this->guzzleService->get($url);

        //If error is present, return that gracefully
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
