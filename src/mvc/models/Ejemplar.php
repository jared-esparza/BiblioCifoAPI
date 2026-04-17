<?php
#[\AllowDynamicProperties]
class Ejemplar extends Model{
    protected static string $table = 'ejemplares';
    protected static $fillable = ["idlibro", "anyo", "estado", "precio"];
}