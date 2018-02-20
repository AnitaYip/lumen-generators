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
    protected $name = 'rp:repo';

    protected $description = 'Generates a Repository class for a RESTful resource';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('repository', $args, '/src/Repositories', 'Repository');
    }
}
