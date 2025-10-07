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

    //logo, headers
    pageHeader("Home");
    
    //company description paragraph
    displayCompanyDescription();
    
    //save the pictures into an array
    $instruments = array("drums.jpg", "guitar.jpg", "piano.JPG", "sax.jpg", "violin.jpg");
    
    //shuffle the array
    shuffle($instruments);
    
    //display one picture randomly, because we already shuffled the array?>
    <a href="https://stevesmusic.com/?srsltid=AfmBOoq92UjkBjCN-g6G1zvsnCGaPAIE4ArdiTyiP8YT_IcqvS7mhjSt" target="_blank"><img src="<?php echo PICTURES_FOLDER . $instruments[0] ?>" class='<?php 
                if($instruments[0] == "drums.jpg")
                {
                    echo "specialPicture";
                } 
                else
                {
                    echo "smallPicture";
                }?>'></a>
<?php

    //copyright 
    pageFooter();
