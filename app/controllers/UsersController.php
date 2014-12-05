<?php

use Authority\Repo\Session\SessionInterface;
use Authority\Service\Form\Login\LoginForm;
use Authority\Service\Form\User\UserForm;
use Authority\Service\Form\Register\RegisterForm;


class UsersController extends \BaseController {

    /**
     * Member Vars
     */
    protected $session;
    protected $loginForm;
    protected $userForm;
    protected $registerForm;


    /**
     * Constructor
     * @param SessionInterface $session
     * @param LoginForm $loginForm
     * @param UserForm $userForm
     * @param RegisterForm $registerForm
     */
    public function __construct(SessionInterface $session, LoginForm $loginForm, UserForm $userForm, RegisterForm $registerForm)
    {
        parent::__construct();
        $this->session      = $session;
        $this->loginForm    = $loginForm;
        $this->userForm     = $userForm;
        $this->registerForm = $registerForm;
    }


    /**
     * Display a listing of the resource.
     * GET /users
     *
     * @return Response
     */
    public function index()
    {
        $user = User::find(Sentry::getUser()->id)->load(
                    array(
                        'episodeLinkRequests.episode.show',
                        'episodeLinks.episode.show',
                        'favourites.episode.show',
                        'watchlist.episode.show',
                        'favouriteShows.show',
                        'watchlistShow.show',
                        'watched.episode.show',
                        'watchedShow.show'
                    )
                );
        return View::make('users.dashboard' , compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /users/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make('users.register');
    }

    /**
     * Register a new User
     * POST /users
     *
     * @return Response
     */
    public function store()
    {
        // Form Processing
        $result = $this->registerForm->save(Input::all());

        if ($result['success'])
        {
//            Event::fire('user.signup', array(
//                'email'          => $result['mailData']['email'],
//                'userId'         => $result['mailData']['userId'],
//                'activationCode' => $result['mailData']['activationCode']
//            ));

            // Success!
            Session::flash('success', $result['message']);
            $this->loginForm->save(Input::all());
            return Redirect::route('dashboard');

        } else
        {
            Session::flash('error', $result['message']);

            return Redirect::action('UserController@create')
                ->withInput()
                ->withErrors($this->registerForm->errors());
        }

    }

    public function login()
    {
        return View::make('users.login');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function loginCheck()
    {

        $result = $this->loginForm->save(Input::all());

        if ($result['success'])
        {

            if (Sentry::getUser()->isSuperUser()) {
                return Redirect::intended('admin');
            }
            else {
                return Redirect::intended('dashboard');
            }} 
        else {
            Session::flash('error', $result['message']);

            return Redirect::to('login')
                ->withInput()
                ->withErrors($this->loginForm->errors());
        }
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {

        $this->session->destroy();

        return Redirect::to('/');
    }


    /**
     * Display the specified resource.
     * GET /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /users/{id}/edit
     *
     * @internal param int $id
     * @return Response
     */
    public function edit()
    {
        return View::make('dashboard');
    }

    /**
     * Update the specified resource in storage.
     * PUT /users/{id}
     *
     * @internal param int $id
     * @return Response
     */
    public function update()
    {

        $result = $this->userForm->update(Input::all());

        if ($result['success'])
        {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::back()->with('message', 'Your profile has been updated!');

        } else
        {
            Session::flash('error', $result['message']);

            return Redirect::back()->withInput()->withErrors($this->userForm->errors());
        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
