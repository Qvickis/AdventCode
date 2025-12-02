<?php
$input = file_get_contents('input.txt');
$invalidIDs=0;
foreach (explode(',', $input) as $line) {
    $line = trim($line);
    $ID = explode('-', $line);
    foreach (range((int)trim($ID[0]), (int)trim($ID[1])) as $i) {
        $iStr = (string)$i;
        $numberOfDigits = strlen($iStr);
        
        // Invalid IDs must have an even number of digits (some sequence repeated twice)
        if($numberOfDigits % 2 == 0) {
            // Compare first half with second half
            $halfLength = $numberOfDigits / 2;
            if(substr($iStr, 0, $halfLength) === substr($iStr, $halfLength, $halfLength)) {
                $invalidIDs+=$i;
            }
        }
        // Odd-digit numbers cannot be invalid (can't split into two equal halves)
    }
}
echo $invalidIDs;
?>
