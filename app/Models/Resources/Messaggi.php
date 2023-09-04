<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messaggi extends Model
{
    protected $table = 'messaggi';

    protected $fillable = ['userId', 'userMessage', 'adminResponse','hasResponse'];
    use HasFactory;
}
