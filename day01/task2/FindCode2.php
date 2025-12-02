<?php
// create a function that reads the input.txt file and stores it in an array 
function readInput() {
    // this handle can be used to read the file line by line 
    $handle = fopen('input.txt', 'r');
    return $handle;
}

function number_of_zero_location($handle) {
    // Track absolute position (never wrap it, so we can count all crossings)
    $absolute_position = 50;
    $zero_location = 0;
    
    // Read file line by line
    while (($line = fgets($handle)) !== false) {
        $line = trim($line); // Remove whitespace and newline
        
        if (empty($line)) {
            continue; // Skip empty lines
        }
        
        // Store previous absolute position before the move
        $previous_absolute = $absolute_position;
        
        // Check if line starts with 'L' or 'R'
        if (substr($line, 0, 1) === 'L') {
            // Extract number after 'L'
            $number = (int)substr($line, 1);
            $absolute_position = $absolute_position - $number;
        } elseif (substr($line, 0, 1) === 'R') {
            // Extract number after 'R'
            $number = (int)substr($line, 1);
            $absolute_position = $absolute_position + $number;
        }
        
        // Count how many times position 0 is crossed or stopped at during this move
        // Position 0 in the wrapped space (0-99) corresponds to all absolute positions that are multiples of 100
        // We need to count all multiples of 100 that we pass through or end on
        
        if ($previous_absolute != $absolute_position) {
            // Count all multiples of 100 in the range (previous, current] for forward moves
            // or [current, previous) for backward moves
            // But we always want to include the end position if it's a multiple
            
            $start = $previous_absolute;
            $end = $absolute_position;
            
            if ($start < $end) {
                // Forward move: count multiples in (start, end]
                $low = $start + 1;  // Start just after the starting position
                $high = $end;       // Include the ending position
            } else {
                // Backward move: count multiples in [end, start)
                $low = $end;        // Include the ending position
                $high = $start - 1; // End just before the starting position
            }
            
            // Find the first and last multiples of 100 in the range [low, high]
            // First multiple >= low: if low is a multiple, use it; otherwise use the next multiple
            if ($low % 100 == 0) {
                $first_multiple = $low;
            } else {
                $first_multiple = (floor($low / 100) + 1) * 100;
            }
            
            // Last multiple <= high
            $last_multiple = floor($high / 100) * 100;
            
            // Count all multiples in the range
            if ($first_multiple <= $last_multiple) {
                $count = (($last_multiple - $first_multiple) / 100) + 1;
                $zero_location += $count;
            }
        }
    }
    
    return $zero_location;
}

// Execute the function and print the result
$handle = readInput();
$result = number_of_zero_location($handle);
fclose($handle);
echo "Number of times zero location was reached: " . $result . "\n";
