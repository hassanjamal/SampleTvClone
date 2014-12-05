<?php

class AdminController extends \AdminBaseController {

    /**
     * Admin Dashborad
     * @return [type] [description]
     */
    public function index()
    {
        $title = 'Site Dashborad';
        return View::make('admin.dashboard', compact('title'));
    }

    /**
     * Site configuration View
     * @return [type] [description]
     */
    public function getConfigure()
    {
        $title = 'Site Configuration';
        return View::make('admin.configure.index' , compact('title'));
    }

    /**
     * Site Configuration post method
     * @return [type] [description]
     */
    public function postConfigure()
    {
        $options = Input::all();
        foreach ($options as $name => $value)
        {
            Option::where('name', '=', $name )->update( array('value' => $value) );
        }
        return Redirect::route('admin.configure')->withSuccess('Configuration has been updated successfully');
    }

    public function edit()
    {
        return View::make('admin.profile');
    }

    public function update()
    {
        Admin::find( Auth::user()->id )->update(array(
            'name'     => Input::get('name'),
            'email'    => Input::get('email'),
            'password' => Hash::make( Input::get('password') )
        ));
        return Redirect::back()->with( 'message', 'Your profile has been updated!' );
    }

    public function logout()
    {
        Sentry::logout();
        return Redirect::route('shows');
    }
}