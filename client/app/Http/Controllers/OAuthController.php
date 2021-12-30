<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    public function redirect(Request $request)
    {

        $request->session()->put('state', $state = Str::random(40));

        $queries = http_build_query([
            'client_id' => env('OAUTH_SERVER_ID'),
            'redirect_uri' => env('OAUTH_SERVER_REDIRECT'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect(env('OAUTH_SERVER_URI') . '/oauth/authorize?' . $queries);
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );


      
        $response = Http::asForm()->post(env('OAUTH_SERVER_URI') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('OAUTH_SERVER_ID'),
            'client_secret' => env('OAUTH_SERVER_SECRET'),
            'redirect_uri' => env('OAUTH_SERVER_REDIRECT'),
            'code' => $request->code
        ]);

        $response = $response->json();

        $request->user()->token()->delete();

        $request->user()->token()->create([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect('/home');
    }

    public function refresh(Request $request)
    {
        $response = Http::post(config('services.oauth_server.uri') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->user()->token->refresh_token,
            'client_id' => config('services.oauth_server.client_id'),
            'client_secret' => config('services.oauth_server.client_secret'),
            'redirect_uri' => config('services.oauth_server.redirect'),
            'scope' => 'view-posts'
        ]);

        if ($response->status() !== 200) {
            $request->user()->token()->delete();

            return redirect('/home')
                ->withStatus('Authorization failed from OAuth server.');
        }

        $response = $response->json();
        $request->user()->token()->update([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect('/home');
    }
}