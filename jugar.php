<?php
// Array con la informacion de las apuestas
$apuestas = [
    ["nombre" => "Rojo/Negro", "descripcion" => "Apostar a si el numero ganador es rojo o negro.", "premio" => "1 x 1", "ejemplo" => "Rojo"],
    ["nombre" => "Par/Impar", "descripcion" => "Apostar a si el numero ganador es par o impar.", "premio" => "1 x 1", "ejemplo" => "Par"],
    ["nombre" => "Pasa/Falta", "descripcion" => "Falta del 1 al 18 y Pasa del 19 al 36.", "premio" => "1 x 1", "ejemplo" => "Falta"],
    ["nombre" => "Docena", "descripcion" => "Apostar a una de las tres docenas.", "premio" => "2 x 1", "ejemplo" => "1.ª docena"],
    ["nombre" => "Columna", "descripcion" => "Apostar a una de las tres columnas.", "premio" => "2 x 1", "ejemplo" => "Columna 1"],
    ["nombre" => "Dos docenas", "descripcion" => "Apostar a dos docenas contiguas.", "premio" => "0,5 x 1", "ejemplo" => "1-2"],
    ["nombre" => "Dos columnas", "descripcion" => "Apostar a dos columnas contiguas.", "premio" => "0,5 x 1", "ejemplo" => "1-2"],
    ["nombre" => "Seisena", "descripcion" => "Apostar a seis numeros de dos filas contiguas.", "premio" => "5 x 1", "ejemplo" => "1-6"],
    ["nombre" => "Cuadro", "descripcion" => "Apostar a cuatro numeros que forman un cuadrado.", "premio" => "8 x 1", "ejemplo" => "1-2-4-5"],
    ["nombre" => "Transversal", "descripcion" => "Apostar a tres numeros de una misma fila.", "premio" => "11 x 1", "ejemplo" => "1-2-3"],
    ["nombre" => "Caballo", "descripcion" => "Apostar a dos numeros contiguos.", "premio" => "17 x 1", "ejemplo" => "1-2"],
    ["nombre" => "Pleno", "descripcion" => "Apostar a un solo numero.", "premio" => "35 x 1", "ejemplo" => "17"]
];

