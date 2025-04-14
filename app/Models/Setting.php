<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    protected $fillable = ['key', 'value', 'default', 'type', 'options'];

    public static function value($key)
    {
        return Setting::where('key', $key)->first()->value ?? null;
    }
}
