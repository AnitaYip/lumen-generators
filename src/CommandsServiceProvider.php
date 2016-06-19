<?php namespace RealPage\Generators;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerModelCommand();
        $this->registerControllerCommand();
        $this->registerRouteCommand();
        $this->registerResourceCommand();
        $this->registerRepositoryInterfaceCommand();
        $this->registerRepositoryCommand();
        $this->registerSchemaCommand();
        $this->registerValidatorCommand();

    }

    protected function registerModelCommand(){
        $this->app->singleton('command.rp.model', function($app){
            return $app['RealPage\Generators\Commands\ModelCommand'];
        });
        $this->commands('command.rp.model');
    }

    protected function registerControllerCommand(){
        $this->app->singleton('command.rp.controller', function($app){
            return $app['RealPage\Generators\Commands\ControllerCommand'];
        });
        $this->commands('command.rp.controller');
    }

    protected function registerRouteCommand(){
        $this->app->singleton('command.rp.route', function($app){
            return $app['RealPage\Generators\Commands\RouteCommand'];
        });
        $this->commands('command.rp.route');
    }

    protected function registerResourceCommand(){
        $this->app->singleton('command.rp.resource', function($app){
            return $app['RealPage\Generators\Commands\ResourceCommand'];
        });
        $this->commands('command.rp.resource');
    }

    protected function registerRepositoryInterfaceCommand(){
        $this->app->singleton('command.rp.repositoryinterface', function($app){
            return $app['RealPage\Generators\Commands\RepositoryInterfaceCommand'];
        });
        $this->commands('command.rp.repositoryinterface');
    }

    protected function registerRepositoryCommand(){
        $this->app->singleton('command.rp.repository', function($app){
            return $app['RealPage\Generators\Commands\RepositoryCommand'];
        });
        $this->commands('command.rp.repository');
    }

    protected function registerSchemaCommand(){
        $this->app->singleton('command.rp.schema', function($app){
            return $app['RealPage\Generators\Commands\SchemaCommand'];
        });
        $this->commands('command.rp.schema');
    }

    protected function registerValidatorCommand(){
        $this->app->singleton('command.rp.validator', function($app){
            return $app['RealPage\Generators\Commands\ValidatorCommand'];
        });
        $this->commands('command.rp.validator');
    }

    protected function registerCleanResourceCommand(){
        $this->app->singleton('command.rp.clean-skeleton', function($app){
            return $app['RealPage\Generators\Commands\CleanResourceSkeletonCommand'];
        });
        $this->commands('command.rp.clean-skeleton');
    }
}
