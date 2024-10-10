<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\UsuarioModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use GuzzleHttp\Client;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = UsuarioModel::where('email', $request->email)->first();

        // if (!$this->validateReCaptcha($request)) {
        //     return back()->withErrors(['captcha' => 'Error en la validación de reCAPTCHA.'])->onlyInput('email');
        // }
        if (!$user || !$user->estado) {
            return back()->withErrors([
                'email' => 'Su cuenta está inactiva. Por favor, contacte con el administrador.',
            ])->onlyInput('email');
        }
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function validateReCaptcha(Request $request)
    {
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
            ]
        ]);

        $body = json_decode((string)$response->getBody());
        return $body->success;
    }
}
