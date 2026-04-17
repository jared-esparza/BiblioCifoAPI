<?php
#[\AllowDynamicProperties]

class Socio extends Model{
    protected static $fillable = ["dni", "nombre", "apellidos", "nacimiento", "email",
        "direccion", "cp", "poblacion", "provincia", "telefono", "foto", "conformidad"];

    public function validate():array{
        $errores = [];

        if(empty($this->dni)){
            $errores['dni'] = "El DNI es obligatorio";
        }elseif(!preg_match('/^[0-9]{8}[A-Za-z]$/', $this->dni)){
            $errores['dni'] = "Formato de DNI incorrecto";
        }

        if(empty($this->nombre)){
            $errores['nombre'] = "El nombre es obligatorio";
        }

        if(empty($this->apellidos)){
            $errores['apellidos'] = "Los apellidos son obligatorios";
        }

        if(empty($this->nacimiento)){
            $errores['nacimiento'] = "La fecha de nacimiento es obligatoria";
        }elseif(strtotime($this->nacimiento) > time()){
            $errores['nacimiento'] = "La fecha de nacimiento no es válida";
        }

        if(empty($this->email)){
            $errores['email'] = "El email es obligatorio";
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $errores['email'] = "Formato de email incorrecto";
        }

        if(empty($this->direccion)){
            $errores['direccion'] = "La direccion es obligatoria";
        }

        if(empty($this->cp)){
            $errores['cp'] = "El codigo postal es obligatorio";
        }elseif(!preg_match('/^[0-9]{5}$/', $this->cp)){
            $errores['cp'] = "Formato de codigo postal incorrecto";
        }

        if(empty($this->poblacion)){
            $errores['poblacion'] = "La poblacion es obligatoria";
        }

        if(empty($this->provincia)){
            $errores['provincia'] = "La provincia es obligatoria";
        }

        if(empty($this->telefono)){
            $errores['telefono'] = "El telefono es obligatorio";
        }

        return $errores;
    }
}