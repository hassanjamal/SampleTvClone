<?php namespace Authority\Mailers;

class UserMailer extends Mailer {

	/**
	 * Outline all the events this class will be listening for.
	 * @param  [type] $events
	 * @return void
	 */
	public function subscribe($events)
	{
		// $events->listen('user.signup', 		'Authority\Mailers\UserMailer@welcome');
		// $events->listen('user.resend', 		'Authority\Mailers\UserMailer@welcome');
		// $events->listen('user.forgot',      'Authority\Mailers\UserMailer@forgotPassword');
		// $events->listen('user.newpassword', 'Authority\Mailers\UserMailer@newPassword');
//		$events->listen('user.comment', 'Authority\Mailers\UserMailer@newComment');
	}

	/**
	 * Send a welcome email to a new user.
	 * @param  string $email
	 * @param  int    $userId
	 * @param  string $activationCode
	 * @return bool
	 */
	public function welcome($email, $userId, $activationCode)
	{
		$subject = 'Welcome to Laravel4 With Sentry';
		$view = 'emails.auth.welcome';
		$data['userId'] = $userId;
		$data['activationCode'] = $activationCode;
		$data['email'] = $email;

		return $this->sendTo($email, $subject, $view, $data );
	}

	/**
	 * Email Password Reset info to a user.
	 * @param  string $email
	 * @param  int    $userId
	 * @param  string $resetCode
	 * @return bool
	 */
	public function forgotPassword($email, $userId, $resetCode)
	{
		$subject = 'Password Reset Confirmation | Laravel4 With Sentry';
		$view = 'emails.auth.reset';
		$data['userId'] = $userId;
		$data['resetCode'] = $resetCode;
		$data['email'] = $email;

		return $this->sendTo($email, $subject, $view, $data );
	}

    /**
     * Email New Password info to user.
     * @param  string $email
     * @param $newPassword
     * @internal param int $userId
     * @internal param string $resetCode
     * @return bool
     */
	public function newPassword($email, $newPassword)
	{
		$subject = 'New Password Information | Laravel4 With Sentry';
		$view = 'emails.auth.newpassword';
		$data['newPassword'] = $newPassword;
		$data['email'] = $email;

		return $this->sendTo($email, $subject, $view, $data );
	}


	public function newComment($comment )
	{
		// return $comment->user;


		if($comment->show_id != NULL)
		{
			$view = 'emails.comments.comment';
			$comment = $comment->load("user","show");
		}
		if($comment->episode_id != NULL)
		{
			$view = 'emails.comments.commentEpisode';
			$comment = $comment->load("user","episode.show");
		}

        $email = \Option::select('value')->where('name','=','email')->first();
		$subject = 'New Comment added by '.$comment->user->first_name;

		$data['comment'] = $comment;

		return $this->sendTo($email->value, $subject, $view, $data );
	}



}
