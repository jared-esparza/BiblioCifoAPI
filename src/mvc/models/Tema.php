<?php
#[\AllowDynamicProperties]

class Tema extends Model{
    protected static $fillable = ["tema", "descripcion"];

    public function validate():array{
        $errores = [];
        if($this->tema == "test_error"){
            $errores['tema'] = "Error en el nombre del tema";
        }
        if($this->descripcion == "test_error"){
            $errores['descripcion'] = "Error en la descripcion del tema";
        }

        return $errores;
    }
}