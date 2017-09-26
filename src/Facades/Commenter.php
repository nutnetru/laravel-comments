<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 26.09.17
 */

namespace Nutnet\LaravelComments\Facades;

use Illuminate\Support\Facades\Facade;

class Commenter extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nutnet-laravel-commenter';
    }
}
