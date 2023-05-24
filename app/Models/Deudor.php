<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deudor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'deudor_id', 'id');
    }
}
