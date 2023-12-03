<?php

namespace App\Services\Interfaces;
interface LookupUser
{
    public function getUser(string $id_type, string $user_id);
}
