<?php

namespace Library\Contracts;

use Library\Http\Request;
use Library\Http\Response;

interface ControllerLifecycle
{
   public function beforeAction(Request $request): void;

   public function afterAction(Request $request, Response $response): Response;

}