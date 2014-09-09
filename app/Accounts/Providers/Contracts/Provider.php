<?php namespace Laracasts\Accounts\Providers\Contracts;

interface Provider {

    /**
     * @return mixed
     */
    public function authorize();

    /**
     * @param $code
     * @return mixed
     */
    public function user($code);

}