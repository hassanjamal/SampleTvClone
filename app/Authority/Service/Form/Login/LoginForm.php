<?php namespace Authority\Service\Form\Login;

use Authority\Service\Validation\ValidableInterface;
use Authority\Repo\Session\SessionInterface;

class LoginForm {

    protected $data;

    protected $validator;

    protected $session;

    /**
     * @param ValidableInterface $validator
     * @param SessionInterface $session
     */
    public function __construct(ValidableInterface $validator, SessionInterface $session)
    {
        $this->validator = $validator;
        $this->session   = $session;

    }

    /**
     * Create a new session
     *
     * @param array $input
     * @return integer
     */
    public function save(array $input)
    {
        if ( ! $this->valid($input))
        {
            return false;
        }

        return $this->session->store($input);
    }

    /**
     * Return any validation errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * Test if form validator passes
     *
     * @param array $input
     * @return boolean
     */
    protected function valid(array $input)
    {

        return $this->validator->with($input)->passes();

    }


}