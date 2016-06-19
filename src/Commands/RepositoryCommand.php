<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 9:35 PM
 */

namespace RealPage\Generators\Commands;


class RepositoryCommand extends BaseCommand
{
    protected $signature = 'rp:repo {name : Name of the model.}';

    protected $description = 'Generates a Repository class for a RESTful resource';

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('name')));

        $content = $this->getTemplate('repository')
            ->with([
                'model' => $name,
                'modelObj' => camel_case($name)
            ])
            ->get();

        $this->save($content, "./app/Repositories/{$name}/{$name}Repository.php");

        $this->info("{$name}Repository generated !");
    }
}
