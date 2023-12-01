<?php

namespace App\Services;

use App\Services\Interfaces\ILookupService;
use GuzzleHttp\Client;

class LookupService implements ILookupService
{
    public function getUser($type, $id_type, $user_id)
    {
        //Set base identifiers for each return aspect to pull from guzzle request
        $username_path = 'username';
        $id_path = 'id';
        $avatar_path = 'avatar';

        //Set URLs for GET request
        switch ($type) {
            case 'steam':
                $url = "https://ident.tebex.io/usernameservices/4/username/{$user_id}";

                //Give path required to retrieve variable
                $avatar_path = 'meta->avatar';
                break;
            case 'minecraft':
                if($id_type == 'id') {
                    $url = "https://sessionserver.mojang.com/session/minecraft/profile/{$user_id}";
                } else {
                    $url = "https://api.mojang.com/users/profiles/minecraft/{$user_id}";
                }

                //Overwrite username attribute as username is stored under 'name' for minecraft
                $username_path = 'name';
                break;
            case 'xbl':
                $url = "https://ident.tebex.io/usernameservices/3/username/{$user_id}";

                //If username, URL needs type variable appending
                if($id_type == 'username') {
                    $url .= '?type=username';
                }

                //Give path required to retrieve variable
                $avatar_path = 'meta->avatar';
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Provided service cannot be found'
                ]);
        }

        $guzzle = new Client();
        $response = json_decode($guzzle->get($url)->getBody()->getContents());

        $user_details = [
            'username' => $this->getValue($username_path, $response),
            'id' => $this->getValue($id_path, $response),
            'avatar' => $this->getValue($avatar_path, $response)
        ];

        if($type == 'minecraft') {
            $user_details['avatar'] = "https://crafatar.com/avatars" . $this->getValue('id', $response);
        }

        return $user_details;
    }

    /**
     * Function to retrieve a value from a possibly nested object based on given string
     *
     * @param string $string
     * @param object $response
     * @return object
     */
    private function getValue(string $path, object $response)
    {
        $path = explode('->', $path);
        $temp =& $response;

        foreach($path as $key) {
            $temp =& $temp->{$key};
        }
        return $temp;
    }
}
