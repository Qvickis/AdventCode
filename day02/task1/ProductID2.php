<?php
$input = file_get_contents('input.txt');
$invalidIDs=0;
foreach (explode(',', $input) as $line) {
    $line = trim($line);
    $ID = explode('-', $line);
    foreach (range((int)trim($ID[0]), (int)trim($ID[1])) as $i) {
        $iStr = (string)$i;
        $numberOfDigits = strlen($iStr);
        
        // Check if the number is made of a sequence repeated at least twice
        // Try all possible segment lengths from 1 to floor(n/2)
        $isInvalid = false;
        for($segmentLength = 1; $segmentLength <= $numberOfDigits / 2; $segmentLength++) {
            // Check if the number of digits is divisible by segment length
            if($numberOfDigits % $segmentLength == 0) {
                $numSegments = $numberOfDigits / $segmentLength;
                // Need at least 2 repetitions
                if($numSegments >= 2) {
                    $firstSegment = substr($iStr, 0, $segmentLength);
                    $allMatch = true;
                    // Check if all segments are identical
                    for($seg = 1; $seg < $numSegments; $seg++) {
                        $currentSegment = substr($iStr, $seg * $segmentLength, $segmentLength);
                        if($currentSegment !== $firstSegment) {
                            $allMatch = false;
                            break;
                        }
                    }
                    if($allMatch) {
                        $isInvalid = true;
                        break; // Found a valid pattern, no need to check other segment lengths
                    }
                }
            }
        }
        
        if($isInvalid) {
            $invalidIDs+=$i;
        }
    }
}
echo $invalidIDs;
?>
