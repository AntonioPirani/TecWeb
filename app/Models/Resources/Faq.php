<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model{
    protected $table = ['faq'];
    protected $primaryKey = ['id'];//identificatore faq


    protected $fillable = ['domanda'];

    protected $guarded = ['risposta'];//assegnamento non massivo

    public function getDomanda(){
        return Faq::select('domanda')->where('id',$this->primaryKey);//d
    }

    public function setDomanda(){

    }
}
