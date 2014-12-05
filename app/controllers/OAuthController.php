<?php

use Cartalyst\Sentry\Users\UserInterface;

/**
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */
class OAuthController extends \BaseController {

    /**
     * Lists all available services to authenticate with.
     *
     * @return Illuminate\View\View
     */
    public function getIndex()
    {
        return Redirect::to('/login');
    }

    /**
     * Shows a link to authenticate a service.
     *
     * @param  string $serviceName
     * @return string
     */
    public function getAuthorize($serviceName)
    {
        $service = SentrySocial::make($serviceName, URL::to("oauth/callback/{$serviceName}"));

        return Redirect::to((string) $service->getAuthorizationUri());
    }

    /**
     * Handles authentication
     *
     * @param  string $serviceName
     * @throws Exception
     * @return mixed
     */
    public function getCallback($serviceName)
    {
        $service = SentrySocial::make($serviceName, URL::to("oauth/callback/{$serviceName}"));

        // If there is an error passed back from the OAuth service
        if ($error = Input::get('error'))
        {
            throw new Exception($error);
        }

        // If the user has denied access for the OAuth application
        if (Input::get('denied'))
        {
            throw new Exception("You have denied [$serviceName] access.");
        } // If we have an access code from an OAuth 2 service
        elseif ($code = Input::get('code'))
        {
            $access = $code;
        } // If we have request token and verifier from an OAuth 1 service
        elseif ($requestToken = Input::get('oauth_token'))
        {
            $access = array($requestToken, Input::get('oauth_verifier'));
        } // Otherwise, we'll abort now
        else App::abort(404);

        try
        {
            if (SentrySocial::authenticate($service, $access))
            {
                return Redirect::route('authenticated', $serviceName);
            }
        } catch (Exception $e)
        {
            return Redirect::to('oauth')->withErrors($e->getMessage());
        }
    }

    /**
     * Returns the "authenticated" view which simply shows the
     * authenticated user.
     *
     * @param $serviceName
     * @return mixed
     */
    public function getAuthenticated($serviceName)
    {
        if ( ! Sentry::check())
        {
            return Redirect::to('oauth')->withErrors('Not authenticated yet.');
        }

        $user = Sentry::getUser();
        // check if twitter is used to registered

        if ($serviceName === 'twitter')
        {
            Sentry::logout();
            $user->activated = 0;
            $user->save();

            return Redirect::route('twitterActivate', $user->id);
        }

        return Redirect::to('/login')->with('message', 'Welcome to TV Apps !!!');
    }

    public function getTwitteractivate($sentryUser)
    {
        $user = Sentry::findUserById($sentryUser);

        return View::make('users.twitter_email', compact('user'));
    }

    public function postTwitteractivate($userId)
    {
        $user            = Sentry::findUserById($userId);
        $user->email     = Input::get('email');
        $user->activated = 1;
        try
        {
            if ($user->save())
            {
                Sentry::login($user, false);

                return Redirect::to('/')->with('message', 'Welcome to TV Apps !!!');;
            }
        } catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            return Redirect::route('twitterActivate', $userId)->with('error', 'Email exist please enter different email id ');;
        }
    }

}
