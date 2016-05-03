<?php	// UTF-8 marker äöüÄÖÜß€
/**
 * Class PageTemplate for the exercises of the EWA lecture
 * Demonstrates use of PHP including class and OO.
 * Implements Zend coding standards.
 * Generate documentation with Doxygen or phpdoc
 * 
 * PHP Version 5
 *
 * @category File
 * @package  Pizzaservice
 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de> 
 * @author   Ralf Hahn, <ralf.hahn@h-da.de> 
 * @license  http://www.h-da.de  none 
 * @Release  1.2 
 * @link     http://www.fbi.h-da.de 
 */

// to do: change name 'PageTemplate' throughout this file
require_once './Page.php';

/**
 * This is a template for top level classes, which represent 
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class. 
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking 
 * during implementation.
 
 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de> 
 * @author   Ralf Hahn, <ralf.hahn@h-da.de> 
 */
class fahrer extends Page
{
    // to do: declare reference variables for members 
    // representing substructures/blocks
    
    /**
     * Instantiates members (to be defined above).   
     * Calls the constructor of the parent i.e. page class.
     * So the database connection is established.
     *
     * @return none
     */
    protected function __construct() 
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }
    
    /**
     * Cleans up what ever is needed.   
     * Calls the destructor of the parent i.e. page class.
     * So the database connection is closed.
     *
     * @return none
     */
    protected function __destruct() 
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is stored in an easily accessible way e.g. as associative array.
     *
     * @return none
     */
    protected function getViewData($bool = "")
    {
        // to do: fetch data for this view from the database
        if($bool == true){
            $bestellung = 'SELECT BestellungID, Adresse, Bestellzeitpunkt FROM bestellung';
            $result = $this->_database->query($bestellung);
            return $result;
        }
        
        if($bool == false){
            $bestellung = 'SELECT PizzaID, fBestellungID, fPizzaName, Status FROM bestelltepizza';
            $result = $this->_database->query($bestellung);
       
            return $result;
        }
        //$orders = 'SELECT PizzaID, fBestellungID, fPizzaName, Status FROM bestelltepizza';

        
    }
    
    /**
     * First the necessary data is fetched and then the HTML is 
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if avaialable- the content of 
     * all views contained is generated.
     * Finally the footer is added.
     *
     * @return none
     */
    protected function generateView() 
    {
        $bool_t = true;
        $view =$this->getViewData($bool_t);
        $this->generatePageHeader($headline = "Fahrer");

        $size_of_table = 0;
        while($temp = $view->fetch_assoc()){
            $data_field[] = $temp;
            $size_of_table++;
        }
        // to do: call generateView() for all members
        // to do: output view of this page
        echo('<!DOCTYPE html>
            <html>
            <head>
            <meta http-equiv="refresh" content="1" URL="localhost:7777/phpTest/fahrer.php" charset="UTF-8" />
            <title>Fahrer</title>
            <link rel="stylesheet" type="text/css" href="pizzaStyle.css">
            </head>
            <body>
            <h1>Fahrer</h1>');

    $radio = "type=\"radio\"";
    $gebacken = "name=\"gebacken\"";
    $unterwegs = "name=\"unterwegs\"";
    $ausgeliefert = "name=\"ausgeliefert\"";

    $bool_t = false;
    $view2 = $this->getViewData($bool_t);

    $size_of_table2 = 0;
        while($temp2 = $view2->fetch_assoc()){
            $data_field2[] = $temp2;
            $size_of_table2++;
        }

    for($i = 0; $i < $size_of_table; $i++){
            $row = $data_field[$i];
            echo("<h2>" . $row["Adresse"] . "</h2><p>");
            for($i2 = 0; $i2 < $size_of_table2; $i2++){
                $row2 = $data_field2[$i2];
                if($row["BestellungID"] == $row2["fBestellungID"]){
                    echo($row2["fPizzaName"] . ", ");
                }

            }

    $table = "class=\"table\"";

            echo('</p><table $table>
                    <tr>
                    <td>gebacken</td>
                    <td>unterwegs</td>
                    <td>ausgeliefert</td>
                    </tr>
                    <tr>
                    <td><form><input type="radio" name="gebacken"></form></td>
                    <td><form><input type="radio" name="unterwegs" checked></form></td>
                    <td><form><input type="radio" name="ausgeliefert"></form></td>
                    </tr>
                    </table>
                    </body>
                    </html>');
        }

 
        $this->generatePageFooter();
    }
    
    /**
     * Processes the data that comes via GET or POST i.e. CGI.
     * If this page is supposed to do something with submitted
     * data do it here. 
     * If the page contains blocks, delegate processing of the 
	 * respective subsets of data to them.
     *
     * @return none 
     */
    protected function processReceivedData() 
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
    }

    /**
     * This main-function has the only purpose to create an instance 
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
     *
     * @return none 
     */    
    public static function main() 
    {
        try {
            $page = new fahrer();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
// That is input is processed and output is created.
fahrer::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >