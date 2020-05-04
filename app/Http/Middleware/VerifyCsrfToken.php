<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'delete-service',
        'delete-user',
        'delete-employee',
        'app-login',
        'app-client-register',
        'app-barber-register',
        'app-create-service',
        'app-save-gallery',
        'app-update-profile',
        'app-add-review',
        'app-update-barber-info',
        'app-update-client-profile',
        'app-make-booking',
        'app-cng-barber-pass',
        'app-reset-forgotten-password',
        'app-saloon-register',
        'app-update-service',
        'app-invite-with-email',
        'app-add-payment',
        'app-subscription-barber',
        'app-subscription-user',
    ];
}
