<?php

namespace app\actions;


use app\renderer\RenderInterface;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class AbstractAction
{
    /** @var  RenderInterface */
    protected $render;

    /** @var  ContainerInterface */
    protected $container;

    /**
     * MainAction constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->render = $container->get('view');
    }


    abstract public function __invoke(Request $request, Response $response);
}