<?php

namespace BEAR\Resource\Mock;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;

/**
 * Framework default module
 */
class MockModule extends AbstractModule
{
    public function __construct(InjectorInterface $injector){
        $this->injector = $injector;
        $this->configure();
    }

    protected function configure()
    {
        $this->bind('Ray\Di\InjectorInterface')->toInstance($this->injector);
        $this->bind('Ray\Di\ConfigInterface')->toInstance($this->injector->getContainer()->getForge()->getConfig());
        $this->bind('BEAR\Resource\Resource')->to('BEAR\Resource\Client');
        $this->bind('BEAR\Resource\Invokable')->to('BEAR\Resource\Invoker');
    }
}