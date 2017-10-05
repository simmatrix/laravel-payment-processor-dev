<?php

use Illuminate\FileSystem\Filesystem;
use Illuminate\FileSystem\ClassFinder;
use Models\TestPayment;
use Adapter\MyBeneficiaryAdapter;
use Simmatrix\PaymentProcessor\Factory\HSBC\HSBCCOSUploadProcessorFactory;
use Simmatrix\PaymentProcessor\Factory\UOB\UOBCOSUploadProcessorFactory;

use Simmatrix\PaymentProcessor\Adapter\Result\HSBC\HSBCCOSResultAdapter;

class TestFileGenerator extends Orchestra\Testbench\TestCase{

    public function setUp(){
        parent::setUp();
        $this->app['config']->set('database.default','sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');
        //read from the tests/config file.
        $config = require 'config/cos_processor_test.php';
        $this -> app['config'] -> set('cos_processor', ['hsbc_example' => $config['hsbc_example'], 'uob_example' => $config['uob_example']]);

        $this -> migrate();
    }

    /**
     * run package database migrations
     *
     * @return void
     */
    public function migrate()
    {
        $fileSystem = new Filesystem;
        $classFinder = new ClassFinder;

        foreach($fileSystem->files(__DIR__ . "/migrations") as $file)
        {
            $fileSystem->requireOnce($file);
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->up();
        }
        foreach($fileSystem->files(__DIR__ . "/seeds") as $file)
        {
            $fileSystem->requireOnce($file);
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->run();
        }
    }

    public function testHSBCDownload(){
        //create an array of BeneficiaryAdapterInterface
        $beneficiaries = TestPayment::all();
        $cos = HSBCCOSUploadProcessorFactory::create($beneficiaries, 'cos_processor.hsbc_example');
        echo $cos -> getString();
    }

    public function testUOBDownload(){
        //create an array of BeneficiaryAdapterInterface
        $beneficiaries = TestPayment::all();

        $cos = UOBCOSUploadProcessorFactory::create($beneficiaries, 'cos_processor.uob_example');
        $string = $cos -> getString();
        //every line in a uob file except the first, must be exactly 900 characters wide
        $i = 0;
        foreach(explode("\r\n", $string) as $line){
            if($i++ >= 1){
                $this -> assertEquals(900, strlen($line));
            }
        }

    }

    public function testHSBCUpload(){

        //the first line is the Header
        $handle = fopen( __DIR__ ."/ifile_result.csv", "r");
        $index = 0;
        $results = [];
        while (($line = fgets($handle)) !== false) {
            if( $index++ !== 0){
                $adapter = new HSBCCOSResultAdapter($line);
                $results[] = $adapter -> getCosResult();
            }
        }
        fclose($handle);

        $this -> assertEquals("ABU BIN BAKAR", $results[0] -> fullname);
        $this -> assertEquals(200, $results[1] -> amount);
        $this -> assertEquals(123458, $results[2] -> paymentId);
        $this -> assertEquals('CIFB04008522', $results[3] -> transactionId);
        $this -> assertEquals('IFILEPYT_1445567761', $results[4] -> fileIdentifier);
        $this -> assertEquals(\DateTime::createFromFormat('Y-m-d', '2015-11-05'), $results[4] -> dateTime);

    }


}
