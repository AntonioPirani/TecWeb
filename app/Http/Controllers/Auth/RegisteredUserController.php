<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $indirizzo = $this->combineAddress(
            $request->via,
            $request->citta,
            $request->provincia,
            $request->stato
        );

        $user = User::create([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'dataNascita' => $request->dataNascita,
            'occupazione' => $request->occupazione,
            'indirizzo' => $indirizzo,
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);
    
        return redirect(RouteServiceProvider::HOME);
    }

    private function combineAddress($via, $citta, $provincia, $stato)
    {
        return "{$via}, {$citta}, {$provincia}, {$stato}";
    }

}
