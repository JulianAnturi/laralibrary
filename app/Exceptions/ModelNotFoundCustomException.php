<?php

namespace App\Exceptions;

use Exception;

class ModelNotFoundCustomException extends Exception
{
    public function __construct($modelName)
    {
        parent::__construct("El {$modelName} no fue encontrado, es posible que se haya eliminado.");
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage()
        ], 404);
    }
}
