<?php

/**
 * @param $stringForFBHandle
 *
 * @return string
 */
function stringHandlerFB ($stringForFBHandle) {
    $arrayToHandle = explode(" ", $stringForFBHandle);

    $fizz = $arrayToHandle[0];
    $buzz = $arrayToHandle[1];
    $number3 = $arrayToHandle[2];

    $answerStringFB = '';
    $check = 1;
    while($number3 >= $check){
        if($check % $fizz == 0){
            $answerStringFB .= 'F';
            if($check % $buzz ==0){
                $answerStringFB .= 'B';
            }
        }
        if($check % $buzz == 0){
            $answerStringFB .= 'B';
        }
        if($check % $fizz != 0 && $check % $buzz != 0){
            $answerStringFB .= "$check";
        }
        $check++;
    }

    return $answerStringFB . "\n";
}

/**
 * @param $arrayWithAllStrings
 *
 * @return array
 */
function arrayHandlerLvl1($arrayWithAllStrings)
{
    $arrayWithAllNecessaryStrings = array();
    foreach ($arrayWithAllStrings as $key => $string) {
        if (!($key % 2)) {
            $arrayWithAllNecessaryStrings[] = $string;
        }
    }

    return $arrayWithAllNecessaryStrings;
}

/**
 * @param $arrayWithAllStrings
 *
 * @return array
 */
function arrayHandlerLvl2($arrayWithAllStrings)
{
    $sum = 0;
    foreach ($arrayWithAllStrings as $string) {
        $sum += strlen($string);
    }

    $average = $sum / count($arrayWithAllStrings);

    $arrayWithAllNecessaryStrings = array();
    foreach ($arrayWithAllStrings as $string) {
        if (strlen($string) > $average) {
            $arrayWithAllNecessaryStrings[] = $string;
        }
    }

    return $arrayWithAllNecessaryStrings;
}

/**
 * @param $descriptorForRead
 *
 * @return array
 */
function fileReader($descriptorForRead) {
    $arrayWithAllStrings = array();

    while (!feof($descriptorForRead)) {
        $arrayWithAllStrings[] = fgets($descriptorForRead);
    }
    fclose($descriptorForRead);

    return $arrayWithAllStrings;
}

/**
 * @param $descriptorForWrite
 * @param $arrayWithAllNecessaryStrings
 */
function fileWriter($descriptorForWrite, $arrayWithAllNecessaryStrings) {
    foreach ($arrayWithAllNecessaryStrings as $necessaryString) {
        fwrite($descriptorForWrite, $necessaryString);
    }
    fclose($descriptorForWrite);
}

/**
 * @param $pathToRead
 * @param $pathToWriteLvl1
 * @param $pathToWriteLvl2
 * @param $pathToReadFB
 * @param $pathToWriteFB
 *
 * @return bool
 */
function read($pathToRead, $pathToWriteLvl1, $pathToWriteLvl2, $pathToReadFB, $pathToWriteFB)
{
    $descriptorForRead = fopen($pathToRead, 'r');
    $descriptorForReadFB = fopen($pathToReadFB, 'r');

    $descriptorForWriteLvl1 = fopen($pathToWriteLvl1, 'w+');
    $descriptorForWriteLvl2 = fopen($pathToWriteLvl2, 'w+');
    $descriptorForWriteFB = fopen($pathToWriteFB, 'w+');

    if ($descriptorForRead) {
        $arrayWithAllStrings = fileReader($descriptorForRead);

        /** task 1 */
        fileWriter($descriptorForWriteLvl1, arrayHandlerLvl1($arrayWithAllStrings));

        /** task 2 */
        fileWriter($descriptorForWriteLvl2, arrayHandlerLvl2($arrayWithAllStrings));

        /** task 3 FB */
        $arrayWithAllStrings = fileReader($descriptorForReadFB);
        $arrayWithAllFB = array();
        foreach ($arrayWithAllStrings as $stringForFBHandle) {
            $arrayWithAllFB[] = stringHandlerFB($stringForFBHandle);
        }
        fileWriter($descriptorForWriteFB, $arrayWithAllFB);

        return true;
    } else {
        echo "Ошибка\n";

        return false;
    }
}

read(
    'C:\Users\User\Desktop\PHP\hw_4\ForRead.txt',
    'C:\Users\User\Desktop\PHP\hw_4\ForWriteLv1.txt',
    'C:\Users\User\Desktop\PHP\hw_4\ForWriteLv2.txt',
    'C:\Users\User\Desktop\PHP\hw_4\FotReadFB.txt',
    'C:\Users\User\Desktop\PHP\hw_4\FotWriteFB.txt'
);

