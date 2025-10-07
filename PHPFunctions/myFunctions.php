<?php
#Revision history:
#
#Noah Dalbah    (2333960)   2025/03/10  Created the project, the pictures folder, the CSS folder and the PHPFunctions folder. Created the index.php, orders.php, buying.php and buyingConfirmation.php pages. 80% of the way done with index.php requirements (shuffle pictures, redirect to website on click, one picture different, page header and footer, display logo, welcome message). 70% done with buying.php requirements (display form, validate inputs, retain data, display error messages, submit form and redirect to confirmation page).
#
#Noah Dalbah    (2333960)   2025/03/10  Created a debugging function to show detailed and concise errors and exceptions and add them to an error log file
#	
#Noah Dalbah    (2333960)   2025/03/11  Added headers for UTF-8 to ensure proper display of French characters. Created a folder to store text files (cheat sheet, orders.txt). Written array into text file. Finished buying page functionality. Read array from text file and displayed information in a table in the orders page. Added "action=print" to orders page.	
#
#Noah Dalbah 	(2333960)   2025/03/11 Fixed the CSS in all the pages, added a link to view the cheat sheet, fixed company description in the index page, and fixed the welcome message and the confirmation message in the buying page. Deleted the buyingConfirmation page.	
#
#Noah Dalbah 	(2333960)   2025/03/11 Added the "action=color" functionality to the orders.php page. Added some comments. Changed the name of displayWelcomeMessage() function to displayCompanyDescription() to enhance clarity, not to be confused with the form in buying.php welcome message.	
#
#Noah Dalbah 	(2333960)   2025/03/11 Added comments to all of the files for ease of understanding the code. Filled the cheat sheet. Fixed the constants in myFunctions.php and index.php and fixed some styles in the CSS file. Finalized the project and prepared it for submission.	
#
#Noah Dalbah 	(2333960)   2025/03/11 Set the debugging constant for the function in myFunctions.php to false (done testing).	


    
    const TEXTFILE_FOLDER_PATH = "textFiles/";
    const PICTURES_FOLDER = "pictures/";

    //set to false after testing
    const DEBUGGING = false;

    function manageError($errorNumber, $errorMessage, $errorFile, $errorLine)
    {
        //never show confidential information to the end-users
        $genericError = "An error occurred on my website";
        $detailedError = date("Y/m/d h:i:sa") . " An error in the file $errorFile at line $errorLine : $errorNumber - $errorMessage \r\n";

        if(DEBUGGING)
        {
            //we're debugging, show detailed information on the screen
            echo $detailedError;
        }
        else
        {
            //we're not debugging, show generic information on the screen
            echo $genericError;
        }

        //use a constant for the error filename
        file_put_contents("errors.log", $detailedError, FILE_APPEND);

        //send all the network headers (BEFORE <DOCTYPE...>)
        //UTF-8
        header('Content-Type: text/html; charset=UTF-8');

        //prevent page caching
        header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }

    function manageException($error)
    {
        //never show confidentail information to the end-users
        $genericException = "An error occurred on my website";
        $detailedException = date("Y/m/d h:i:sa") . " An exception occurred in the file " . $error->getFile() . " at line " . $error->getLine() . " : " . $error->getCode() . " - " . $error->getMessage() . "\r\n";

            if(DEBUGGING)
        {
            echo $detailedException;
        }
        else
        {
            echo $genericException;
        }


        file_put_contents("errors.log", $detailedException, FILE_APPEND);
    }

    //enable error and exception detection
    set_error_handler("manageError");
    set_exception_handler("manageException");

    //function to display the page header and changes the name in the tab when the page changes (parameter)
    function pageHeader($title)
    {   header('Content-Type: text/html; charset=UTF-8');
        header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        ?>
        
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <link rel='stylesheet' type='text/css' href='CSS/styles.css'>
                <title><?php echo $title; ?></title>
            </head>
            <body class="<?php
            //contents of the if statement only execute in the orders.php page
            if($title == "Orders Page") 
            {   //if user specifies an action in the URL
                if(isset($_GET["action"]))
                {   //if the action is "print"
                    if($_GET["action"] == 'print'){
                        //set the "print" class to the body
                        echo htmlspecialchars($_GET["action"]);
                    }
                    else
                    {   //set "gradient" class
                        echo "gradient";
                    }
                }
                else
                {
                    echo "gradient";
                }
            }
            else
            {
                echo "gradient";
            }

            ?>">
        <?php
        
        //display company logo on all pages
        companyLogo();?><br><?php
        
        //call the navigation menu in all the pages by calling the page header function
        navigationMenu();
    }

    //function that displays the copyright message, name, student id, and the year dynamically at the footer of all the pages
    function pageFooter()
    {   
        ?> <div class="copyright"><br> Copyright &copy; Noah Dalbah (2333960) <?php echo date("Y");?> </div>
            </body>
        </html>   
        <?php

    }
    
    //function that displays the company logo across all pages
    function companyLogo()
    {
        ?>
        <img src="<?php echo PICTURES_FOLDER . "logo.jpg" ?>" class="logo">
        <?php
    }

    //function to display the navigation menu
    function navigationMenu()
    {
        //use styles to avoid blue underlined menus
        echo "<div class='navdiv'>" 
            . "<ul class='navbar'>"
            . "<li><a href = 'index.php'>Home Page</a></li>"
            . "<li><a href = 'buying.php'>Buying</a></li>"
            . "<li><a href = 'orders.php'>Orders</a></li>"
            . "</ul>"
        . "</div>";
    }

    //display the company description paragraph, with an option to add a name to display in the paragraph
    function displayCompanyDescription($name = "") 
    {   
        echo "<br><div class='description'>Hello $name and welcome to our website! MusicLife is a company specialized in making and selling musical instruments of all kinds, shapes, and sizes. Founded in 2021 by an aspiring musician, we have been growing bigger and more popular ever since. Our goal is to become a household name and be known for our excellence in responding to clients' demands and needs at all times and places!</div><br>";
    }
    
    //calculate the tax value on an order
    function calculateTax($subtotal, $taxRate, &$grandTotal) //the "&" allows you to pass a parameter by reference
    {
        $taxAmount = round($subtotal * $taxRate, 2);
        $grandTotal = $subtotal + $taxAmount;
        return $taxAmount;
    }
    
    //change the color of the data in the subtotal column based on their value
    function changeSubtotalColor(&$subtotal)
    {
        if($subtotal < 100)
        {
            echo "red";
        }
        elseif($subtotal>=100 && $subtotal <1000)
        {
            echo "orange";
        }
        else
        {
            echo "green";
        }
    }