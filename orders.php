<?php
#Revision history:
#
#2025/03/10  Created the project, the pictures folder, the CSS folder and the PHPFunctions folder. Created the index.php, orders.php, buying.php and buyingConfirmation.php pages. 80% of the way done with index.php requirements (shuffle pictures, redirect to website on click, one picture different, page header and footer, display logo, welcome message). 70% done with buying.php requirements (display form, validate inputs, retain data, display error messages, submit form and redirect to confirmation page).
#
#2025/03/10  Created a debugging function to show detailed and concise errors and exceptions and add them to an error log file
#	
#2025/03/11  Added headers for UTF-8 to ensure proper display of French characters. Created a folder to store text files (cheat sheet, orders.txt). Written array into text file. Finished buying page functionality. Read array from text file and displayed information in a table in the orders page. Added "action=print" to orders page.	
#
#2025/03/11 Fixed the CSS in all the pages, added a link to view the cheat sheet, fixed company description in the index page, and fixed the welcome message and the confirmation message in the buying page. Deleted the buyingConfirmation page.	
#
#2025/03/11 Added the "action=color" functionality to the orders.php page. Added some comments. Changed the name of displayWelcomeMessage() function to displayCompanyDescription() to enhance clarity, not to be confused with the form in buying.php welcome message.	
#
#2025/03/11 Added comments to all of the files for ease of understanding the code. Filled the cheat sheet. Fixed the constants in myFunctions.php and index.php and fixed some styles in the CSS file. Finalized the project and prepared it for submission.	
#
#2025/03/11 Set the debugging constant for the function in myFunctions.php to false (done testing).	



    require_once 'PHPFunctions/myFunctions.php';

    pageHeader("Orders Page");
    
    //reading from a file:
    //prevent code from crashing if the file does not exist or is not found
    if(file_exists(TEXTFILE_FOLDER_PATH . "orders.txt"))
    {   //open the file (and get a file handle)
        $fileHandle = fopen(TEXTFILE_FOLDER_PATH . "orders.txt", "r") or exit("Unable to open the file");
        
        //create the table and the table headers
        echo "<table class='table'>"
        . "<tr>"
                . "<th>Product ID</th>"
                . "<th>First name</th>"
                . "<th>Last name</th>"
                . "<th>City</th>"
                . "<th>Comments</th>"
                . "<th>Price</th>"
                . "<th>Quantity</th>"
                . "<th>Subtotal</th>"
                . "<th>Taxes</th>"
                . "<th>Grand total</th>"
        . "</tr>";

        //loop into the file to read all the names
        while(! feof($fileHandle))
        {
            $fileJSONLine = fgets($fileHandle);

            //make sure the line is not the last empty line
            if($fileJSONLine != "")
            {
                $fileLineArray = json_decode($fileJSONLine);   

                echo "<tr>";
                //product id
                echo "<td>" . $fileLineArray[0] . "</td>";
                
                //first name
                echo "<td>" . $fileLineArray[1] . "</td>";
                
                //last name
                echo "<td>" . $fileLineArray[2] . "</td>";
                
                //city
                echo "<td>" . $fileLineArray[3] . "</td>";
                
                //comments
                echo "<td>" . $fileLineArray[4] . "</td>";
                
                //price
                echo "<td class='dollar'>" . $fileLineArray[5] . "</td>";
                
                //quantity
                echo "<td>" . $fileLineArray[6] . "</td>" ?>

                <!-- subtotal -->
                <td class="dollar <?php 
                
                //check if the user has set an action in the URL
                if(isset($_GET["action"]))
                {   //if user has set action=color, change the color of the subtotal values using the changeSubtotalColor() function
                    if($_GET["action"] == 'color')
                    {
                        changeSubtotalColor($fileLineArray[7]);
                    }
                    else
                    {   
                        //if action=color has not been set, keep everything as is
                    }
                }?>"><?php echo $fileLineArray[7] ?> </td> <?php
                
                //Taxes
                echo "<td class='dollar'>" . $fileLineArray[8] . "</td>";
                
                //Grand total
                echo "<td class='dollar'>" . $fileLineArray[9] . "</td>";

                echo "</tr>";
            }
        }
        echo "</table><br>";

        //close the file (and get rid of the file handle)
        fclose($fileHandle);

            //link to view php cheat sheet
        ?> <a href="<?php echo TEXTFILE_FOLDER_PATH . "cheatSheet.txt" ?>" target="_blank">View my PHP cheat sheet</a> <?php
    } 
    //copyright
    pageFooter();            
