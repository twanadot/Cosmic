<?php
namespace App\Middleware;

class CsrfMiddleware extends \Pecee\Http\Middleware\BaseCsrfVerifier
{
    public const POST_KEY = 'csrftoken';
  
    // except post requests
    protected $except = ['/settings/namechange/availability', 'housekeeping/*'];
<<<<<<< HEAD
}
=======
}
>>>>>>> f1fa66ee54e5909275646b77b84856f3130c9481
