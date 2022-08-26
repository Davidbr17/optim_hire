<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = ['pivot','id'];

    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class);
    }
}
