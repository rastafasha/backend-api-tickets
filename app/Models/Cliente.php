<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Payment;
use App\Traits\HavePermission;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Cliente extends Model implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'clientes';
    protected $guard_name = 'parent-api';

   use HasApiTokens, HasFactory, Notifiable, HavePermission,  HasRoles;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | goblan variables
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'n_doc',
        'role',
        //
        'surname',
        'mobile',
        'birth_date',
        'gender',
        'address',
        'avatar',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const GUEST = 'GUEST';
    const CLIENT = 'CLIENT';

    
    public function setCreatedAtAttribute($value)
    {
    	date_default_timezone_set('America/Caracas');
        $this->attributes["created_at"]= Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Caracas");
        $this->attributes["updated_at"]= Carbon::now();
    }


    /*
    |--------------------------------------------------------------------------
    | functions
    |--------------------------------------------------------------------------
    */

    public function isGuest()
    {
        return $this->role === Cliente::GUEST;
    }
    public function isClient()
    {
        return $this->role === Cliente::CLIENT;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */



    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'eventos_clientes', 'client_id', 'event_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    // buscador
    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('name', 'like', "%$query%")
        ->orWhere('surname', 'like', "%$query%")
        ->orWhere('email', 'like', "%$query%")
        ->orWhere('status', 'like', "%$query%")
        ->get();
    }
    
}
