<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 9:35 PM
 */

namespace RealPage\Generators\Commands;


class RepositoryInterfaceCommand extends BaseCommand
{
    protected $signature = 'rp:repointf {name : Name of the model.}';

    protected $description = 'Generates a Repository interface for a RESTful resource';

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('name')));

        $content = $this->getTemplate('repositoryinterface')
            ->with(['model' => $name])
            ->get();

        $this->save($content, "./app/Repositories/{$name}/{$name}RepositoryInterface.php");

        $this->info("{$name}RepositoryInterface generated !");
    }

}