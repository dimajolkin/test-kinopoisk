<?php

namespace app\renderer;

use Psr\Http\Message\ResponseInterface;

interface RenderInterface
{
    public function render(ResponseInterface $response, $template, array $data = []);
}