<?php
namespace Bridge\Options;

class QueueGearmanWorker
{

    /**
     *  store worker
     */
    private $worker;

    /**
     *  options
     */
    private $options;

    /**
     *  worker init
     */
    public function __construct( $options=array() )
    {
/*
//
try {

}
catch (Exception $e) {
    echo 'Exception Message: ',  $e->getMessage(), "\n";
}

//
if (hasError()) {
    throw new Exception('Error: 0000000000');
}
*/


        $this->worker = new \GearmanWorker();
        $this->options = $options;

        $multipleServer = $this->options['servers'];
        foreach ($multipleServer as $server) {

            $mac = preg_split("/:/",$server);
            if ( !is_array($mac) ) {
                continue;
            }

            // $mac[0] is host or ip
            // $mac[1] is port
            if ( 1===count($mac) ) {
                $this->worker->addServer($mac[0]);
            }
            elseif ( 2===count($mac) ) {
                $this->worker->addServer($mac[0], $mac[1]);
            }
            else {
                $this->worker->addServer();
            }
        }
    }

    /**
     *  add function
     *
     *  @param  str  $service - service name
     *  @return bool
     */
    public function addFunction( $function )
    {
        $service = $this->options['services'];
        if (!in_array($function, $service)) {
            return false;
        }
        return $this->worker->addFunction( $function, "{$function}_worker" );
    }

    /**
     *  
     */
    public function run()
    {
        if ( !defined('GEARMAN_SUCCESS') ) {
            die('7102502 extend not fund!');
        }

        while ( $this->worker->work() || GEARMAN_TIMEOUT == $this->worker->returnCode() ) {
            if( $this->worker->returnCode() !== GEARMAN_SUCCESS ) {
                // TODO: to log, not show in web page
                // echo "Fail! return code: {$this->worker->returnCode()}\n";
                throw new Exception("Fail! return code: {$this->worker->returnCode()}");
                break;
            }
        }
    }
    
}

