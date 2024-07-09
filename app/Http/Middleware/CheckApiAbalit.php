<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\WrongAccessTokenException;
use Closure;
use DateTime;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\UpdateAppInfoJob;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;

use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

/*
|--------------------------------------------------------------------------
| CheckApiAbalit
|--------------------------------------------------------------------------
|
| Este middleware pretende ser una plantilla para Abalit dónde se
| verifica el acces_token si un usuario esta logeado.
| Esto se apoya en el uso de 'passport' de Laravel
| Este por tanto solo tendrá finalidad para la API.
|
| --
| Qui desiderat pacem, praeparet bellum
|
|
*/

class CheckApiAbalit
{
    private $user_id;
    protected $server;
    protected $tokens;

    public function __construct(ResourceServer $server, TokenRepository $tokens)
    {
        $this->server   = $server;
        $this->tokens   = $tokens;
        // variable global
        $this->user_id = 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Validación del TOKEN 👀
    |--------------------------------------------------------------------------
    |
    */

    public function handle(Request $request, Closure $next)
    {
        // Comprovar que l'user estigui verificar
        if (Auth::check()) {
            return $next($request);
        }

        // Sinó validem el token rebut
        if (!$this->validateToken($request)) {
            // throw new WrongAccessTokenException();
            dd('Invalid token');
        }

        // S'actualitza la request amb l'acces token i altres atributs
        $request = $this->addUserToRequest($request);
        if (!$request) {
            // throw new WrongAccessTokenException();
            dd('Missing token');
        }

        // LLancem job per actualitzar dades de la app
        // dispatch(new UpdateAppInfoJob(auth()->user(), request()->except(['media', 'file']), request()->segment(2)));

        return $next($request);
    }

    // validamos el token dado
    public function validateToken(Request $request)
    {
        // dd($request->barerToken());
        // $id = (new Parser(new JoseEncoder()))->parse($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])->claims()->all()['jti'];

        // dd($id);

        // $factory = new ResponseServer();
        // $psr = $factory->createServerRequest('POST',  $request);

        try {

            $server = app(ResourceServer::class);
            $psr = $server->validateAuthenticatedRequest((new PsrHttpFactory(
                new Psr17Factory,
                new Psr17Factory,
                new Psr17Factory,
                new Psr17Factory
            ))->createRequest($request));

            $psr = $this->server->validateAuthenticatedRequest($psr);

            $token = $this->tokens->find(
                $psr->getAttribute('oauth_access_token_id')
            );
            // Reasignem el user_id a la variable global
            $this->user_id = $token->user_id;

            $currentDate = now();

            // Validem que el token no estigui caducat
            if ($currentDate > new DateTime($token->expires_at)) {
                return false;
            }

            // Actualitzem el token
            $token->updated_at = $currentDate;

            // Definem la nova data de caducitat
            if ($currentDate->addDays(15) > $token->expires_at) {
                $token->expires_at = $token->expires_at->addDays(15);
            }

            // Guardem token
            $token->save();

            return true;
        } catch (OAuthServerException $e) {
            return false;
        }
    }

    // el usuario que nos ha desvelado el token deve ser guardado en el request y además en el usuario auth
    private function addUserToRequest(Request $request)
    {
        $user = User::find($this->user_id);
        $request->merge(['user' => $user]);
        try {
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

            // asiganmos el usuario auth
            Auth::setUser($user);

            // devolvemos nuestro request pero ademas con el usuario autenticado
            return $request;
        } catch (\Throwable $th) {
            // Log::info('Intent de autenticació amb contrasenya antiga');
            return false;
        }
    }
}