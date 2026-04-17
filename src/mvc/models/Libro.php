<?php
#[\AllowDynamicProperties]

class Libro extends Model{
    protected static $fillable = ["isbn", "titulo", "editorial", "idioma", "autor",
        "edicion", "anyo", "edadrecomendada", "portada", "caracteristicas", "sinopsis", "paginas"];

    public function addtema(int $idtema):int {
        $consulta = "INSERT INTO temas_libros (idlibro, idtema) VALUES ($this->id, $idtema)";
        return DB::insert($consulta);
    }

    public function removetema(int $idtema):int {
        $consulta = "DELETE FROM temas_libros WHERE idlibro = $this->id and idtema = $idtema";
        return DB::delete($consulta);
    }

    public function validate():array{
        $errores = [];

        if(empty($this->isbn)){
            $errores['isbn'] = "El ISBN es obligatorio";
        }

        if(empty($this->titulo)){
            $errores['titulo'] = "Error en el titulo";
        }

        if(empty($this->editorial)){
            $errores['editorial'] = "Error en la editorial";
        }

        if(empty($this->idioma)){
            $errores['idioma'] = "Error en el idioma";
        }

        if(empty($this->autor)){
            $errores['autor'] = "Error en el autor";
        }

        if(empty($this->edicion) || $this->edicion < 1){
            $errores['edicion'] = "Error en la edicion";
        }

        if(!empty($this->anyo)){
            if($this->anyo < 0 || $this->anyo > date("Y")){
                $errores['anyo'] = "Año de publicación incorrecto";
            }
        }

        if(!empty($this->edadrecomendada) && $this->edadrecomendada < 0){
            $errores['edadrecomendada'] = "Error en la edad recomendada";
        }

        if(!empty($this->paginas)){
            if($this->paginas < 0){
                $errores['paginas'] = "Número de páginas incorrecto";
            }
        }

        return $errores;
    }

}