// Array de los numeros del tablero
$numerosRuleta = [
    [3, 2, 1],
    [6, 5, 4],
    [9, 8, 7],
    [12, 11, 10],
    [15, 14, 13],
    [18, 17, 16],
    [21, 20, 19],
    [24, 23, 22],
    [27, 26, 25],
    [30, 29, 28],
    [33, 32, 31],
    [36, 35, 34]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino | Ruleta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Casino - Ruleta</h1>
    <p>A probar suerte chaval</p>
</header>

<main>

    <section class="informacion">
        <h2>Tabla de apuestas</h2>

        <div class="contenedor-tabla">
            <table class="tabla-apuestas">
                <thead>
                    <tr>
                        <th>Apuesta</th>
                        <th>Se juega a</th>
                        <th>Premio</th>
                        <th>Ejemplo</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($apuestas as $apuesta) { ?>
                        <tr>
                            <td><?php echo $apuesta["nombre"]; ?></td>
                            <td><?php echo $apuesta["descripcion"]; ?></td>
                            <td><?php echo $apuesta["premio"]; ?></td>
                            <td><?php echo $apuesta["ejemplo"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>


    <section class="juego">

        <h2>Realiza tu apuesta</h2>

        <form action="jugar.php" method="GET">

            <label for="tipo">Tipo de apuesta:</label>

            <select name="tipo" id="tipo" required>

                <option value="">Selecciona una apuesta</option>
                <option value="color">Rojo / Negro</option>
                <option value="parimpar">Par / Impar</option>
                <option value="pasafalta">Pasa / Falta</option>
                <option value="pleno">Pleno</option>
                <option value="docena">Docena</option>
                <option value="columna">Columna</option>
                <option value="dosdocenas">Dos docenas</option>
                <option value="doscolumnas">Dos columnas</option>
                <option value="seisena">Seisena</option>
                <option value="cuadro">Cuadro</option>
                <option value="transversal">Transversal</option>
                <option value="caballo">Caballo</option>

            </select>


            <label>Selecciona tu apuesta:</label>

            <div id="opciones" class="tablero">
                <!-- Aqui se generan las opciones -->
            </div>


            <label>Dinero a apostar:</label>

            <input type="number" name="cantidad" min="0.01" step="0.01" required>


            <button type="submit">Jugar</button>

        </form>

    </section>

</main>


<script>

// Array de numeros rojos
const rojos = [
    1, 3, 5, 7, 9, 12, 14, 16, 18,
    19, 21, 23, 25, 27, 30, 32, 34, 36
];

// Array del tablero
const numerosRuleta = [
    [3, 2, 1],
    [6, 5, 4],
    [9, 8, 7],
    [12, 11, 10],
    [15, 14, 13],
    [18, 17, 16],
    [21, 20, 19],
    [24, 23, 22],
    [27, 26, 25],
    [30, 29, 28],
    [33, 32, 31],
    [36, 35, 34]
];

const tipo = document.querySelector("#tipo");
const opciones = document.querySelector("#opciones");


// Funcion para crear una opcion de apuesta
function crearOpcion(valor, texto) {

    opciones.innerHTML += `
        <div class="casilla">
            <input type="radio" name="valor"
                   value="${valor}" id="opcion${valor}" required>

            <label for="opcion${valor}">
                ${texto}
            </label>
        </div>
    `;

}


// Funcion para crear el tablero del pleno
function crearPleno() {

    opciones.innerHTML = "";

    opciones.innerHTML += `
        <div class="casilla verde">
            <input type="radio" name="valor" value="0" id="opcion0" required>
            <label for="opcion0">0</label>
        </div>
    `;

    for (let i = 0; i < numerosRuleta.length; i++) {

        for (let j = 0; j < numerosRuleta[i].length; j++) {

            let numero = numerosRuleta[i][j];
            let color = "negro";

            if (rojos.includes(numero)) {
                color = "rojo";
            }

            opciones.innerHTML += `
                <div class="casilla ${color}">
                    <input type="radio" name="valor"
                           value="${numero}" id="opcion${numero}" required>
                    <label for="opcion${numero}">${numero}</label>
                </div>
            `;
        }
    }

}


// Funcion para crear las opciones de cada apuesta
function cambiarOpciones() {

    opciones.innerHTML = "";

    switch (tipo.value) {

        case "color":
            crearOpcion("rojo", "Rojo");
            crearOpcion("negro", "Negro");
            break;

        case "parimpar":
            crearOpcion("par", "Par");
            crearOpcion("impar", "Impar");
            break;

        case "pasafalta":
            crearOpcion("falta", "Falta (1-18)");
            crearOpcion("pasa", "Pasa (19-36)");
            break;

        case "pleno":
            crearPleno();
            break;

        case "docena":
            crearOpcion("1", "1.ª docena (1-12)");
            crearOpcion("2", "2.ª docena (13-24)");
            crearOpcion("3", "3.ª docena (25-36)");
            break;

        case "columna":
            crearOpcion("1", "Columna 1");
            crearOpcion("2", "Columna 2");
            crearOpcion("3", "Columna 3");
            break;

        case "dosdocenas":
            crearOpcion("1-2", "Docena 1 y 2");
            crearOpcion("2-3", "Docena 2 y 3");
            break;

        case "doscolumnas":
            crearOpcion("1-2", "Columnas 1 y 2");
            crearOpcion("2-3", "Columnas 2 y 3");
            break;

        case "seisena":
            crearSeisenas();
            break;

        case "cuadro":
            crearCuadros();
            break;

        case "transversal":
            crearTransversales();
            break;

        case "caballo":
            crearCaballos();
            break;

    }

}


// Crear combinaciones de seis numeros
function crearSeisenas() {

    for (let i = 0; i < numerosRuleta.length - 1; i++) {

        let numeros = [];

        for (let j = 0; j < 3; j++) {
            numeros.push(numerosRuleta[i][j]);
            numeros.push(numerosRuleta[i + 1][j]);
        }

        let valor = numeros.join("-");

        crearOpcion(valor, numeros.join(", "));
    }

}


// Crear combinaciones de cuatro numeros (cuadros)
function crearCuadros() {

    for (let i = 0; i < numerosRuleta.length - 1; i++) {

        for (let j = 0; j < 2; j++) {

            let numeros = [
                numerosRuleta[i][j],
                numerosRuleta[i][j + 1],
                numerosRuleta[i + 1][j],
                numerosRuleta[i + 1][j + 1]
            ];

            let valor = numeros.join("-");

            crearOpcion(valor, numeros.join(", "));
        }

    }

}


// Crear apuestas transversales (3 numeros)
function crearTransversales() {

    // Transversales del 1 al 36
    for (let i = 0; i < numerosRuleta.length; i++) {

        let numeros = numerosRuleta[i];
        let valor = numeros.join("-");

        crearOpcion(valor, numeros.join(", "));
    }
    
    crearOpcion("0-1-2", "0, 1, 2");
    crearOpcion("0-2-3", "0, 2, 3");

}


// Crear apuestas caballo (2 numeros contiguos)
function crearCaballos() {

    for (let i = 0; i < numerosRuleta.length; i++) {

        // Caballos horizontales
        for (let j = 0; j < 2; j++) {

            let numeros = [
                numerosRuleta[i][j],
                numerosRuleta[i][j + 1]
            ];

            let valor = numeros.join("-");

            crearOpcion(valor, numeros.join(", "));
        }

    }

    // Caballos verticales
    for (let i = 0; i < numerosRuleta.length - 1; i++) {

        for (let j = 0; j < 3; j++) {

            let numeros = [
                numerosRuleta[i][j],
                numerosRuleta[i + 1][j]
            ];

            let valor = numeros.join("-");

            crearOpcion(valor, numeros.join(", "));
        }

    }

}


// Cuando cambiamos el tipo de apuesta
tipo.addEventListener("change", cambiarOpciones);


</script>

</body>