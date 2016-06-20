# Lumen generators

## Overview

Generates the skeleton for REST APIs for enterprise services in Lumen as per RP's standards.

## Installation

Add the generators package to your composer.json by running the command:

`composer require realpage/lumen-generators --dev`

Then register the Service Provider in bootstrap/app.php by adding the below lines

```php
if (class_exists('RealPage\Generators\CommandsServiceProvider') && $app->environment() == 'local') {
    $app->register(\RealPage\Generators\CommandsServiceProvider::class);
}
```
Now, if you run the command `php artisan list` you will see the list of added commands:

```
 rp
  rp:clean-skeleton  Cleans the resource template files out of the project
  rp:controller      Generates RESTful controller using the ApiController trait
  rp:model           Generates a model class for a RESTful resource
  rp:repo            Generates a Repository class for a RESTful resource
  rp:repointf        Generates a Repository interface for a RESTful resource
  rp:resource        Generates a model, controller, repository interface, repository, schema (json), validator and routes for RESTful resource
  rp:route           Generates RESTful routes.
  rp:schema          Generates a Schema class for a RESTful resource
  rp:validator       Generates a Validator interface for a RESTful resource
```

## Example
To generate the skeleton of all the required classes/interfaces to build an enterprise service CRUD APIs for Property entity,

```
php artisan rp:resource Property
```

This generates the following classes under corresponding directories:

- A controller using ApiControllerTrait from enterprise-services-base
- An eloquent model class with bare minimal structure
- A schema class for JSON-API
- A validator extending ApiValidator from enterprise-services-base
- Repository interface and a repository class using ApiRepositoryTrait from enterprise-services-base
- Routes file with all the RESTful routes for the given entity

## What's Next?

Once the skeleton is in place, create/update the below files to continue with the development

- Add the app/Http/Routes/<Entity>Routes.php to app/Http/routes.php file
- Bind the RepositoryInterface to Repository class in AppServiceProvider
- Add the validator.<resourceentity> to routeMiddleware section of bootstrap/app.php
- Create the migrate and a seeder if required
- Create unit tests
- Add api documentation using ApiBlueprint
- Go through the app/Http/Routes/<Entity>Routes.php to make sure your API supports all those routes
- Review app/Repositories/<Entity>/<Entity>RepositoryInterface to make sure that your API supports all those operations.
- Add any new routes and corresponding functionalities specific to the entity for which you are building the APIs.
