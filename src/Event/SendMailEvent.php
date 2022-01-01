<?php

namespace App\Event;



namespace App\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class SendMailEvent extends Event {

    private $contactInfo;

    public function __construct($contactInfo) {
        $this->contactInfo = $contactInfo;
    }

    public function getInfo() {
        return $this->contactInfo;
    }
}