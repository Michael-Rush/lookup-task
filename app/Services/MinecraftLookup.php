<?php

namespace App\Services;

use App\Services\Interfaces\LookupUser;

class MinecraftLookup implements LookupUser
{
    public function __construct()
    {
        $this->guzzleService = new GuzzleService();
    }

    public function getUser($id_type, $user_id): array
    {
        //Decide url based on whether username or id has been passed in
        $url = "https://sessionserver.mojang.com/session/minecraft/profile/";
        $url .= $user_id;
        if($id_type == 'username') {
            $url = "https://api.mojang.com/users/profiles/minecraft/{$user_id}";
        }

        //Get response using guzzle service
        $response = $this->guzzleService->get($url);

        //If error thrown by guzzle service, return the error message given
        if(is_string($response)) {
            return [
                'success' => false,
                'errors' => $response
            ];
        }

        //Return user information
        return [
            'username' => $response->name,
            'id' => $response->id,
            'avatar' => "https://crafatar.com/avatars" . $response->id
        ];
    }
}
