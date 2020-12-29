<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Laravel\Passport\Http\Middleware\CheckClientCredentials as PassportClientCredentials;
use App\PassportClient as ClientModel;

class CheckClientCredentials extends PassportClientCredentials
{
	public function __construct(ResourceServer $server, TokenRepository $repository)
	{
		parent::__construct($server, $repository);
	}    /**
	* Handle an incoming request.
	*
	* @param \Illuminate\Http\Request $request
	* @param \Closure $next
	* @param mixed ...$scopes
	* @return mixed
	* @throws AuthenticationException
	* @throws \Laravel\Passport\Exceptions\MissingScopeException
	*/
	public function handle($request, Closure $next, ...$scopes)
	{
		// return ($request->bearerToken());
		// die;
		$psr = (new PsrHttpFactory(
            new ServerRequestFactory,
            new StreamFactory,
            new UploadedFileFactory,
            new ResponseFactory
        ))->createRequest($request);

        try {
            $psr = $this->server->validateAuthenticatedRequest($psr);
            $client = ClientModel::find($psr->getAttribute('oauth_client_id'));
            if (empty($client)) {
            	return response()->json(array(
		            'status_code' => 422,
		            'status_name' => 'Client not found',
		            'data' => null,
		        ), 422);
            }
            $request->request->set('client_id', $client->id ?? null); //$request->get('client_id');
            $request->request->set('client_name', $client->name ?? null );

        } catch (OAuthServerException $e) {
            // throw new AuthenticationException;
	        return response()->json(array(
	            'status_code' => 401,
	            'status_name' => 'Unauthenticated',
	            'data' => $e->getMessage(),
	        ), 401);
        }

        $this->validate($psr, $scopes);

        return $next($request);
		
	}
}