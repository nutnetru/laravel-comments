<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 26.09.17
 */

namespace Nutnet\LaravelComments;

use Nutnet\LaravelComments\Services\Commenter;
use Plank\Metable\MetableServiceProvider;
use Actuallymab\LaravelComment\LaravelCommentServiceProvider;

/**
 * Class ServiceProvider
 * @package Nutnet\LaravelComments
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->register(MetableServiceProvider::class);
        $this->app->register(LaravelCommentServiceProvider::class);

        $this->app->singleton('nutnet-laravel-commenter', Commenter::class);
    }
}
