<?php
/**
 * This file is part of the BEAR.Resource package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Resource;

use Doctrine\Common\Annotations\AnnotationReader;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Doctrine\Common\Annotations\Reader;

class ResourceClientFactory
{
    /**
     * @var Injector
     */
    private $injector;

    public function __construct()
    {
        $this->injector = new Injector;
    }

    /**
     * @param string         $tmpDir
     * @param string         $namespace
     * @param AbstractModule $module
     *
     * @return Resource
     */
    public function newClient($tmpDir, $namespace, AbstractModule $module = null)
    {
        $this->injector = $module ? new Injector($module, $tmpDir) : new Injector(null, $tmpDir);

        return $this->newInstance($namespace, new AnnotationReader);
    }

    /**
     * @param string           $namespace
     * @param Reader           $reader
     * @param SchemeCollection $scheme
     * @param AbstractModule   $module
     *
     * @return \BEAR\Resource\Resource
     *
     * @deprecated use newClient
     */
    public function newInstance($namespace, Reader $reader, SchemeCollection $scheme = null)
    {
        $scheme = $scheme ?: $scheme = (new SchemeCollection)
            ->scheme('app')->host('self')->toAdapter(new AppAdapter($this->injector, $namespace, 'Resource\App'))
            ->scheme('page')->host('self')->toAdapter(new AppAdapter($this->injector, $namespace, 'Resource\Page'));
        $invoker = new Invoker(new NamedParameter);
        $factory = new Factory($scheme);
        $resource = new Resource(
            $factory,
            $invoker,
            new Anchor($reader),
            new Linker($reader, $invoker, $factory)
        );

        return $resource;
    }
}
