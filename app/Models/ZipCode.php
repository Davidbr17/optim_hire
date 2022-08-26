<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = ['id','federal_entity_id','municipality_id'];

    public function settlements(){
        return $this->belongsToMany('App\Models\Settlement')->with('settlementType');
    }

    public function federalEntity()
    {
        return $this->belongsTo(FederalEntity::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
