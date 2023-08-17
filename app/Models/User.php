<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'data_di_nascita',
        'email',
        'username',
        'password',
    ];

    protected $primaryKey = ['id'] ;// id (autoincrement?) dell'utente
    protected $guarded = [

        'livello'   //livello utente specifica cliente, staff, admin

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'username', /*forse da togliere da hidden*/
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
          automaticamente eloquent*/
        'name','surname','username','password', 'email' => 'string',
        'remember_token' => 'int',
        'data_di_nascita' => 'date'
    ];
    private mixed $role;//livello di autenticazione
    public function setRole($role):void { //setter per il role
        $this->role = $role;
    }
    public function getRole() { //getter per il role
        return $this->role;
    }

    public function hasRole($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }

}
