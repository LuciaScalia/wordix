<?php
include_once("wordix.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* - Damaris Lucia Scalia - Legajo: 4235 - mail: luciaxscaliax@gmail.com - Github: LuciaScalia */
/* - Cabezas Jimenez, Victoria Ariana - Legajo: 4212 - mail: v.arianajimenez@gmail.com - Github: AriiJim */
/* - Bucarey Nicolas Lautaro - Legajo: 4255 - mail: nicobucarey12@gmail.com - Github: NicoBucarey */

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/** Punto 1
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

/** Punto 2
 * Inicializa y retorna una colección de partidas finalizadas
 * @return array
 */

function cargarPartidas()
{
    //array $partidas
    $partidas[0] = ["palabraWordix" => "QUESO", "jugador" => "majo", "intentos" => 0, "puntaje" => 0];
    $partidas[1] = ["palabraWordix" => "CASAS", "jugador" => "david", "intentos" => 3, "puntaje" => 14];
    $partidas[2] = ["palabraWordix" => "QUESO", "jugador" => "claudia", "intentos" => 6, "puntaje" => 10];
    $partidas[3] = ["palabraWordix" => "FUEGO", "jugador" => "sabrina", "intentos" => 4, "puntaje" => 10];
    $partidas[4] = ["palabraWordix" => "RASGO", "jugador" => "victoria", "intentos" => 5, "puntaje" => 15];
    $partidas[5] = ["palabraWordix" => "GATOS", "jugador" => "nicolas", "intentos" => 3, "puntaje" => 14];
    $partidas[6] = ["palabraWordix" => "MELON", "jugador" => "mateo", "intentos" => 4, "puntaje" => 14];
    $partidas[7] = ["palabraWordix" => "YUYOS", "jugador" => "karina", "intentos" => 2, "puntaje" => 16];
    $partidas[8] = ["palabraWordix" => "MUJER", "jugador" => "cristian", "intentos" => 3, "puntaje" => 13];
    $partidas[9] = ["palabraWordix" => "MELON", "jugador" => "david", "intentos" => 0, "puntaje" => 0];

    return $partidas;
}

/** Punto 3
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

/** Punto 7
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

/** Punto 10
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
    }

    $nombreJugador = strtolower($nombreJugador);

    return $nombreJugador;
}

/**
 * Verifica que el número de palabra sea distinto a los anteriores
 * @param string $nombre
 * @param string $palabra
 * @param array $coleccionPartidas
 * @return boolean
 */
function verificaNumeroDiferente($nombre, $palabra, $estructuraPalabras)
{
    //boolean $palabraDiferente
    //int $i
    $palabraDiferente = true;
    $i = 0;
    while ($i < count($estructuraPalabras) && $palabraDiferente) {
        if ($estructuraPalabras[$i]["jugador"] == $nombre) {
            if ($estructuraPalabras[$i]["palabraWordix"] == $palabra) {
                $palabraDiferente = false;
            }
        }
        $i++;
    }
    return $palabraDiferente;
}

/*
 * Cuenta la cantidad de partidas de un jugador
 * @param string $nombre
 * @param array $coleccionPartidas
 * @param int $cantPalabras
 * @return boolean
 */

function cuentaPartidasJugador($nombre, $estructuraPalabras, $cantPalabras)
{
    //boolean $excedido
    //int $i, $contador
    $excedido = false;
    $i = 0;
    $contador = 0;

    do {
        if ($estructuraPalabras[$i]["jugador"] == $nombre) {
            $contador++;
            if ($contador >= $cantPalabras) {
                $excedido = true;
            }
        }
        $i++;
    } while ($i < count($estructuraPalabras) && !$excedido);

    return $excedido;
}

/** Punto 6
 * Muestra por pantalla los datos de una partida
 * @param array $coleccionPartidas
 * @param int $numPartida
 *
 */
function mostrarPartida($estructuraPalabras, $numPartida)
{
    echo "--------------------------------------------------------------------------------\n";
    echo "Partida WORDIX N°" . $numPartida . ": Palabra " . $estructuraPalabras[$numPartida - 1]["palabraWordix"] . "\n";
    echo "Jugador: " . $estructuraPalabras[$numPartida - 1]["jugador"] . "\n";
    echo "Puntaje: " . $estructuraPalabras[$numPartida - 1]["puntaje"] . " puntos\n";
    if ($estructuraPalabras[$numPartida - 1]["intentos"] > 0) {
        echo "Intento: Adivinó la palabra en " . $estructuraPalabras[$numPartida - 1]["intento"]  .  " intento/s \n";
    } else {
        echo "Intento: No adivinó la palabra \n";
    }
    echo "--------------------------------------------------------------------------------\n";
}

/** Punto 8
 * Dado el nombre de un jugador y una coleccion de partidas, se retorna el indice de la primer aprtida ganada por el jugador.
 * Si el jugador no ha ganado ninguna partida, la funcion retorna -1
 * 
 * @param array $coleccionPartidas
 * @param string $nombreJugador
 * @return int
 */
function primeraGanadaJugador($estructuraPalabras, $nombreJugador)
{
    //int $primerPartidaGanada $n $i

    $n = count($estructuraPalabras);
    $i = 0;
    $primerPartidaGanada = -1;
    while ($i < $n && $primerPartidaGanada == -1) {
        if ($estructuraPalabras[$i]["jugador"] == $nombreJugador) {
            if ($estructuraPalabras[$i]["puntaje"] > 0) {
                $primerPartidaGanada = $i;
            }
        }
        $i++;
    }
    return $primerPartidaGanada;
}

/** punto 9
 * Muestra el resumen de un jugador
 * @param array $partidas
 * @param string $nombreUsuario
 * @return array
 */

function resumenJugador($partidas, $nombreUsuario)
{
    //int $i $cantPartidas $puntaje $n $cantidadVictorias $intento1 $intento2 $intento3 $intento4 $intento5 $intento6

    $puntaje = 0;
    $intento1 = 0;
    $intento2 = 0;
    $intento3 = 0;
    $intento4 = 0;
    $intento5 = 0;
    $intento6 = 0;
    $cantidadVictorias = 0;
    $cantPartidas = 0;
    $n = count($partidas);

    for ($i = 0; $i < $n; $i++) {
        $cantIntentos = $partidas[$i]["intentos"];
        if ($partidas[$i]["jugador"] == $nombreUsuario) {
            $cantPartidas = $cantPartidas + 1;
            $puntaje = $puntaje + $partidas[$i]["puntaje"];

            if ($partidas[$i]["puntaje"] > 0) {
                $cantidadVictorias = $cantidadVictorias + 1;
            }

            switch ($cantIntentos) {
                case 1:
                    $intento1 = $intento1 + 1;
                    break;
                case 2:
                    $intento2 = $intento2 + 1;
                    break;
                case 3:
                    $intento3 = $intento3 + 1;
                    break;
                case 4:
                    $intento4 = $intento4 + 1;
                    break;
                case 5:
                    $intento5 = $intento5 + 1;
                case 6:
                    $intento6 = $intento6 + 1;
            }
        }
    }

    echo "********************\n
    Jugador: " . $nombreUsuario . "
    Partidas: " . $cantPartidas . "
    Puntaje Total " . $puntaje . "
    Victorias: " . $cantidadVictorias . "
    Porcentaje victorias : " . ($cantidadVictorias * 100 / $cantPartidas) . " %
    Adivinadas: \n
        Intento 1 : " . $intento1 . "
        Intento 2 : " . $intento2 . "
        Intento 3 : " . $intento3 . "
        Intento 4 : " . $intento4 . "
        Intento 5 : " . $intento5 . "
        Intento 6 : " . $intento6 . "
    **********************\n";
}

/**
 * Pto11
 * Ordena el arreglo con la funcion uasort
 * @param array $coleccionPartidas
 */
function ordenarColeccionPartidas($estructuraPalabras)
{
    uasort($estructuraPalabras, 'cmp');
    return $estructuraPalabras;
}

/** pto6 - exp1
 * Funcion que compara los elementos del arreglo coleccionPartidas respecto al jugador y/o palabra
 *@param array $a
 *@param array $b
 * @return int
 */

function cmp($a, $b)
{
    //int $orden
    if ($a["jugador"] > $b["jugador"]) {
        $orden = 1;
    } elseif ($a["jugador"] < $b["jugador"]) {
        $orden = -1;
    } else {
        if ($a["palabraWordix"] > $b["palabraWordix"]) {
            $orden = 1;
        } elseif ($a["palabraWordix"] < $b["palabraWordix"]) {
            $orden = -1;
        }
    }
    return $orden;
}

/**
 * Retorna true si un jugador ya se encuentra en la coleccion de partidas, false en el caso contrario
 * @param array $estrcturaPalabras
 * @param string $nombre
 * @return boolean
 */
function jugadorExistente($estructuraPalabras, $nombre)
{
    // int $i $cantJugadores, boolean $existeJugador
    $i = 0;
    $cantJugadores = count($estructuraPalabras);
    $existeJugador = true;
    while (($i < $cantJugadores) && ($estructuraPalabras[$i]["jugador"] != $nombre)) {
        $i++;
    }

    if ($i == $cantJugadores) {
        $existeJugador = false;
    }

    return $existeJugador;
}


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

/* 
    array $coleccionPalabras, $coleccionPartidas
    int $opcion, $i, $j, $l, $palabraSolicitada $numPalabra, $cantPalCol, $numPartida, $palabraIndice
    string $nuevaPalabra, $jugadorNombre, $palabra, $valorPalabra
    boolean $jugadorEnColeccion
*/

//Inicialización de variables:

$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();

do {

    $opcion = seleccionarOpcion();
    $cantPalCol = count($coleccionPalabras);

    switch ($opcion) {
        case 1:

            //jugar al wordix con una palabra elegida
            $jugadorNombre = solicitarJugador();

            echo "Ingrese el número de la palabra con la que desea jugar: ";
            $palabraSolicitada = solicitarNumeroEntre(1, $cantPalCol);

            while (!verificaNumeroDiferente($jugadorNombre, $coleccionPalabras[$palabraSolicitada - 1], $coleccionPartidas)) {
                echo "Palabra no disponible. Ingrese otra: ";
                $palabraSolicitada = trim(fgets(STDIN));
            }

            array_push($coleccionPartidas, jugarWordix($coleccionPalabras[$palabraSolicitada - 1], $jugadorNombre));

            break;
        case 2:

            //jugar al wordix con una palabra aleatoria 
            $jugadorNombre = solicitarJugador();
            echo "\n¡Jugará con una palabra aleatoria que se encuentra cargada en el juego!\n";
            do {
                $numPalabra = random_int(1, $cantPalCol);
                if (!cuentaPartidasJugador($jugadorNombre, $coleccionPartidas, $cantPalCol)) {
                    $numDiferente = verificaNumeroDiferente($jugadorNombre, $coleccionPalabras[$numPalabra - 1], $coleccionPartidas);
                }
            } while (!$numDiferente);
            echo "\n";
            array_push($coleccionPartidas, jugarWordix($coleccionPalabras[$numPalabra - 1], $jugadorNombre));

            break;
        case 3:

            // mostrar una partida
            echo "Ingrese un número de partida para mostrar en pantalla: ";
            $numPartida = solicitarNumeroEntre(1, $cantPalCol);
            mostrarPartida($coleccionPartidas, $numPartida);

            break;
        case 4:

            // mostrar la primer partida ganadora
            $jugadorNombre = solicitarJugador();
            $palabraIndice = primeraGanadaJugador($coleccionPartidas, $jugadorNombre);
            $jugadorEnColeccion = jugadorExistente($coleccionPartidas, $jugadorNombre);

            if (!$jugadorEnColeccion) {
                echo "\nEl jugador $jugadorNombre no existe.\n";
            } elseif ($palabraIndice == -1) {
                echo "\nEl jugador no ganó ninguna partida.\n";
            } else {
                mostrarPartida($coleccionPartidas, $palabraIndice + 1);
            }

            break;
        case 5:

            // Para mostrar resumen de jugador
            $jugadorNombre = solicitarJugador();
            resumenJugador($coleccionPartidas, $jugadorNombre);

            break;
        case 6:
            
            //mostrar listado de partidas ordenadas por jugador y por palabra
            $coleccionOrdenada = ordenarColeccionPartidas($coleccionPartidas);
            print_r($coleccionOrdenada);
            break;

        case 7:

            //agregar una palabra de cinco letras al wordix
            $palabra = leerPalabra5Letras();

            $l = 0;

            while ($l < $cantPalCol - 1) {
                foreach ($coleccionPalabras as $j => $valorPalabra) {
                    while ($palabra == $valorPalabra) {
                        echo "La palabra $valorPalabra ya fue ingresada. ";
                        $palabra = leerPalabra5Letras();
                    }
                }
                $l++;
            }

            $coleccionPalabras = agregarPalabra($coleccionPalabras, $palabra);
    }
} while ($opcion != 8);
