<?php namespace KlinkDMS\Console\Commands\Collections;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Finder\Finder;
use KlinkDMS\Import;
use KlinkDMS\User;
use KlinkDMS\File;
use KlinkDMS\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesCommands;
use KlinkDMS\Commands\ImportCommand;


class DmsCollectionsCommand extends Command {
	
	use DispatchesCommands;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'collections:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Performs actions on collections.';

	private $service = null;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(\Klink\DmsDocuments\DocumentsService $adapterService)
	{
		parent::__construct();
		$this->service = $adapterService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$debug = $this->getOutput()->getVerbosity() > 1;
        
        $grp_arg = $this->argument('collection');
        
        $group = is_null($grp_arg) ? null : Group::findOrFail( $grp_arg );
        
        $user = User::findOrFail( $this->option('user') );
        
        if(is_null($group)){
            $collections = $this->service->getCollectionsAccessibleByUser($user);
            
            $this->info('Personal collections');
            
            $this->printCollections($collections->personal);
            
            $this->info('Project collections');
            
        }
        else {
            $collections = $this->service->getCollectionsAccessibleByUserFrom($user, $group);
            
            $this->info('Accessible collections from ' . $group->id . ': ' . $group->name);
            
            $this->printCollections($collections);

        }
        
        


        return 0;
	}
    
    
    private function printCollections($collections){
        if(!empty($collections)){
                
                $headers = $collections->first()->attributesToArray();
                
                unset($headers['color']);
                unset($headers['position']);
                unset($headers['real_depth']);
                
                $headers = array_keys($headers);
                
                $collections = $collections->map(function($c){
                    
                    $vals = $c->toArray();
                    unset($vals['color']);
                    unset($vals['position']);
                    unset($vals['children']);
                    unset($vals['real_depth']);
                    return $vals;
                    
                });

                $this->table( $headers, $collections);
                
            }
            else {
                $this->info('No collections found under '. $group->name);
            }
    }
    

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['collection', InputArgument::OPTIONAL, 'The collections you want to operate on.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			// ['transfer', null, InputOption::VALUE_REQUIRED, 'Transfer the collection ownership to the specified user.', null],
			['user', 'u', InputOption::VALUE_REQUIRED, 'The user to impersonate', 1],
			// ['to-project', 'p', InputOption::VALUE_REQUIRED, 'Move the current collection to a specific Project collection and automatically makes it a project collection', null],
			// ['make-project', null, InputOption::VALUE_NONE, 'Makes the specified collection a project collection', null],
		];
	}
	
	
	
	
	
	
	/**
	 * Traverse a directory to get all sub-directories
	 */
	function directories($directory, $skip = null)
	{
		$directories = array();

		foreach (Finder::create()->in($directory)->directories()->exclude($skip) as $dir)
		{
			$directories[] = $dir->getPathname();
		}

		return $directories;
	}
	
	function files($directory, $exclude = null)
	{
		$directories = array();

		foreach (Finder::create()->in($directory)->files()->exclude($exclude) as $dir)
		{
			$directories[] = $dir->getPathname();
		}

		return $directories;
	}
	
	


}