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
        'check-house',
		'check-owner',
		'check-owner2',
		'housechk',
		'check-member',
		'member-assign',
		'member-dismiss',
		'memberabeden-add',
		'membersifaris-add', 
		'check-compostbin',
		'check-cbinowner',
    ];
}
