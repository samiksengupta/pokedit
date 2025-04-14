<?php

namespace App\Models;

use App\Traits\HasSlug;

use Illuminate\Database\Eloquent\Model;

class GenderRatio extends Model
{
    use HasSlug;

    public static function getLocalName($name)
    {
        return match ($name) {
            0 => 'only-male',
            1 => 'mostly-male',
            2 => 'usually-male',
            4 => 'equal',
            6 => 'usually-female',
            7 => 'mostly-female',
            8 => 'only-female',
            default => 'genderless',
        };
    }
}
