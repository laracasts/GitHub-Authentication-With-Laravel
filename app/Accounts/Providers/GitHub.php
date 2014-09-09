<?php namespace Laracasts\Accounts\Providers;

use Laracasts\Accounts\Providers\Contracts\Provider as ProviderInterface;
use Laracasts\User;

class GitHub extends Provider implements ProviderInterface {

    /**
     * @var string
     */
    protected $accessTokenUrl = 'https://github.com/login/oauth/access_token';

    /**
     * @return string
     */
    protected function getAccessTokenUrl()
    {
        return $this->accessTokenUrl;
    }

    /**
     * @return string
     */
    protected function getAuthorizationUrl()
    {
        $url = 'https://github.com/login/oauth/authorize?';

        return $url . http_build_query([
            'client_id' => $this->clientId,
            'scope' => 'user:email'
        ]);
    }

    /**
     * @param $token
     * @return mixed
     */
    protected function getUserByToken($token)
    {
        return $this->http->get('https://api.github.com/user', [
            'headers' => ['Authorization' => "token {$token}"]
        ]);
    }

    /**
     * @param array $user
     * @return mixed
     */
    protected function mapToUser(array $user)
    {
        // Reader: Be sensitive to the Eloquent dependency here.

        return new User([
            'username' => $user['login'],
            'email' => $user['email'],
            'avatar' => $user['avatar_url']
        ]);
    }
}