<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user not logged in, force back to login
        // Note: Don't redirect to auth again, because it will be infinite loop!
        // if (session()->get('id') === null && !str_contains(base_url(current_url()), 'auth/login')) {
        //     return redirect()->to(base_url('auth/login'));
        // }

        // Check if user already authenticated, redirect to entry point of the url
        // If user want to go back to login page, force back to entry point
        // The statement above will prevent us from infinite loop
        // if (session()->get('id') && str_contains(base_url(current_url()), 'auth/login')) {
        //     return redirect()->to(base_url());
        // }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}