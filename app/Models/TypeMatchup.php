<?php

namespace App\Models;

use App\Traits\HasVersion;

use Illuminate\Database\Eloquent\Model;

class TypeMatchup extends Model
{
    use HasVersion;
    
    protected $fillable = ['attacking_type_id', 'defending_type_id', 'effectiveness'];

    public function attackingType()
    {
        return $this->belongsTo(Type::class, 'attacking_type_id');
    }

    public function defendingType()
    {
        return $this->belongsTo(Type::class, 'defending_type_id');
    }
}
