<?php

 // Create array to hold list of todo items
 $items = array();

// List array items formatted for CLI
function list_items($list)
{
    // Create empty starter string
    $listString = '';
    
    // Loop through an array $list to pull out $key and $items from the array.
    foreach ($list as $key => $items) {
        // Increment $key so list number starts at 1 rather than 0.
        $key++;
        // Concatenate each list item to $listString
        $listString .= "[{$key}] {$items}" . PHP_EOL;
    }
    return $listString;
}

// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
function get_input($upper = FALSE) 
{   
    $userInput = trim(fgets(STDIN));

    // Ternary Version
    return $upper ? $userInput = strtoupper($userInput) : $userInput;
}

function sort_menu($array) {
    // Give user new menu options for sort type
    fwrite(STDOUT, '(A)-Z, (Z)-A, (O)rder Entered, (R)everse Order Entered' . PHP_EOL);
    
    // Grab user's input with get_input and make sure it's uppercase
    $input = get_input(TRUE);
    
    // Test user input to match it with a sort type
    switch($input) {
        case 'A':
            asort($array);
            break;
        case 'Z':
            arsort($array);
            break;
        case 'O':
            ksort($array);
            break;
        case 'R':
            krsort($array);
            break;    
        default:
            break;
    }
    // Return new, sorted array outside of function scope.
    return $array;

}


// The loop!
do {
    // Echo the list produced by the function
    fwrite(STDOUT, list_items($items));

    // Show the menu options
    fwrite(STDOUT, '(N)ew item, (R)emove item, (S)ort, (Q)uit : ');

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check which menu option to run
    switch($input) {
        case 'N':
            // Ask for entry
            fwrite(STDOUT, 'Enter item: ');
            // Add entry to list array
            $items[] = get_input();
            break;
        case 'R':
            // Remove which item?
            fwrite(STDOUT, 'Enter item number to remove: ');
            // Get array key
            $key = get_input();
            // Remove from array
            unset($items[--$key]);
            $items = array_values($items);
            break;
        case 'S':
            // Load sort menu
            $items = sort_menu($items);        
            break;
        default:
            break;
    }

// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
fwrite(STDOUT, "Goodbye!" . PHP_EOL);

// Exit with 0 errors
exit(0);

?>