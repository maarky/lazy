<?php


namespace maarky\Test\Lazy;


use maarky\Lazy\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    protected function getContainer($value): Container
    {
        $function = function() use($value) {
            return $value;
        };

        return new class($function) extends Container {

            public $count = 0;

            protected function fuckingDoItAlreadyForChristSake()
            {
                if(parent::fuckingDoItAlreadyForChristSake()) {
                    $this->count++;
                }
            }
        };
    }

    public function testGet()
    {
        $value = 'hello';
        $this->assertEquals($value, $this->getContainer($value)->get());
    }

    public function testGetTwice()
    {
        $value = 'hello hello';
        $container = $this->getContainer($value);
        $this->assertEquals($value, $container->get());
        $this->assertEquals($value, $container->get());
    }

    public function testInvoke()
    {
        $value = 'goodbye';
        $this->assertEquals($value, $this->getContainer($value)());
    }

    public function testOnlyDoesWorkOnce()
    {
        $container = $this->getContainer(['whatever']);

        $container->get();
        $container->get();
        $container->get();

        $this->assertEquals(1, $container->count);
    }
}
