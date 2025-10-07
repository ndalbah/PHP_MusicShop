# PHP - Music Shop Project
For this project, you have to invent a company name of your own and find a logo
for it. You also have to determine which kind of product this company will sell.
Then you have to create a small website to record all the orders made by customers.

All the files should use a common PHP functions .php file for common operations.

At the bottom of every page, there should be the following text:
```
Copyright <your name (your student number)> 2025
```
Instead of typing 2025 you have to use the current year of the server current date.

You must not use any style attribute directly in HTML tags. All the pages should
make use of at least one .css file and all the pages must have a background color.

The design of your pages must not look too minimalistic.

The website consists of 3 pages, which must display a different title in the tabs:
## Home Page
This is the welcome page.

Display the logo of the company and compose two or three sentences of your own to describe the company and the products it sells.

The logo should also be included in all the pages of your website.

This page, and all the others, should have the same navigation menu to browse in the 3 pages of your website.

On this page you should have a section for advertising. This section should display randomly only one picture of a product among a list of 5 products that you could sell on your website (software, products, food, etc).

All the pictures should have the same size on the screen.

Among these 5 ads, one of them (choose which one) is sold twice the price to our clients
and this advertising (and this one only) should be displayed 100% bigger,
and it should have a green border of 6 px. 

If any of these ads are clicked,
redirect the user to any website (no need to redirect to 5 different
websites).
## Buying page
This page contains a form with the following fields (your website should display an asterisk for required fields and display the red asterisk near required textboxes):
- Product code *
  - The product code cannot be empty, cannot be longer than 25 characters, and must always contain the letters PRD (uppercase, lowercase, or both).
  - For example: 45-Prd-MOUSE is a valid product code. 44b-Keyboard is not a valid product code.
- Customer first name *
  - The first name cannot be empty, and cannot be longer than 20 characters.
- Customer last name *
  - The last name cannot be empty, and cannot be longer than 20 characters.
- Customer City *
  - The city cannot be empty, and cannot be longer than 30 characters.
- Comments
  - The user may add optional comments to the transaction. Allowed string length goes from 0 to 200 characters.
- Price *
  - The price of the product must be entirely numeric. It must not be a negative value and cannot be higher that 10,000.00$.
  
- Quantity *
  - The quantity sold of the product must be a numeric value between 1 and 99.
  - No decimals are allowed, so a quantity of 1.3 is not valid.
 

The form should have submit button. 

If the data from some fields is not valid, you
have to write in red, near every corresponding field, a clear message telling the
user how to solve the problem (for example: the last name cannot contain more than
20 characters). You must also retain the typed value.

When all the data is valid, show a confirmation message to the user. 

You also have
to multiply the price by the quantity. This will give you the subtotal. You then have
to apply the local taxes of 16.1% to this subtotal to get the taxes amount. Finally,
add the subtotal and the taxes amount to get the grand total. 

The result of all these
calculations must always contain only 2 digits. For example, if you have
calculated 12.249765 for the grand total, keep only 12.25 in the variable.

Create an array with the data for all the following values:
- ProductCode
- FirstName
- LastName
- City
- Price
- Quantity
- Comments
- Subtotal
- Taxes amount
- Grand total

Convert this array to a json string and save it in a file to keep the orders. This file
must be located in a folder which should be located in your project along with the
PHP, CSS and other folders. 

> [!IMPORTANT]
> Don’t overwrite the existing data in the file!

After the file is saved properly, show a confirmation message to the user and
clear all the form to create another sale.

## Orders page
This page must contain a HTML table showing all the orders made on the website.
You must thus open orders file saved earlier (the code must not crash if the file does
not exist) and generate a HTML <table> with the appropriate column headers.

Then you have to read all the lines of the orders.txt file one by one, and for each
line generate a ```<tr>```, and generate a ```<td>``` for each field found in that line of the file.

All the borders must be visible, so the table may look like this:

| Product ID | First Name | Last Name | City     | Comments | Price  | Quantity | Subtotal | Taxes  | Grand Total |
|   :---:    |:---:       |  :---:    | :---:    |  :---:   | :---:  |   :---:  |  :---:   | :---:  |    :---:    |
| Phelmet4b  | Ben        | Masvidal  | Montréal |          | 49.99$ | 2        | 99.98$   | 16.10$ |   116.08$   |
| Pgloves675 | Justin     | Legault   |  Québec  |10% rebate| 22.49$ | 1        | 22.49$   | 3.62$  |    26.11$   |

> [!IMPORTANT]
> the dollar signs must not be saved in the text file, but should only be added in the HTML table for display.

In that page, the user may specify a action parameter in the url.

So for example if the user specifies:
- orders.php?action=print:
  - The background color of that page should be white.
  - Also, to save more ink/toner, the opacity of all the regular images (like the logo) should be of 0.3.
- If the user specifies orders.php?action=color:
  - You should change the color of the amounts in the subtotal column.
  - If the subtotal is less than 100.00$, it should be displayed in red.
  - If the amount is between 100.00$ and 999.99$, the amount should be displayed in light orange.
  - And finally if the amount is of 1000.00$ or more, the amount should be displayed in green.

Choose color tones that are easy to read.

This page should also have a link to download your PHP cheat sheet. Your file should be placed in the same folder used to
save the orders.txt file.
