<?php

namespace App\Traits;

use Illuminate\Support\Str;

use App\Models\EffectText;
use App\Models\Setting;
use App\Models\Version;
use App\Models\Language;

trait HasEffectTexts 
{
    public function effectTexts()
    {
        return $this->morphMany(EffectText::class, 'textable');
    }

    public function effectText()
    {
        return $this->morphOne(EffectText::class, 'textable')->whereBelongsTo(Language::where('slug', Setting::find('app.language')->value)->first());
    }

    public function getEffectTextAttribute()
    {
        return $this->effectText()->first()->effect_text ?? "";
    }

    public function getShortEffectTextAttribute()
    {
        return $this->effectText()->first()->short_effect_text ?? "";
    }

    public function getEffectTextsAttribute()
    {
        $model = $this;
        return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($model) {
            $version = Version::where(['slug' => Setting::find('app.version')->value])->first();
            $effectTextEntry = $model->effectTexts()->where('language_id', $language->id)->where('version_id', $version->id)->first();
            return (object) [
                'language' => $language->slug,
                'effect_text' => $effectTextEntry->effect_text ?? "",
                'short_effect_text' => $effectTextEntry->short_effect_text ?? ""
            ];
        })->keyBy('language');;
    }

    public function setEffectTextsAttribute($value)
    {
        $this->effect_texts = collect($value);
    }

    public function initializeHasEffectTexts() 
    {
        $this->fillable[] = 'effect_texts';
        $this->appends[] = 'effect_texts';
        $this->appends[] = 'effect_text';
        $this->appends[] = 'short_effect_text';
        $this->guarded[] = 'effect_text';
        $this->guarded[] = 'short_effect_text';
    }

    public static function bootHasEffectTexts()
    {
        static::saved(function($model){
            $model->saveEffectTexts();
        });
        static::deleting(function($model){
            $model->effectTexts()->delete();
        });
    }

    public function saveEffectTexts()
    {
        if(!\property_exists($this, 'effect_texts')) return;
        $model = $this;
        $model->effect_texts->each(function($item) use($model) {
            $item = (object) $item;
            $language = \App\Models\Language::where(['slug' => $item->language])->first();
            $version = Version::where(['slug' => Setting::find('app.version')->value])->first();
            if($language) {
                $model->effectTexts()->updateOrCreate([
                    'version_id' => $version->id,
                    'language_id' => $language->id,
                    'textable_id' => $model->id,
                    'textable_type' => get_class($model)
                ], [
                    'effect_text' => Str::squish($item->effect_text ?? ''),
                    'short_effect_text' => Str::squish($item->short_effect_text ?? ''),
                ]);
            }
        });
    }
}