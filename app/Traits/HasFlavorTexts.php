<?php

namespace App\Traits;

use Illuminate\Support\Str;

use App\Models\FlavorText;
use App\Models\Setting;
use App\Models\Version;
use App\Models\Language;

trait HasFlavorTexts 
{
    public function flavorTexts()
    {
        return $this->morphMany(FlavorText::class, 'textable');
    }

    public function flavorText()
    {
        return $this->morphOne(FlavorText::class, 'textable')->whereBelongsTo(Language::where('slug', Setting::find('app.language')->value)->first());
    }

    public function getFlavorTextAttribute()
    {
        return $this->flavorText()->first()->flavor_text ?? "";
    }

    public function getFlavorTextsAttribute()
    {
        $model = $this;
        return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($model) {
            $version = Version::where(['slug' => Setting::find('app.version')->value])->first();
            $flavorTextEntry = $model->flavorTexts()->where('language_id', $language->id)->where('version_id', $version->id)->first();
            return (object) [
                'language' => $language->slug,
                'flavor_text' => $flavorTextEntry->flavor_text ?? ""
            ];
        })->keyBy('language');
    }

    public function setFlavorTextsAttribute($value)
    {
        $this->flavor_texts = collect($value);
    }

    public function initializeHasFlavorTexts() 
    {
        $this->fillable[] = 'flavor_texts';
        $this->appends[] = 'flavor_texts';
        $this->appends[] = 'flavor_text';
        $this->guarded[] = 'flavor_text';
    }

    public static function bootHasFlavorTexts()
    {
        static::saved(function($model){
            $model->saveFlavorTexts();
        });
        static::deleting(function($model){
            $model->flavorTexts()->delete();
        });
    }

    public function saveFlavorTexts()
    {
        if(!\property_exists($this, 'flavor_texts')) return;
        $model = $this;
        $model->flavor_texts->each(function($item) use($model) {
            $item = (object) $item;
            $language = \App\Models\Language::where(['slug' => $item->language])->first();
            $version = Version::where(['slug' => Setting::find('app.version')->value])->first();
            if($language) {
                $model->flavorTexts()->updateOrCreate([
                    'version_id' => $version->id,
                    'language_id' => $language->id,
                    'textable_id' => $model->id,
                    'textable_type' => get_class($model)
                ], [
                    'flavor_text' => Str::squish($item->flavor_text ?? '')
                ]);
            }
        });
    }
}