<?php
#[\AllowDynamicProperties]

class Prestamo extends Model{
    protected static $fillable = ["idsocio", "idejemplar", "devolucion", "incidencia", "limite"];
}