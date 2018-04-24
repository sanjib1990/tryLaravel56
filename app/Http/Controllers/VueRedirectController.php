<?php

namespace App\Http\Controllers;

/**
 * Class VueRedirectController
 *
 * @package App\Http\Controllers
 */
class VueRedirectController extends Controller
{
    /**
     * VueRedirectController constructor.
     */
    public function __construct()
    {
    }

    /**
     * Redirect to vue index page.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return view('vue.index');
    }
}
