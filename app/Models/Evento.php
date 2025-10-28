<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
     use HasFactory;
     protected $fillable=[
        'name',
        'description',
        'avatar',
        'client_id',
        'fecha_inicio',
        'fecha_fin',
        'precio_general',
        'precio_estudiantes',
        'precio_especialistas',
        'user_id',
        'status',
        'company',
    ];


    public function user()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('name', 'like', "%$query%")
        ->get();
    }

    
}
