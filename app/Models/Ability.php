<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasNames;
use App\Traits\HasVersion;
use App\Traits\HasGeneration;
use App\Traits\HasEffectTexts;
use App\Traits\HasFlavorTexts;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasSlug;
    use HasEffectTexts;
    use HasFlavorTexts;
    use HasNames;
    use HasSlug;
    use HasGeneration;
    use HasVersion;
}
