<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiposdepago extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | goblan variables
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name', 
        'tipo',
        'bankAccount',
        'bankName',
        'email',
        'user',
        'ciorif',
        'telefono',
        'status',
        'company_id',
    ];

    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';

    public static function statusTypes()
    {
        return [
            self::ACTIVE, self::INACTIVE
        ];
    }

     public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
