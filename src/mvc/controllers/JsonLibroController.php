<?php

class JsonLibroController extends Controller{
    public function get(mixed $param1=NULL, mixed $param2=NULL):JsonResponse{
        if(!$param1 && !$param2){
            $libros = Libro::all();
        }
        if($param1 && $param2){
            $libros = Libro::getFiltered($param1, $param2);
        }
        if($param1 && !$param2){
            $libros = [Libro::findOrFail(
                intval($param1),
                "No se ha encontrado el libro")];
        }

        return new JsonResponse(
            $libros,
            "Se han recuperado " . sizeof($libros) . " registros.");

    }

    public function delete(int|string $id = 0):JsonResponse{
        $libro = Libro::findOrFail(intval($id), "No se ha encontrado el libro");
        if ($libro->hasMany('Ejemplar')){
            throw new ApiException("No se puede eliminar el lbro porque tiene
                ejemplares asociados");
        }
        $libro->deleteObject();
        if ($libro->portada){
            File::remove(BOOK_IMAGE_FOLDER . "/" . $libro->portada);
        }

        return new JsonResponse([$libro,
            "Borrado del libro $libro->titulo correcto."]);
    }

    public function post():JsonResponse{
        $libros = request()->fromJson('Libro');

        $response = new JsonResponse([], "Guardado correcto", 201, "CREATED");
        foreach($libros as $libro){
            $libro->saneate();
            try{
                $libro->save();
                $response->addData("$libro->titulo guardado correctamente");
            }catch(Throwable $t){
                $response->setMessage("Se han producido errores");
                $response->setStatus("WITH ERRORS");
                $response->addData($libro->titulo . " " .(DEBUG ? $t->getMessage() : "Duplicado?"));
            }
        }

        return $response;
    }
}