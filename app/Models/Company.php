<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
     protected $fillable=[
        'name',
        'description',
        'avatar',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'company_users', 'company_id', 'user_id');
    }

   
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'event_id');
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
