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
        'fecha_inicio',
        'fecha_fin',
        'precio_general',
        'precio_estudiantes',
        'precio_especialistas',
        'client_id',
        'user_id',
        'status',
        'company',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function clients()
    {
        return $this->belongsToMany(Cliente::class, 'eventos_clientes', 'event_id', 'client_id');
    }
    public function client()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
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
