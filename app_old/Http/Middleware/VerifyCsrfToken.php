<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/login',
        '/api/register',
        '/api/password/email',
        '/api/password/reset',
        '/api/orders',
        '/api/setOrder',
        '/api/getOrder',
        '/api/setOrderNew',
        '/api/getAllOrders',
        '/api/updateCustomer',
        '/api/updateCoordinates',
        '/api/partnerResponse',
        '/api/payment',
        '/api/order-cancel',
        '/api/update-devicetoken',

    ];
}
