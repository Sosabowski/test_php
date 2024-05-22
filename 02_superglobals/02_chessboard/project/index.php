<?php
error_reporting(-1);
ini_set("display_errors", "On");
session_start();

$color = $_COOKIE["color"] ?? "gray"; //Kolor ma być przechowywany w cookie
$sx = $_SESSION["sx"] ?? 5; //Ustawiamy rozmiar tablicy w zakresie kolumn (default to 5)
$sz = $_SESSION["sz"] ?? 5; //Ustawiamy rozmiar tablicy w zakresie poziomów (default to 5)
$col = $_SESSION["col"] ?? array();
$licznik = $_SESSION["licznik"] ?? 0; //Zliczenia kliknięć <-Dzięki temu wiemy czy uzytkownik kliknął drugi raz
$x = $_SESSION["x"] ?? 0; //Koordy klikniętego punktu/kwadratu
$y = $_SESSION["y"] ?? 0;


if(isset($_POST["color"])) //Sprawdzanie, czy został wysłany formularz z wyborem kolorów
{
    $color = $_POST["color"];
    setcookie("color", $color);
}

?>

    <html lang="en">
    <head>
        <title>Superglobals</title>

        <style>
            .block {
                display: inline-block;
                width: 30px;
                height: 30px;
                padding: 0;
                margin: 0;
            }

            .block:hover {
                background-color: lightgray;
            }

            .cyan {
                background-color: cyan;
            }

            .magenta {
                background-color: magenta;
            }

            .yellow {
                background-color: yellow;
            }

            .gray {
                background-color: gray;
            }

            .white {
                background-color: white;
            }
        </style>
    </head>
    <body>


    <?php

    if(isset($_GET["x"]))
    {
        Zlicz();
        if($licznik==2) // Jeśli użytkownik kliknął dwa razy to wyzeruj counter oraz wykonaj Linia()
        {
            $licznik = 0;
            Linia(isset($x) ? $x : 0, isset($y) ? $y : 0,$_GET["x"],$_GET["z"]);
        }
        else
        {
            $x = $_GET["x"];
            $y = $_GET["z"];
        }
    }

    if(isset($_POST["sz"]))
    {
        $sz = $_POST["sz"] == "" ? $_SESSION["sz"] : $_POST["sz"];
    }

    if(isset($_POST["sx"]))
    {
        $sx = $_POST["sx"] == "" ? $_SESSION["sx"] : $_POST["sx"];
    }

    for($i = 0; $i < $sz; $i++) //Pętelka tworząca naszą planszę
    {
        echo "<div>";
        for ($i2 = 0; $i2<$sx; $i2++)
        {
            if(!isset($col["$i2"]["$i"]))
            {
                $col["$i2"]["$i"] = $color;
            }

            if($col["$i2"]["$i"] != "white")
            {
                $col["$i2"]["$i"] = $color;
            }

            $temp = $col["$i2"]["$i"];

            echo "<a class=\"block $temp\" href=\"?x=$i2&z=$i\"></a>";
        }
        echo "</div>";
    }

    ?>

    <br/>

    <form method="post">
        <label>
            Columns:
            <input type="text" name="sx">
        </label>
        <label>
            Rows:
            <input type="text" name="sz">
        </label>
        <input type="submit" value="Change">
    </form>

    <form method="post">
        <label>
            Color:
            <select name="color">
                <option value="gray">Gray</option>
                <option value="magenta">Magenta</option>
                <option value="yellow">Yellow</option>
                <option value="cyan">Cyan</option>
            </select>
        </label>
        <input type="submit" value="Change">
    </form>

    <?php
    $_SESSION["sx"] = $sx;
    $_SESSION["sz"] = $sz;
    $_SESSION["col"] = $col;
    $_SESSION["licznik"] = $licznik;
    $_SESSION["x"] = $x;
    $_SESSION["y"] = $y;
    ?>
    </body>
    </html>

<?php
function Zlicz()
{
    global $licznik;
    $licznik +=1;
}

function Linia($x1, $y1, $x2, $y2) //De facto algorytm Bresenhama, który znalazłem na necie
{
    global $col;
    $x = $x1;
    $y = $y1;

    if ($x1 < $x2)
    {
        $xi = 1;
        $dx = $x2 - $x1;
    }
    else
    {
        $xi = -1;
        $dx = $x1 - $x2;
    }

    if ($y1 < $y2)
    {
        $yi = 1;
        $dy = $y2 - $y1;
    }
    else
    {
        $yi = -1;
        $dy = $y1 - $y2;
    }

    $col[$x][$y] = "white";

    if ($dx > $dy)
    {
        $ai = ($dy-$dx)*2;
        $bi = $dy*2;
        $d = $bi-$dx;

        while ($x != $x2)
        {

            if ($d>=0)
            {
                $x +=$xi;
                $y +=$yi;
                $d +=$ai;
            }
            else
            {
                $d +=$bi;
                $x +=$xi;
            }
            $col[$x][$y] = "white";
        }
    }

    else
    {
        $ai = ($dx-$dy)*2;
        $bi = $dx*2;
        $d = $bi-$dy;

        while ($y != $y2)
        {

            if ($d >=0)
            {
                $x+=$xi;
                $y+=$yi;
                $d+=$ai;
            }
            else
            {
                $d+=$bi;
                $y+=$yi;
            }
            $col[$x][$y]="white";
        }
    }
}

?>