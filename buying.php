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

    //set constants at the top of the page
    const PRODUCT_CODE_MAX_LENGTH = 25;
    const FIRST_NAME_MAX_LENGTH = 20;
    const LAST_NAME_MAX_LENGTH = 20;
    const CITY_NAME_MAX_LENGTH = 30;
    const COMMENT_MAX_LENGTH = 200;
    const MAX_PRICE = 10000;
    const MIN_PRICE = 0;
    const MAX_QUANTITY = 99;
    const MIN_QUANTITY = 1;
    const PRODUCT_CODE_REQ = "PRD";


    //variable definitions
    $productCode = "";
    $firstname = "";
    $lastname = "";
    $city = "";
    $comment = "";
    $price = "";
    $quantity = "";
    $welcomeMessage = "";
    $subtotal = 0;
    $taxAmount = 0;
    $grandTotal = 0;
    $totalMessage = "";
            
    $errorProductCode = "";
    $errorFirstName = "";
    $errorLastName = "";
    $errorCity = "";
    $errorComment = "";
    $errorPrice = "";        
    $errorQuantity = "";
    
    pageHeader("Buying Page");
    
    if(isset($_POST["connect"]))
    {
        //reading the variables and protect against html and js injection
        $productCode = htmlspecialchars(trim($_POST["productcode"]));
        $firstname = htmlspecialchars(trim($_POST["firstname"]));
        $lastname = htmlspecialchars(trim($_POST["lastname"]));
        $city = htmlspecialchars(trim($_POST["city"]));   
        $comment = htmlspecialchars(trim($_POST["comment"]));
        $price = htmlspecialchars(trim($_POST["price"]));
        $quantity = htmlspecialchars(trim($_POST["quantity"]));
        
        //make sure product code is not empty
        if($productCode == "")
        {
            $errorProductCode = "The product code cannot be empty";
        }
        else
        {
            if(mb_stripos($productCode, PRODUCT_CODE_REQ) === false) //=== in order to check if prd is possibly in position 0, which when using == will return false. As it's not a boolean, using === will not return false when 'prd' is included at position 0 of the string.
            {
                $errorProductCode = "The product code must include the letters 'PRD' (regardless of case)";
            }
            else
            {   //make sure product length is no longer than the maximum length
                if(mb_strlen($productCode) > PRODUCT_CODE_MAX_LENGTH)
                {
                    $errorProductCode = "The product code cannot contain more than " . PRODUCT_CODE_MAX_LENGTH . " characters.";
                }
                else 
                {
                    //product code valid, do nothing
                }
            }
        }
        
        //make sure first name is not empty
        if($firstname == "")
        {
            $errorFirstName = "The first name cannot be empty";
        }
        else 
        {   //make sure first name is no longer than the maximum length
            if(mb_strlen($firstname) > FIRST_NAME_MAX_LENGTH)
            {
                $errorFirstName = "The first name cannot contain more than " . FIRST_NAME_MAX_LENGTH . " characters.";
            }
            else
            {
                //the firstname is valid, do nothing
            }
        }
        
        //make sure last name is not empty
        if($lastname == "")
        {
            $errorLastName = "The last name cannot be empty";
        }
        else 
        {   //make sure last name does not exceed the maximum length
            if(mb_strlen($lastname) > FIRST_NAME_MAX_LENGTH)
            {
                $errorLastName = "The last name cannot contain more than " . LAST_NAME_MAX_LENGTH . " characters.";
            }
            else
            {
                //the lastname is valid, do nothing
            }
        }
        
        //if both first name and last name are correctly entered
        if($errorFirstName == "" && $errorLastName == "")
        {
            //both first and last name are valid, we can use them for the welcome message
            $welcomeMessage = "Welcome " . htmlspecialchars($_POST["firstname"]) . " " . htmlspecialchars($_POST["lastname"]) . "!";

        }
        
        //make sure city is not empty
        if($city == "")
        {
            $errorCity = "The city name cannot be empty";
        }
        else
        {   //make sure the city name does not exceed the maximum length
            if(mb_strlen($city) > CITY_NAME_MAX_LENGTH)
            {
                $errorCity = "The city name cannot contain more than " . CITY_NAME_MAX_LENGTH . " characters.";
            }
            else
            {
                //city name valid, do nothing
            }
        }
        
        
        if($comment != "")
        {   //if user choses to enter a comment (not required), make sure it doesn't exceed the maximum length
            if(mb_strlen($comment) > COMMENT_MAX_LENGTH)
            {
                $errorComment = "The comment cannot contain more than " . COMMENT_MAX_LENGTH . " characters.";
            }
            else
            {
                //comment length valid, do nothing
            }
        }
        
        //make sure the price is not empty
        if($price == "")
        {
            $errorPrice = "The price cannot be empty";
        }
        else
        {
            //check if the input is numeric
            if(is_numeric($price))
            {
                //validate the price
                if($price >= MIN_PRICE && $price <= MAX_PRICE)
                {
                    //everything is good, nothing to do
                }
                else
                {   //price does not respect the limits
                    $errorPrice = "Please enter a numeric value between " . MIN_PRICE . " and " . MAX_PRICE;
                }
            }
            else
            {   //non-numeric value
                $errorPrice = "Please enter a numeric value between " . MIN_QUANTITY . " and " . MAX_PRICE;
            }
        }
        
        //make sure the quantity is not empty
        if($quantity == "")
        {
            $errorQuantity = "The quantity cannot be empty";
        }
        else 
        {   //check if the input is numeric
            if(is_numeric($quantity))
            {   //make sure it contains no decimals
                if((float)$quantity == (int)$quantity)
                {   //it's a number, cast as integer
                    $quantity = (int)$quantity;
                    //make sure the number respects the rules of minimum and maximum quantities
                    if($quantity >= MIN_QUANTITY && $quantity <= MAX_QUANTITY)
                    {
                        //everything is good, nothing to do
                    }
                    else
                    {   //quantity too high or too low
                        $errorQuantity = "Please enter a numeric value between " . MIN_QUANTITY . " and " . MAX_QUANTITY;
                    }
                }
                else
                {   //decimals
                    $errorQuantity = "Decimals not allowed";
                }
            }
            else
            {
                //not a number
                $errorQuantity = "Please enter a numeric value between " . MIN_QUANTITY . " and " . MAX_QUANTITY;
            }
        }
        
        //both price and quantity values have been entered correctly
        if($errorPrice == "" && $errorQuantity == "")
        {   //calculate the subtotal, taxes, grand total and write the confirmation message for the user
            $subtotal = (float)$price * (float)$quantity;
            $taxAmount = calculateTax($subtotal, 0.161, $grandTotal);
            $taxAmount = number_format($taxAmount, 2);
            $totalMessage = "You bought instruments for $$subtotal the tax amount is $" . calculateTax($subtotal, 0.161, $grandTotal) . " and the grand total is $$grandTotal <br>Thank you for shopping with MusicLife. We hope to see you again soon!";
        }
        
        //verify that everything is good
        if($errorProductCode == "" && $errorFirstName == "" && $errorLastName == "" && $errorCity == "" && $errorComment == "" && $errorPrice == "" && $errorQuantity == "")
        {

            //clear all the fields
            $productCode = "";  
            $firstname = "";
            $lastname = "";
            $city = "";
            $comment = "";
            $price = "";
            $quantity = "";

            //open a file to write (use a constant)
            $fileHandle = fopen(TEXTFILE_FOLDER_PATH . "orders.txt", "a") or exit("cannot open the file");
            
            //write data into an array
            $order = array(htmlspecialchars(trim($_POST["productcode"])), htmlspecialchars(trim($_POST["firstname"])), htmlspecialchars(trim($_POST["lastname"])), htmlspecialchars(trim($_POST["city"])), htmlspecialchars(trim($_POST["comment"])), htmlspecialchars(trim($_POST["price"])), htmlspecialchars(trim($_POST["quantity"])),  $subtotal, $taxAmount, $grandTotal);

            //encode the array as a JSON string
            $JSONorder = json_encode($order);

            //write the array into the file
            file_put_contents(TEXTFILE_FOLDER_PATH . "orders.txt", $JSONorder . "\r\n", FILE_APPEND) or exit("Cannot open file");

            //save and close the file (and get rid of the file handle)
            fclose($fileHandle);
            
            //display the welcome message and the total cost message to the user after the order has been completed successfully
            echo "<div class='welcomebuying'>" . $welcomeMessage . "<br></div>"
                . "<div class='totalmessage'>" . $totalMessage . "</div>";
        }
    }
    



    ?>
    <!-- form creation -->
    <form action="buying.php" method="POST" class="form">
            <p>Please fill in all the info and submit the form</p>
            
            <!-- product code -->
            <p>
                <label class="required">Product code:</label><br>
                <input type="text" name="productcode" value="<?php echo $productCode ?>"/>
                <span class="red"><?php echo $errorProductCode; ?></span>
            </p>
            
            <!-- first name -->
            <p>
                <label class="required">Customer first name:</label><br>
                <input type="text" name="firstname" value = "<?php echo $firstname ?>"/>
                <span class="red"><?php echo $errorFirstName; ?></span>
            </p>
            
            <!-- last name -->
            <p>
                <label class="required">Customer last name:</label><br>
                <input type="text" name="lastname" value = "<?php echo $lastname ?>"/>
                <span class="red"><?php echo $errorLastName; ?></span>
            </p>
            
            <!-- city -->
            <p>
                <label class="required">City:</label><br>
                <input type="text" name="city" value="<?php echo $city ?>"/>
                <span class="red"><?php echo $errorCity; ?></span>
            </p>
            
            <!-- comment -->
            <p>
                <label>Comments:</label><br>
                <input type="text" name="comment" value="<?php echo $comment ?>"/>
                <span class="red"><?php echo $errorComment; ?></span>
            </p>
            
            <!-- price -->
            <p>
                <label class="required">Price:</label><br>
                <input type="text" name="price" value="<?php echo $price ?>"/>
                <span class="red"><?php echo $errorPrice; ?></span>
            </p>
            
            <!-- quantity -->
            <p>
                <label class="required">Quantity:</label><br>
                <input type="text" name="quantity" value="<?php echo $quantity ?>"/>
                <span class="red"><?php echo $errorQuantity; ?></span>
            </p>
            
            <!-- clear and submit buttons -->
            <p>
                <input type="reset" value="Clear the form" />
                <input type="submit" name="connect" value="Submit information"/>
            </p>

        </form>
<?php
    //display the page footer (copyright) and close the tags

    pageFooter();
