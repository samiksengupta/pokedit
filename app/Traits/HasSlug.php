<?php

namespace App\Traits;

use App\Models\Setting;
use App\Models\Language;
use Illuminate\Support\Str;

trait HasSlug 
{
    public function initializeHasSlug() 
    {
        $this->fillable[] = 'slug';
    }

    public static function bootHasSlug()
    {
        static::saving(function($model){
            $model->setSlugIfNotPresent();
        });
    }

    public function setSlugIfNotPresent()
    {
        if(!$this->slug && \property_exists($this, 'names')) {
            $language = Language::where('slug', Setting::find('app.language')->value)->firstOrFail();
            $name = ((object) $this->names->first(function($value) use($language) {
                return ((object) $value)->language === $language->slug;
            }))->name;
            if($name) $this->slug = Str::snake($name);
        }
    }
}