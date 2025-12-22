<?php

namespace App\Models;

use App\Models\Pais;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
     protected $fillable=[
        'name',
        'description',
        'avatar',
        'user_id',
        'pais_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'company_users', 'company_id', 'user_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

   
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'company_id');
    }


    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('name', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->get();
    }



}
