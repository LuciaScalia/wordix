<?php
include_once("wordix.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* - Damaris Lucia Scalia - Legajo: 4235 - mail: luciaxscaliax@gmail.com - Github: LuciaScalia */
/* - Cabezas Jimenez, Victoria Ariana - Legajo: 4212 - mail: v.arianajimenez@gmail.com - Github: AriiJim*/
/* - Bucarey Nicolas Lautaro - Legajo: 4255 - mail: nicobucarey12@gmail.com - Github: NicoBucarey */
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
*********MENÚ DE OPCIONES*********
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
        echo "La opción elegida no es válida, vuelva a ingresarla: ";
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
    $coleccionPalabras[$cantPalabras] = strtoupper($palabraNueva);

    return $coleccionPalabras;
}

/**
 * Solicita a un usuario ingresar un nombre de jugador y retorna el nombre en minusculas
 * @return string
 */
function nombreJugador(){
    //string $nombreJugador
    //boolean $palabra

    do {
        echo "Ingrese un nombre de jugador: ";
        $jugador = trim(fgets(STDIN));
        if (!ctype_alpha($jugador[0])) {
            $palabra = false;
            echo "Error. Ha ingresado un caracteres que no son letras  \n";
        } else {
            $palabra = true;
        }
    } while ($palabra == false);

    return strtolower($jugador);
}

/**
 * Solicita al usuario el nombre de un jugador y retorna el nombre en minusculas y hace que la primera letra sea un string
 * @return
 */
function solicitarJugador(){
    echo "Ingrese nombre de usuario:";
    $nombreJugador=trim(fgets(STDIN));
    $nombreJugador=strtolower($nombreJugador);
    while (!ctype_alpha($nombreJugador[0])) {
        $nombreJugador[0]="a";
    }
    
    return $nombreJugador;
}

/**
 * Verifica que el número de palabra sea distinto a los anteriores
 * @param string $nombre
 * @param string $palabra
 * @param array $coleccionPartidas
 * @return boolean
 */
function verificaNumeroDiferente($nombre, $palabra, $coleccionPartidas)
{
    //boolean $palDiferente
    //int $i
    $palDiferente = true;
    $i = 0;
    while ($i < count($coleccionPartidas) && $palDiferente == true) {
        if ($coleccionPartidas[$i]["jugador"] == $nombre) {
            if ($coleccionPartidas[$i]["palabraWordix"] == $palabra) {
                $palDiferente = false;
            }
        }
        $i++;
    }
    return $palDiferente;
}

/**
 * Cuenta la cantidad de partidas de un jugador
 * @param string $nombre
 * @param array $coleccionPartidas
 * @param int $cantPalabras
 * @return boolean
 */
function cuentaPartidasJugador($nombre, $coleccionPartidas, $cantPalabras)
{
    //boolean $exedido
    //int $i, $contador
    $exedido = false;
    $i = 0;
    $contador = 0;

    do {
        if ($coleccionPartidas[$i]["jugador"] == $nombre) {
            $contador++;
            if ($contador >= $cantPalabras) {
                $exedido = true;
            }
        }
        $i++;
    } while ($i < count($coleccionPartidas) && $exedido == false);

    return $exedido;
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

/* array $estructuraPalabras
   int $opcion
   string $nuevaPalabra
*/

//Inicialización de variables:

$estructuraPalabras = cargarColeccionPalabras();
$i = 0;
//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();
$cantPalCol = count($coleccionPalabras);

do {

    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case 1:
           
            break;
        case 2: 
            //jugar al wordix con una palabra elegida 
             $nombre = nombreJugador();
            echo "Jugará con una palabra aleatoria que se encuentra cargada en el juego\n";
            do {
                $numPalabra = random_int(1, $cantPalCol);
                if (cuentaPartidasJugador($nombre, $coleccionPartidas, $cantPalCol) == false) {
                    $numDiferente = verificaNumeroDiferente($nombre, $coleccionPalabras[$numPalabra - 1], $coleccionPartidas);
                }
            } while (!$numDiferente);
            echo "\n";
            array_push($coleccionPartidas, jugarWordix($coleccionPalabras[$numPalabra - 1], $nombre));
            echo "\n";
            echo "Ingrese cualquier valor para volver al menú principal u 8 para finalizar: ";
            $opcion = trim(fgets(STDIN));
            break;
        case 3:
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3

            break;

            //...
        case 4:
            break;
        case 7:
            $palabra = leerPalabra5Letras();

            while ($i < count($estructuraPalabras) - 1) {
                foreach ($estructuraPalabras as $j => $palabraIndice) {
                    while ($palabra == $palabraIndice) {
                        echo "La palabra ya fue ingresada. ";
                        $palabra = leerPalabra5Letras();
                    }
                    $j = 0;
                }
                $i++;
            }

            $estructuraPalabras = agregarPalabra($estructuraPalabras, $palabra);
    }
} while ($opcion != 8);
