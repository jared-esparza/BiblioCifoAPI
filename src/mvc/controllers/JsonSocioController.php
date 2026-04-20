<?php

class JsonSocioController extends Controller{
    public function get(mixed $param1=NULL, mixed $param2=NULL):JsonResponse{
        if(!$param1 && !$param2){
            $socios = Socio::all();
        }
        if($param1 && $param2){
            $socios = Socio::getFiltered($param1, $param2);
        }
        if($param1 && !$param2){
            $socios = [Socio::findOrFail(
                intval($param1),
                "No se ha encontrado el socio")];
        }

        return new JsonResponse(
            $socios,
            "Se han recuperado " . sizeof($socios) . " registros.");

    }

    public function delete(int|string $id = 0):JsonResponse{
        $socio = Socio::findOrFail(intval($id), "No se ha encontrado el socio");
        if ($socio->hasMany('Prestamo')){
            throw new ApiException("No se puede eliminar el socio porque tiene
                prestamos asociados");
        }
        $socio->deleteObject();

        return new JsonResponse([$socio,
            "Borrado del socio $socio->nombre correcto."]);
    }

    public function post():JsonResponse{
        $socios = request()->fromJson('Socio');

        $response = new JsonResponse([], "Guardado correcto", 201, "CREATED");
        foreach($socios as $socio){
            $socio->saneate();
            try{
                $socio->save();
                $response->addData("$socio->nombre guardado correctamente");
            }catch(Throwable $t){
                $response->setMessage("Se han producido errores");
                $response->setStatus("WITH ERRORS");
                $response->addData($socio->nombre . " " .(DEBUG ? $t->getMessage() : "Duplicado?"));
            }
        }

        return $response;
    }

    public function put():JsonResponse{
        $socios = request()->fromJson('Socio');
        $response = new JsonResponse([], "Actualizacioón correcta");
        foreach($socios as $socio){
            try{
                if(empty($socio->id)){
                    throw new ApiException("No se indicó el identificador");
                }
                $socio->update();
                $response->addData("$socio->nombre actualizado correctamente");

            }catch(Throwable $t){
                $response->evaluateError($t);
                $response->setMessage("Se han producido errores");
                $response->setStatus("WITH ERRORS");
                $response->addData($socio->nombre . " " .(DEBUG ? $t->getMessage() : "Duplicado?"));
            }
        }
            return $response;
    }

    public function patch():JsonResponse{
        return $this->put();
    }
}