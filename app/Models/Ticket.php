<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
     use HasFactory;
     protected $fillable=[
        'client_id',
        'from_id',
        'company_id',
        'event_id',
        'event_name',
        'referencia',
        'monto',
        'fecha_inicio',
        'fecha_fin',
        'qr_code',
        'status',
    ];


    public function event()
    {
        return $this->belongsTo(Evento::class, 'event_id');
    }

   
    public function client()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }
    public function from()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }

    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }




    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('event_name', 'like', "%$query%")
        ->orWhere('status', 'like', "%$query%")
        ->orWhere('referencia', 'like', "%$query%")
        ->orWhereHas('client', function($q) use ($query) {
            $q->where('name', 'like', "%$query%");
        })
        ->orWhereHas('company', function($q) use ($query) {
            $q->where('name', 'like', "%$query%");
        })
        ->get();
    }



}
