<?php

function readmap($file)
{
	$filed = file($file);
	$firstline = trim($filed[0]);
	$oui=false;
	if (is_numeric(($firstline))) {
		$Number=intval(array_shift($filed));
		$number_of_lines =  count($filed);
		if ($number_of_lines > 1) {
			for( $i= 1 ; $i < $number_of_lines ; $i++) {
				$number_of_columns = strlen(trim($filed[$i]));
				$firstnumber_of_columns = strlen(trim($filed[1]));
				if ($number_of_columns == $firstnumber_of_columns) {
					if (preg_match("/[.o]/",$filed[$i]) ) {
						if ($Number == $number_of_lines) {
							$oui=true;
						}
						else {
							print("The Number on the first line of the file does not correspond to the number of lines in the files\n");
							exit();
						}
					}
					else {
						print("The File does not have the correct lines stuff in it\n");
						exit();
					}
				}
				else {
					print("The File does not have an equal number of columns\n");
					exit();
				}
			}
		}
		if ($oui == true) {
			for ($j=0; $j < $number_of_lines; $j++) { 
				$filed[$j]=str_split(trim($filed[$j]));
			}
			square($filed, $number_of_columns, $number_of_lines,$Number);
		}
	}
	else {
		print("The File does not start with a number\n");
		exit();
	}
}


function square($filed, $number_of_columns, $number_of_lines,$Number)
{
	$SecondTab = SearchfornoEmptySpace($filed,$number_of_lines,$number_of_columns);
	$GrandCarre = 0;
    for ($line=0;$line < $number_of_lines; $line++) {
        for ($colone=0;$colone < $number_of_columns; $colone++) {
            if ($SecondTab[$line][$colone]> $GrandCarre) {
                $GrandCarre= $SecondTab[$line][$colone];
            }
        }
    }
    $TestableCarre=$GrandCarre;
   Recursive($filed,$number_of_columns,$number_of_lines,$TestableCarre,$GrandCarre);
   print_r($filed);
}

function Recursive($filed , $number_of_columns, $number_of_lines,$TestableCarre,$GrandCarre) {
    for ($l=$GrandCarre;$l < $number_of_lines; $l++) {
        for ($c=$GrandCarre;$c < $number_of_columns; $c++) {
            while ($TestableCarre>= 0) {
                if ($filed[$l][$c] == "." && $filed[$l-$TestableCarre][$c] == "." && $filed[$l][$c-$TestableCarre] == "." && $filed[$l-$TestableCarre][$c-$TestableCarre] == ".") {
                    $filed[$l][$c]="X";
                    //Recursive($filed,$number_of_columns,$number_of_lines,$TestableCarre-1,$GrandCarre);
                }

            }
        }
    }
}

function SearchfornoEmptySpace($filed,$number_of_lines,$number_of_columns)
{
	for ($lignes=0; $lignes < $number_of_lines; $lignes++) { 
		for ($colonnes=0; $colonnes < $number_of_columns; $colonnes++) { 
			if (strstr($filed[$lignes][$colonnes],'.') == false) {
				print("The File doesn't have an empty space\n");
				exit();
			}
			else {
				GoingThroughAndDuplicate($filed,$number_of_lines,$number_of_columns);
				exit();
			}
		}
	}
}


function GoingThroughAndDuplicate($filed, $number_of_lines, $number_of_columns)
{
	$SecondTableau;
	$PlusGrandCarre=0;
	for ($lignes=0; $lignes < $number_of_lines; $lignes++) { 
		for ($colonnes=0; $colonnes < $number_of_columns; $colonnes++) {
			
			//echo "PlusGrandCarre : ".$PlusGrandCarre."\n";
			if ($filed[$lignes][$colonnes] == '.') {
				if ($lignes == 0) {
					$PlusGrandCarre= 1;
					$SecondTableau[$lignes][$colonnes] = $PlusGrandCarre;
				}
				else if ($colonnes == 0) {
					$SecondTableau[$lignes][$colonnes] = 0;
				}
				else {
					$mincar = min($SecondTableau[$lignes-1][$colonnes-1],$SecondTableau[$lignes-1][$colonnes],$SecondTableau[$lignes][$colonnes-1])+1;
					//echo "mincar : ".$mincar."\n";
					if ($mincar > $PlusGrandCarre) {
						$PlusGrandCarre = $mincar;
					}
					$SecondTableau[$lignes][$colonnes]=$mincar;
					//print($SecondTableau[$colonnes]);
					
				}
			}
			else if ($filed[$lignes][$colonnes] == 'o') {
				$SecondTableau[$lignes][$colonnes] = 0;
			}
		}
	}
}


/*function GoingThroughAndDuplicate($filed,$number_of_lines,$number_of_columns)
{
	$SecondTableau=[];
	$findeligne=false;
	$CounterObstacle=0;
	for ($lignes=0; $lignes < $number_of_lines; $lignes++) { 
		for ($colonnes=0; $colonnes < $number_of_columns; $colonnes++) {
			$SecondTableau[$lignes]=array();
			if ($CounterObstacle==0) {										//Verif si un obstacle a déjà été croisé
				
				if (($colonnes+1)==$number_of_columns) {					//Verif si fin de ligne
					
				}
				else {
					if ($filed[$lignes][$colonnes] == ".") {				//Verif si c'est un espace libre
						if ($colonnes-1 >= 0) {
							if ($SecondTableau[$lignes][$colonnes-1] != 0) {
								$CounterObstacle++;
								$SecondTableau[$lignes][$colonnes] = $CounterObstacle;
							}
						}
					}
				}
			}
			elseif ($CounterObstacle > 0) {
			 	if (($colonnes+1)==$number_of_columns) {
				
				}
				else {
					if ($filed[$lignes][$colonnes] == ".") {
						$SecondTableau[$lignes][$colonnes] = 0;
					}
					elseif ($filed[$lignes][$colonnes] == "o") {
						$CounterObstacle++;
					}
				}
			}
		}
	}
}*/




readmap('plateau.txt');
?>