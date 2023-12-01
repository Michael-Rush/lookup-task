<?php

namespace App\Services\Interfaces;
interface ILookupService
{
    public function getUser(string $service, string $id_type, string $id);
}
