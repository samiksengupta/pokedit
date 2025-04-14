<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EffectText extends Model
{
    public $timestamps = false;
    protected $fillable = ['language_id', 'version_id', 'effect_text', 'short_effect_text'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function textable()
    {
        return $this->morphTo();
    }
}
