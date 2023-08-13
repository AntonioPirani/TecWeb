<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'utente';

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

    protected $guarded = [
        'id', // id (autoincrement?) dell'utente
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
        'name','surname','username','password', 'email' => 'string',
        'remember_token' => 'int',
        'data_di_nascita' => 'date'
    ];

    public function hasRole($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }

}
