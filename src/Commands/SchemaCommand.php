<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 9:35 PM
 */

namespace RealPage\Generators\Commands;


class SchemaCommand extends BaseCommand
{
    protected $signature = 'rp:schema {name : Name of the model.}';

    protected $description = 'Generates a Schema class for a RESTful resource';

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('name')));

        $content = $this->getTemplate('schema')
            ->with([
                'model' => $name,
                'resource' => strtolower($name)
            ])
            ->get();

        $this->save($content, "./app/Schemas/{$name}/{$name}Schema.php");

        $this->info("{$name}Schema generated !");
    }

}