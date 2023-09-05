<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Citta extends Model
{
    protected $table = 'cittas'; // Assuming your table name is 'cittas'

    protected $fillable = [
        'istat',
        'comune',
        'regione',
        'provincia',
        'prefisso',
        'cod_fisco',
        'superficie',
        'num_residenti',
    ];


}
