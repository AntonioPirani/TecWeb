<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citta extends Model
{
//    use HasFactory;
    protected $fillable = [
        "istat",
		"comune",
		"regione",
		"provincia",
		"prefisso",
		"cod_fisco",
		"superficie",
		"num_residenti"
    ];
}
