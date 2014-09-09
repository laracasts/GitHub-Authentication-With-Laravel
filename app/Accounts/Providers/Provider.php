<?php namespace Laracasts\Accounts\Providers;

use GuzzleHttp\ClientInterface;
use Illuminate\Routing\Redirector;

abstract class Provider {

    /**
     * @var Redirector
     */
    protected  $redirector;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var ClientInterface
     */
    protected $http;

    /**
     * @param Redirector $redirector
     * @param ClientInterface $http
     * @param $clientId
     * @param $clientSecret
     */
    public function __construct(Redirector $redirector, ClientInterface $http, $clientId, $clientSecret)
    {
        $this->redirector = $redirector;
        $this->http = $http;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    abstract protected function getAuthorizationUrl();

    /**
     * @return mixed
     */
    abstract protected function getAccessTokenUrl();

    /**
     * @param $token
     * @return mixed
     */
    abstract protected function getUserByToken($token);

    /**
     * @param array $user
     * @return mixed
     */
    abstract protected function mapToUser(array $user);

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authorize()
    {
        return $this->redirector->to($this->getAuthorizationUrl());
    }

    /**
     * @param $code
     * @return User
     */
    public function user($code)
    {
        // request that access token
        $token = $this->requestAccessToken($code);

        $user = $this->getUserByToken($token);

        return $this->mapToUser($user->json());
    }

    /**
     * @param $code
     */
    protected function requestAccessToken($code)
    {
        $response = $this->http->post($this->getAccessTokenUrl(), [
            'body'    => [
                'code'          => $code,
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret
            ],
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        return $response->json()['access_token'];
    }

} 