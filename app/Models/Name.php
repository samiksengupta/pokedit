<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    public $timestamps = false;
    protected $fillable = ['language_id', 'version_id', 'name'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function nameable()
    {
        return $this->morphTo();
    }
}
