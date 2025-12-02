<?php
$input = file_get_contents('input.txt');
invalidIDs=0;
foreach (explode(',', $input) as $line) {
    $ID = explode('-', $line);
    foreach (range((int)trim($ID[0]), (int)trim($ID[1])) as $i) {
        if(($numberOfDigits = strlen((string)$i))%2 == 0) {
            if(substr_compare(substr($i, 0, $numberOfDigits/2), substr($i, $numberOfDigits/2, $numberOfDigits)) == 0) {
                invalidIDs+=$i;
            }
        else {
            if(substr_compare(substr((int)('0' . $i), 0, $numberOfDigits/2), substr($i, $numberOfDigits/2, $numberOfDigits)) == 0) {
                invalidIDs+=$i;
                }
            }
        }
    }
}
echo invalidIDs;
?>
