<?php

namespace App\Services\Interfaces;

interface SearchInterface
{
    public function search($query, $maxImages);
}
