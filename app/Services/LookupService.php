<?php

namespace App\Services;

use App\Services\Interfaces\LookupUser;

class LookupService
{
    private $platform;

    public function setPlatform(LookupUser $platform)
    {
        $this->platform = $platform;
    }
    public function getUser($id_type, $user_id): array
    {
        return $this->platform->getUser($id_type, $user_id);
    }
}
