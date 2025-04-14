<?php

namespace App\Traits;

use App\Models\Generation;

trait HasGeneration 
{
    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    public function initializeHasGeneration() 
    {
        $this->fillable[] = 'generation_id';
    }
}