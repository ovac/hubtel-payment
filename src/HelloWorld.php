<?php

namespace OVAC/HubtelPayment;

/**
 * Class HelloWorld
 * @package OVAC/HubtelPayment
 */
class HelloWorld
{

    /**
     * @var string $name
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function sayHi()
    {
        return 'Hello ' . $this->name . '!';
    }
}
