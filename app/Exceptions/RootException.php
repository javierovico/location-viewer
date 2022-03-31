<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RootException extends Exception{
    public string $codigo = 'CodigoDesconocido';
    public string $titulo = 'Titulo';
    public int $statusHTTP = Response::HTTP_INTERNAL_SERVER_ERROR;

    public static function createException($mensaje, $codigoString, $titulo, $statusHttp = Response::HTTP_INTERNAL_SERVER_ERROR) : self
    {
        $exception = new self($mensaje);
        $exception->codigo = $codigoString;
        $exception->titulo = $titulo;
        $exception->statusHTTP = $statusHttp;
        return $exception;
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return Controller::respuestaDTO(
            $this->titulo,
            $this->getMessage(),
            $this->codigo,
            ['class' => get_class($this)],
            $this->statusHTTP
        );
    }
}
