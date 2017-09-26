## Extension for [actuallymab/laravel-comment](https://github.com/actuallymab/laravel-comment)

Original `laravel-comment` package is a good start point for creating commenting system on laravel, 
but package doesn't allow(out of the box) attach some meta about user or comment, or comment as guest. This extension fix this issues.
 
 
#### Install and configure
 
To install package, run:
 
```bash
composer require nutnet/laravel-comments
```

Next, enable package by adding service provider to your app config:

```php
// config/app.php
'providers' => [
    ...
    Nutnet\LaravelComments\ServiceProvider::class,
    ...
];
```

Optionally add alias for `Nutnet\LaravelComments\Facades\Commenter` facade.

#### Usage

All usage is identical to original package, except some moments:

1. Use `Nutnet\LaravelComments\CanComment` trait instead of original.
1. Use `Nutnet\LaravelComments\Models\Comment` model instead of original.

##### As authorized user:

```php
use Nutnet\LaravelComments\Services\Commenter;
use Nutnet\LaravelComments\Facades\Commenter as CommenterFacade;

// ... some other code

public function comment(Commenter $commenter)
{
    // variant 1
    $commenter->comment($product, 'Test comment', $user, ['meta' => 'test']);
    
    // variant 2, without meta
    $user->comment($product, 'Test comment', $rate);
    
    // variant 3
    CommenterFacade::comment($product, 'Test comment', $user, ['meta' => 'test']);
}
```

##### As guest:

```php
use Nutnet\LaravelComments\Services\Commenter;
use Nutnet\LaravelComments\Facades\Commenter as CommenterFacade;

// ... some other code

public function comment(Commenter $commenter)
{
    // variant 1
    $commenter->commentAsGuest($product, 'Test comment', ['meta' => 'test']);
    
    // variant 2, without meta
    CommenterFacade::commentAsGuest($product, 'Test comment', ['meta' => 'test']);
}
```