<?php namespace Laracasts\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticator;
use Illuminate\Routing\Controller;
use Laracasts\Accounts\Providers\Contracts\Provider;
use Input;

class HomeController extends Controller {

    /**
     * @var Provider
     */
    private $provider;

    /**
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return mixed
     */
    public function authorize()
    {
        // This will send the user to the proper
        // authorization page for the provider.
        return $this->provider->authorize();
    }

    /**
     * @param Authenticator $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Authenticator $auth)
    {
        // Let's fetch the user's info from the provider.
        $user = $this->provider->user(Input::get('code'));

        // Then, once you have your user, you can do whatever.
        // Create a row in your users table...save an access key...
        // you could even just store their info in the session.
        // It's up to you.

        // Finally, log the user in.
        $auth->login($user);

        // And redirect wherever you wish.
        //return redirect();
    }

}
