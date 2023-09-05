<?php

namespace App\Models;

use App\Models\Resources\Prenotazione;
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
        'dataNascita',
        'occupazione',
        'indirizzo',
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

    //Per i file in resources\views\shared
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function hasRole($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }

    public function prenotazioni()
    {
        return $this->hasMany(Prenotazione::class, 'userId', 'id');
    }

}
