<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model 
{
	//protected $primaryKey = 'id';
	public $timestamps = false;
	protected $table = 're_socios';

	// protected $fillable = [
	// 	'id',
	// 	'anio',
	// 	'mes',
	// 	'tipo_doc',
	// 	'numero_doc',
	// 	'codigo',
	// 	'email',
	// 	'ap_paterno',
	// 	'ap_materno',
	// 	'colaborador',
	// 	'seccion',
	// 	'area',
	// 	'puesto'
	// ];

}