<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey='id';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'password',
        'imagen',
        'estatus'
    ];

    protected $guarded = [
        'id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    // public function logo() : Attribute
    // {
    //     return new Attribute(
    //         get: function() {
    //             // Validar si existe
    //             if ($this->imagen) {
    //                 // Regresar la ruta relativa
    //                 return Storage::url($this->imagen);
    //             } else {
    //                 // regresar una imagen por defecto
    //                 return asset('img.jpg');
    //             }
    //         },
    //     );
    // }
}
