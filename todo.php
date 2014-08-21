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

function list_from_file($filename, $array) {
    // Open file, save content of file to a string $content and close the file.
    $handle = fopen($filename, 'r');
    $content = trim(fread($handle, filesize($filename)));
    fclose($handle);

    // Create an array from the string $content.
    $list = explode("\n", $content);

    foreach($list as $item) {
        // Remove first item from $list array and save its value to $addItemFromFile
        $addItemFromFile = array_shift($list);

        // Push each removed item onto the $array list
        array_push($array, $addItemFromFile);
    }
    // Return the newly edited array outside of the function.
    return $array;
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

function save_file($items) {
    // Ask user for path and filename.
    fwrite(STDOUT, 'Please enter a path/filename for the file: ');
    // Save filepath
    $filename = get_input();
    // Check if file already exists or not.
    if (file_exists($filename)) {
        // Display warning if file exists, check if user wants to overwrite
        fwrite(STDOUT, 'Warning: This file already exists. Would you like to' 
                        . ' overwrite this file? (Y)es or (N)o: ');
        $confirm = get_input(TRUE);
        switch ($confirm) {
            case 'Y':
                $handle = fopen($filename, 'w');
                foreach($items as $listItem) {
                    fwrite($handle, $listItem . PHP_EOL);
                }
                fclose($handle);
                fwrite(STDOUT, 'Your file has been saved.' . PHP_EOL);    
                break;
            case 'N':
                fwrite(STDOUT, 'File was NOT saved.' . PHP_EOL);
                break;
            default:
                fwrite(STDOUT, 'File was NOT saved.' . PHP_EOL);
                break;
        }
    } else {
        $handle = fopen($filename, 'a');
        foreach($items as $listItem) {
            fwrite($handle, $listItem . PHP_EOL);
        }
        fclose($handle);
        fwrite(STDOUT, 'Your file has been saved.' . PHP_EOL);        
    }
}
// The loop!
do {
    // Echo the list produced by the function
    fwrite(STDOUT, list_items($items));

    // Show the menu options
    fwrite(STDOUT, '(N)ew item, (O)pen file, (R)emove item, (S)ort, S(A)ve, (Q)uit : ');

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check which menu option to run
    switch($input) {
        case 'N':
            // Ask for entry
            fwrite(STDOUT, 'Enter item: ');

            $addItem = get_input();
            if(empty($items)) {
                array_push($items, $addItem);
            }
            else {
                fwrite(STDOUT, 'Do you want to add this to' 
                            .  'the (B)eginning or the (E)nd of the list?');
                $begOrEnd = get_input(TRUE);
                switch($begOrEnd) {
                    case 'B':
                        array_unshift($items, $addItem);
                        break;
                    case 'E':
                        array_push($items, $addItem);
                        break;
                    default:
                        array_push($items, $addItem);
                        break;
                }
            }
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
        case 'O':
            // Open a file and add contents to list.
            fwrite(STDOUT, 'Please enter a path/filename: ');
            $filename = get_input();
            $items = list_from_file($filename, $items);
            break;
        case 'S':
            // Load sort menu
            $items = sort_menu($items);        
            break;
        case 'A':
            // Save list to a file.
            save_file($items);
            break;
        case 'F':
            array_shift($items);
            break;
        case 'L':
            array_pop($items);
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