<?php

namespace App\Traits;

use App\Models\Name;
use App\Models\Setting;
use App\Models\Version;
use App\Models\Language;

trait HasNames 
{
    public function names()
    {
        return $this->morphMany(Name::class, 'nameable');
    }

    public function name()
    {
        return $this->morphOne(Name::class, 'nameable')->whereBelongsTo(Language::where('slug', Setting::find('app.language')->value)->first());
    }

    public function getNameAttribute()
    {
        return $this->name()->first()->name ?? "";
    }

    public function getNamesAttribute()
    {
        $model = $this;
        return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($model) {
            $version = Version::where(['slug' => Setting::find('app.version')->value])->first();
            $nameEntry = $model->names()->where('language_id', $language->id)->where('version_id', $version->id)->first();
            return (object) [
                'language' => $language->slug,
                'name' => $nameEntry->name ?? ""
            ];
        })->keyBy('language');
    }

    public function setNamesAttribute($value)
    {
        $this->names = collect($value);
    }

    public function initializeHasNames() 
    {
        $this->fillable[] = 'names';
        $this->appends[] = 'names';
        $this->appends[] = 'name';
        $this->guarded[] = 'name';
    }

    public static function bootHasNames()
    {
        static::saved(function($model){
            $model->saveNames();
        });
        static::deleting(function($model){
            $model->names()->delete();
        });
    }

    public function saveNames()
    {
        if(!\property_exists($this, 'names')) return;
        $model = $this;
        $model->names->each(function($item) use($model) {
            $item = (object) $item;
            $language = Language::where(['slug' => $item->language])->first();
            $version = Version::where(['slug' => Setting::find('app.version')->value])->first();
            if($language && $version) {
                $model->names()->updateOrCreate([
                    'version_id' => $version->id,
                    'language_id' => $language->id,
                    'nameable_id' => $model->id,
                    'nameable_type' => get_class($model)
                ], [
                    'name' => $item->name ?? ''
                ]);
            }
        });
    }
}