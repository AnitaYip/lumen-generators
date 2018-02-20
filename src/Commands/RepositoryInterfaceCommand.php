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
    protected $name = 'rp:repointf';

    protected $description = 'Generates a Repository interface for a RESTful resource';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('repositoryinterface', $args, '/src/Repositories', 'RepositoryInterface');
    }
}
