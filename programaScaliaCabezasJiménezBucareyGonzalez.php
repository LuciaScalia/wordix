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

function agregarPalabra($estructuraPalabras, $palabraNueva)
{
    //int $cantPalabras
    $cantPalabras = count($estructuraPalabras);
    $estructuraPalabras[$cantPalabras] = strtoupper($palabraNueva);

    return $estructuraPalabras;
}

/**
 * Solicita al usuario el nombre de un jugador y lo retorna en minusculas
 * @return string
 */
function solicitarJugador()
{
    //string $nombreJugador
    echo "Ingrese nombre de usuario: ";
    $nombreJugador = trim(fgets(STDIN));

    while (!ctype_alpha($nombreJugador[0])) {
        echo "El nombre de usuario debe comenzar con una letra: ";
        $nombreJugador = trim(fgets(STDIN));

        $nombreJugador = strtolower($nombreJugador);
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
    while ($i < count($coleccionPartidas) && $palDiferente) {
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
    //boolean $excedido
    //int $i, $contador
    $excedido = false;
    $i = 0;
    $contador = 0;
    
    do {
        if ($coleccionPartidas[$i]["jugador"] == $nombre) {
            $contador++;
            if ($contador >= $cantPalabras) {
                $excedido = true;
            }
        }
        $i++;
    } while ($i < count($coleccionPartidas) && !$excedido);

    return $excedido;
}

/**
 * Muestra por pantalla los datos de una partida
 * @param array $coleccionPartidas
 * @param int $numPartida
 *
 */
function mostrarPartida($coleccionPartidas, $numPartida)
{
    echo "--------------------------------------------------------------------------------\n";
    echo "Partida WORDIX N°" . $numPartida . ": Palabra " . $coleccionPartidas[$numPartida - 1]["palabraWordix"] . "\n";
    echo "Jugador: " . $coleccionPartidas[$numPartida - 1]["jugador"] . "\n";
    echo "Puntaje: " . $coleccionPartidas[$numPartida - 1]["puntaje"] . " puntos\n";
    echo "Intentos: " . $coleccionPartidas[$numPartida - 1]["intentos"] . "\n";
    echo "--------------------------------------------------------------------------------\n";
}

/**
 * Muestra el resumen de un jugador
 * @param array $coleccionPartidas
 * @param string $nombreUsuario
 * @return array
 */

 function resumenJugador($coleccionPalabras, $nombreUsuario) {
    
 }


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

 /* 
    array $coleccionPalabras, $palabrasDisponibles, $partidasJugadas
    int $opcion, $i, $j, $l, $palabraSolicitada
    string $nuevaPalabra, $jugadorNombre
*/

//Inicialización de variables:

$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();
$cantPalCol = count($coleccionPalabras);
$palabrasDisponibles = cargarColeccionPalabras();
$l = 0;

//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

do {

    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case 1:
            $jugadorNombre = solicitarJugador();

            echo "**********LISTA DE PALABRAS**********\n";
            for ($i = 0; $i < count($coleccionPalabras); $i++) {
                echo $i . ") " . $coleccionPalabras[$i] . "\n";
            }

            echo "Ingrese el número de la palabra con la que desea jugar: ";
            $palabraSolicitada = solicitarNumeroEntre(0, $cantPalCol - 1);

            while ($palabrasDisponibles[$palabraSolicitada] == "noDisponible") {
                echo "Palabra no disponible. Ingrese otra: ";
                $palabraSolicitada = trim(fgets(STDIN));
            }

            $palabrasDisponibles[$palabraSolicitada] = "noDisponible";
            array_push($coleccionPartidas, jugarWordix($coleccionPalabras[$palabraSolicitada], $jugadorNombre));
            break;

        case 2:

            //jugar al wordix con una palabra aleatoria 
            $nombre = solicitarJugador();
            echo "Jugará con una palabra aleatoria que se encuentra cargada en el juego\n";
            do {
                $numPalabra = random_int(1, $cantPalCol);
                if (cuentaPartidasJugador($nombre, $coleccionPartidas, $cantPalCol) == false) {
                    $numDiferente = verificaNumeroDiferente($nombre, $coleccionPalabras[$numPalabra - 1], $coleccionPartidas);
                }
            } while (!$numDiferente);
            echo "\n";
            array_push($coleccionPartidas, jugarWordix($coleccionPalabras[$numPalabra - 1], $nombre));
            break;

        case 3:

            // mostrar una partida
            echo "Ingrese un número de partida para mostrar en pantalla ";
            $numPartida = solicitarNumeroEntre(1, count($coleccionPartidas));
            mostrarPartida($coleccionPartidas, $numPartida);
            break;

        case 4:

            $nombreJugador = solicitarJugador();
            $palabraIndice = primeraGanadaJugador($coleccionPartidas, $nombreJugador);

            if ( $palabraIndice == -1){
                echo "\n El jugador no tiene una aprtida registrada. \n";
            }else {
                informePartida($coleccionPartidas, $inficePartidasGanadas)
            }
            break;

        case 5;
            $nombreJugador = solicitarJugador();
            estadisticasJugador ($coleccionPartidas, $nombreJugador);
            break;

        case 6;
        
            break;
        case 7:
            $palabra = leerPalabra5Letras();

            while ($l < count($coleccionPalabras) - 1) {
                foreach ($coleccionPalabras as $j => $palabraIndice) {
                    while ($palabra == $palabraIndice) {
                        echo "La palabra ya fue ingresada. ";
                        $palabra = leerPalabra5Letras();
                    }
                    $j = 0;
                }
                $l++;
            }

            $coleccionPalabras = agregarPalabra($coleccionPalabras, $palabra);
    }
} while ($opcion != 8);

print_r($coleccionPartidas);
mostrarPartida($coleccionPartidas, 11);
