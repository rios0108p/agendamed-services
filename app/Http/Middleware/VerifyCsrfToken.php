<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        'http://apirest-agendamed.com/login',
        'http://apirest-agendamed.com/registerPatient',
        'http://apirest-agendamed.com/patientsList'
    ];
}
