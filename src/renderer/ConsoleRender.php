<?php

namespace app\renderer;


use Psr\Http\Message\ResponseInterface;

class ConsoleRender implements RenderInterface
{

    public function render(ResponseInterface $response, $template, array $data = [])
    {
        // TODO: Implement render() method.
    }
}