<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'utenti';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'username',
        'password',
        'role',
    ];

    //Offset error
    //protected $primaryKey = ['id'] ;// id (autoincrement?) dell'utente

    //NB: nel db livello come campo non c'è (role)
    protected $guarded = [

        'livello'   //livello utente specifica cliente, staff, admin

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
        //aggiunta
         /*in realta non serve specificare che questi
          attributi diventano string perche lo fa
          automaticamente eloquent

          'name','surname','username','password', 'email' => 'string',
          'remember_token' => 'int',
          'data_di_nascita' => 'date'*/
    ];

    /*
    Se lascio questo codice mi da errore dicendo che role viene accesso prima della inizializzazione dello user

    private mixed $role;//livello di autenticazione
    public function setRole($role):void { //setter per il role
        $this->role = $role;
    }
    public function getRole() { //getter per il role
        return $this->role;
    }
    */

    public function hasRole($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }



}
