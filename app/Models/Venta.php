<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class)
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deuda()
    {
        return $this->belongsTo(Deudor::class, 'deudor_id', 'id');
    }

}
