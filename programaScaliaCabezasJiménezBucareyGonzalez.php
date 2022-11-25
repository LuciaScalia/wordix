<?php
include_once("wordix.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* - Damaris Lucia Scalia - Legajo: 4235 - mail: luciaxscaliax@gmail.com - Github: LuciaScalia */
/* - Cabezas Jimenez, Victoria Ariana - Legajo: 4212 - mail: v.arianajimenez@gmail.com - Github: AriiJim */
/* ... COMPLETAR ... */



/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Obtiene una colección de palabras
 * @return array
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "CREMA", "CARTA", "MOTOR", "MATES", "LIBRO"
    ];

    return ($coleccionPalabras);
}

/**************************************/
/********** FUNCIONES NUEVAS **********/
/**************************************/

/**
 * Inicializa y retorna una colección de partidas finalizadas
 * @return array
 */

function cargarPartidas()
{
    //array $partidas
    $partidas[0] = ["palabraWordix" => "QUESO", "jugador" => "majo", "intentos" => 0, "puntaje" => 0];
    $partidas[1] = ["palabraWordix" => "CASAS", "jugador" => "rudolf", "intentos" => 3, "puntaje" => 14];
    $partidas[2] = ["palabraWordix" => "QUESO", "jugador" => "pink2000", "intentos" => 6, "puntaje" => 10];
    $partidas[3] = ["palabraWordix" => "FUEGO", "jugador" => "sabrina", "intentos" => 4, "puntaje" => 10];
    $partidas[4] = ["palabraWordix" => "RASGO", "jugador" => "victoria", "intentos" => 5, "puntaje" => 15];
    $partidas[5] = ["palabraWordix" => "GATOS", "jugador" => "nicolas", "intentos" => 3, "puntaje" => 14];
    $partidas[6] = ["palabraWordix" => "MELON", "jugador" => "lucia", "intentos" => 4, "puntaje" => 14];
    $partidas[7] = ["palabraWordix" => "YUYOS", "jugador" => "rudolf", "intentos" => 2, "puntaje" => 16];
    $partidas[8] = ["palabraWordix" => "MUJER", "jugador" => "laura8T5", "intentos" => 3, "puntaje" => 13];
    $partidas[9] = ["palabraWordix" => "MELON", "jugador" => "laura8T5", "intentos" => 0, "puntaje" => 0];

    return $partidas;
}

/**
 * Retorna el número de la opción del menú principal elegida por el usuario
 * @return int
 */

function seleccionarOpcion()
{
   //int $opcionElegida

   echo "
1) Jugar al Wordix con una palabra elegida 
2) Jugar al Wordix con una palabra aleatoria
3) Mostrar una partida
4) Mostrar la primer partida ganadora
5) Mostrar resumen de Jugador
6) Mostrar listado de partidas ordenadas por jugador y por palabra
7) Agregar una palabra de 5 letras a Wordix
8) Salir

Elija la opción: ";

   $opcionElegida = trim(fgets(STDIN));

   while ($opcionElegida < 1 || $opcionElegida > 8) {
       echo "\n La opción elegida no es válida, vuelva a ingresarla: ";
       $opcionElegida = trim(fgets(STDIN));
   }

   return $opcionElegida;
}

 /**
  * Agrega una palabra a la colección de palabras que se usa para jugar
  * @param array $coleccionPalabras
  * @param string $palabraNueva
  * @return array
  */

  function agregarPalabra($coleccionPalabras, $palabraNueva) 
  {
    //int $cantPalabras
    $cantPalabras = count($coleccionPalabras);
    $coleccionPalabras[$cantPalabras] = $palabraNueva;

    return $coleccionPalabras;
  }

  seleccionarOpcion();

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:


//Inicialización de variables:


//Proceso:

$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);



/*
do {
    $opcion = ...;

    
    switch ($opcion) {
        case 1: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 1

            break;
        case 2: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 2

            break;
        case 3: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3

            break;
        
            //...
    }
} while ($opcion != X);
*/
