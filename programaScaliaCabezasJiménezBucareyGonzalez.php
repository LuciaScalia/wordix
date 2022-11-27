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
    $partidas[1] = ["palabraWordix" => "CASAS", "jugador" => "rudolf", "intentos" => 3, "puntaje" => 14];
    $partidas[2] = ["palabraWordix" => "QUESO", "jugador" => "pink2000", "intentos" => 6, "puntaje" => 10];
    $partidas[3] = ["palabraWordix" => "FUEGO", "jugador" => "sabrina", "intentos" => 4, "puntaje" => 10];
    $partidas[4] = ["palabraWordix" => "RASGO", "jugador" => "victoria", "intentos" => 5, "puntaje" => 15];
    $partidas[5] = ["palabraWordix" => "GATOS", "jugador" => "nicolas", "intentos" => 3, "puntaje" => 14];
    $partidas[6] = ["palabraWordix" => "MELON", "jugador" => "mateo", "intentos" => 4, "puntaje" => 14];
    $partidas[7] = ["palabraWordix" => "YUYOS", "jugador" => "rudolf", "intentos" => 2, "puntaje" => 16];
    $partidas[8] = ["palabraWordix" => "MUJER", "jugador" => "laura8T5", "intentos" => 3, "puntaje" => 13];
    $partidas[9] = ["palabraWordix" => "MELON", "jugador" => "laura8T5", "intentos" => 0, "puntaje" => 0];

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
function verificaNumeroDiferente($nombre, $palabra, $coleccionPartidas)
{
    //boolean $palabraDiferente
    //int $i
    $palabraDiferente = true;
    $i = 0;
    while ($i < count($coleccionPartidas) && $palabraDiferente) {
        if ($coleccionPartidas[$i]["jugador"] == $nombre) {
            if ($coleccionPartidas[$i]["palabraWordix"] == $palabra) {
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

/** Punto 6
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
    if ($coleccionPartidas [$numPartida]["intentos"] > 0){
        echo "Intento: Adivinó la palabra en " . $coleccionPartidas [$numPartida]["intentos"] . "intentos \n";
    }else{
        echo "Intento: No adivino la palabra \n";
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
function primeraGanadaJugador ($coleccionPartidas, $nombreJugador) {
    //int $primerPartidaGanada $n $i
    
    $n = count($coleccionPartidas);
    $i = 0;
    $primerPartidaGanada = -1;
    while ($i<$n && $primerPartidaGanada == -1){
        if ($coleccionPartidas[$i]["jugador"] == $nombreJugador){
            if ($coleccionPartidas[$i]["puntaje"] > 0){
                $primerPartidaGanada = $i;
            }
        }
        $i = $i + 1;
    }
    return $primerPartidaGanada; 
}

/** punto 9
 * Muestra el resumen de un jugador
 * @param array $partidas
 * @param string $nombreUsuario
 * @return array
 */

 function resumenJugador($partidas, $nombreUsuario) {
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
    $n=count($partidas);
    
    for ($i=0; $i < $n; $i++){
        $cantIntentos = $partidas[$i]["intentos"];
        if ($partidas [$i]["jugador"] == $nombreUsuario){
            $cantPartidas = $cantPartidas + 1;
            $puntaje = $puntaje + $partidas [$i]["puntaje"];

            if ($partidas[$i]["puntaje"] > 0){
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
    Jugador: ". $nombreUsuario. "
    Partidas: ". $cantPartidas. "
    Puntaje Total ". $puntaje. "
    Victorias: ". $cantidadVictorias. "
    Porcentaje victorias : ". ($cantidadVictorias* 100 / $cantPartidas). " %
    Adivinadas: \n
        Intento 1 : ". $intento1. "
        Intento 2 : ". $intento2. "
        Intento 3 : ". $intento3. "
        Intento 4 : ". $intento4. "
        Intento 5 : ". $intento5. "
        Intento 6 : ". $intento6. "
    **********************\n";
 }


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

 /* 
    array $coleccionPalabras
    int $opcion, $i, $j, $l, $palabraSolicitada
    string $nuevaPalabra, $jugadorNombre
*/

//Inicialización de variables:

$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();
$cantPalCol = count($coleccionPalabras);
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

            echo "Ingrese el número de la palabra con la que desea jugar: ";
            $palabraSolicitada = solicitarNumeroEntre(0, count($coleccionPalabras) - 1);

            while (!verificaNumeroDiferente($jugadorNombre, $coleccionPalabras[$palabraSolicitada], $coleccionPartidas)) {
                echo "Palabra no disponible. Ingrese otra: ";
                $palabraSolicitada = trim(fgets(STDIN));
            }
        
            array_push($coleccionPartidas, jugarWordix($coleccionPalabras[$palabraSolicitada], $jugadorNombre));

            break;
        case 2:

            //jugar al wordix con una palabra aleatoria 
            $nombre = solicitarJugador();
            echo "\n¡Jugará con una palabra aleatoria que se encuentra cargada en el juego!\n";
            do {
                $numPalabra = random_int(1, $cantPalCol);
                if (!cuentaPartidasJugador($nombre, $coleccionPartidas, $cantPalCol)) {
                    $numDiferente = verificaNumeroDiferente($nombre, $coleccionPalabras[$numPalabra - 1], $coleccionPartidas);
                }
            } while (!$numDiferente);
            echo "\n";
            array_unshift($coleccionPartidas, jugarWordix($coleccionPalabras[$numPalabra - 1], $nombre));

            break;
        case 3:

            // mostrar una partida
            echo "Ingrese un número de partida para mostrar en pantalla: ";
            $numPartida = solicitarNumeroEntre(1, count($coleccionPartidas));
            mostrarPartida($coleccionPartidas, $numPartida);

            break;
        case 4:

            $nombreJugador = solicitarJugador();
            $palabraIndice = primeraGanadaJugador($coleccionPartidas, $nombreJugador);

            if ( $palabraIndice == -1){
                echo "\n El jugador no tiene una partida registrada. \n";
            }else {
                mostrarPartida($coleccionPartidas, $indicePartidasGanadas);
            }

            break;
        case 5;

            $nombreJugador = solicitarJugador();
            resumenJugador ($coleccionPartidas, $nombreJugador);

            break;
        case 6;

            $coleccionOrdenada = agregarPalabra ($coleccionPartidas, $palabraNueva);
            print_r ($coleccionOrdenada);

            break;
        case 7:

            $palabra = leerPalabra5Letras();

            while ($l < count($coleccionPalabras) - 1) {
                foreach ($coleccionPalabras as $j => $palabraIndice) {
                    while ($palabra == $palabraIndice) {
                        echo "La palabra $palabraIndice ya fue ingresada. ";
                        $palabra = leerPalabra5Letras();
                    }
                }
                $l++;
            }

            $coleccionPalabras = agregarPalabra($coleccionPalabras, $palabra);
    }
} while ($opcion != 8);