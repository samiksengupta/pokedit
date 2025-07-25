<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasNames;
use App\Traits\HasVersion;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasSlug;
    use HasNames;
    use HasVersion;

    public function offensiveMatchups()
    {
        return $this->hasMany(TypeMatchup::class, 'attacking_type_id');
    }

    public function defensiveMatchups()
    {
        return $this->hasMany(TypeMatchup::class, 'defending_type_id');
    }
}
