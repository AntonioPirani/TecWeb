<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model {
    protected $table = 'faq';
    protected $primaryKey = 'id'; // Identificatore faq

    protected $fillable = ['domanda', 'risposta'];
}
