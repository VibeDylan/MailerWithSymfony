<?php

namespace App\Event;



namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class SendMailEvent extends Event {


    /** Information reçue de la request une fois le mail soumis */
    private $contactInfo;

    public function __construct($contactInfo) {
        $this->contactInfo = $contactInfo;
    }

    public function getInfo() {
        return $this->contactInfo;
    }
}