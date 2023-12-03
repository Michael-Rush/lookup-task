<?php

namespace App\Services;

use App\Services\Interfaces\LookupUser;

class LookupSelectionService
{
    public static function getLookupPlatform(string $platform): LookupUser
    {
        switch ($platform) {
            case "minecraft":
                return new MinecraftLookup();
            case "steam":
                return new SteamLookup();
            case "xbl":
                return new XblLookup();
            default:
                throw new \Exception("Unknown platform to search on");
        }
    }
}
