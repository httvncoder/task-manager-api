<?php

use \Codeception\Event\SuiteEvent;
use \Codeception\Event\TestEvent;
use Codeception\Lib\Console\Output;
use \Codeception\Platform\Extension;
use \Illuminate\Support\Facades\Artisan;

/**
 * Class Laravel5Extension
 */
class Laravel5Extension extends Extension
{
    public $db_connection;
    public $db_sqlite_database;

    /*
    |--------------------------------------------------------------------------
    | Event Listeners
    |--------------------------------------------------------------------------
    |
    */

    public static $events = [
        'suite.before' => 'beforeSuite',
        'test.before' => 'beforeTest',
    ];

    /*
    |--------------------------------------------------------------------------
    | Event Handlers
    |--------------------------------------------------------------------------
    |
    */

    /**
     * before each suite runs
     * ... create sqlite file if needed
     *
     * @param SuiteEvent $e
     * @return bool
     */
    public function beforeSuite(SuiteEvent $e)
    {
        $this->db_connection = $this->config['db_connection'] ?? "sqlite_testing";
        $this->db_sqlite_database = $this->config['db_sqlite_database'] ?? "storage/testing.sqlite";

        // if using sqlite

        if (in_array($this->db_connection, [ "sqlite", "sqlite_testing" ])) {

            // ... create sqlite file if it doesn't exist

            if(!file_exists($this->db_sqlite_database)) {
                touch($this->db_sqlite_database);
            }
        }
    }

    /**
     * before each test runs
     * ... migrate if no migration
     * ... reset if migration already run
     * ... seed databases
     *
     * @param TestEvent $e
     * @return bool
     */
    public function beforeTest(TestEvent $e)
    {
        // instantiate Codeception console output
        $output = new Output([]);

        // get laravel5 module
        $l5 = $this->getModule('Laravel5');

        // output error and die if transaction mode is active (this extension does not work with Laravel 5 transaction mode) TODO: figure out why
        if ( $l5->config['cleanup'] ) {
            $output->writeln("\n\e[41m" . "Please set Laravel5 Codeception module's cleanup to false before using Laravel5Extensions." . "\e[0m");
            die();
        }

        // get current migration status
        Artisan::call('migrate:status', ['--database' => $this->db_connection]);
        $status = Artisan::output();
        //var_dump($status);die();

        // ... if no migrations the run migrate
        if ( str_contains( $status, "No migrations found") ) {

            Artisan::call('migrate', ['--database' => $this->db_connection]);
            //$result = Artisan::output();
            //var_dump($result);die();
        }

        // ... else if migrations already exist
        else {

            Artisan::call('migrate:refresh', ['--database' => $this->db_connection]);
            //$result = Artisan::output();
            //var_dump($result);die();
        }

        // seed
        Artisan::call('db:seed', ['--database' => $this->db_connection]);
        //$result = Artisan::output();
        //var_dump($result);die();
    }
}
?>