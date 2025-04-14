<?php

namespace App\Traits;

use App\Models\Setting;
use App\Models\Version;

trait HasVersion 
{
    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function initializeHasVersion() 
    {
        $this->fillable[] = 'version_id';
    }

    public static function bootHasVersion()
    {
        static::saving(function($model){
            $model->version()->associate(Version::where('slug', Setting::find('app.version')->value)->firstOrFail());
        });
    }
}