<?php
namespace Devtech\License;
/**
 * Description of License
 * 
 * Definition of License
 * 
 * @author jpuchky
 * 
 */
class License {
    public $name;
    public $date;
    public $application;
    public $id;
    public $hostname;
    
    function __construct($name, $date, $application, $id, $hostname) {
        $this->name = $name;
        $this->date = $date;
        $this->application = $application;
        $this->id = $id;
        $this->hostname = $hostname;
    }

    public function __toString() {
        return json_encode($this);
    }

}
