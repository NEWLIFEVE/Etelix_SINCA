<?php
// Solo contiene la informacion de conexion de base de datos
return array(
	'modules'=>array(
        // uncomment the following to enable the Gii tool
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
			'password'=>'123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array(
                '127.0.0.1',
                '::1'
                ),
            'generatorPaths'=>array(
                'bootstrap.gii',
                ),
            ),
        ),
	);