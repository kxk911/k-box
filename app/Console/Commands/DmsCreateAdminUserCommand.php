<?php

namespace KBox\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use KBox\User;
use KBox\Capability;

/**
 * Creates admin user accounts
 */
final class DmsCreateAdminUserCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dms:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create the administration user of the DMS and will show the assigned password.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $the_username = $this->argument('email');
        $the_name = $this->argument('name');
        $the_password = $this->argument('password');

        $validator = \Validator::make(
            ['name' => $the_username],
            ['name' => 'email']
        );

        if ($validator->fails()) {
            $this->error("The specified username ($the_username) is not a valid mail address.");
            return 1;
        }

        $exists = ! is_null(User::findByEmail($the_username));

        if ($exists) {
            $this->error("The user ($the_username) already exists.");
            return 2;
        } else {
            $et_offset = strpos($the_username, '@');
            $nice_name = $et_offset !== false ? substr($the_username, 0, $et_offset) : $the_username;

            $the_user = User::create([
                'name' => ! is_null($the_name) ? $the_name : $nice_name,
                'email' => $the_username,
                'password' => \Hash::make($the_password)
            ]);

            $the_user->addCapabilities(Capability::$ADMIN);

            $this->line('');
            $this->line('The DMS Administration user has been created.');

            $this->line("  username: <comment>$the_username</comment>");
            $this->line("  password: <info>The chosen password</info>");
            $this->line('');

            return 0;
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
            ['email', InputArgument::REQUIRED, 'User email.'],
            ['password', InputArgument::REQUIRED, 'User password.'],
            ['name', InputArgument::OPTIONAL, 'User nicename.']
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
        ];
    }
}
