<?php	// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class kunde extends Page
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
    protected function getViewData()
    {
        // to do: fetch data for this view from the database
        $bestellung = 'SELECT PizzaID, fBestellungID, fPizzaName, Status FROM bestelltepizza';
        $result = $this->_database->query($bestellung);
       
        return $result;
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
        $view = $this->getViewData();
        $this->generatePageHeader($headline = "Kunde");
        // to do: call generateView() for all members
        // to do: output view of this page
        $size_of_table = 0;
        while($temp = $view->fetch_assoc()){
            $data_field[] = $temp;
            $size_of_table++;
        }

        echo('<!DOCTYPE html>
            <html>
            <head>
            <title>Kunde</title>
            <link rel="stylesheet" type="text/css" href="pizzaStyle.css">
            </head>
            <body>
            <h1>Kunde</h1><table>
            ');

            $radio = "type=\"radio\"";
            $bestellt = "name=\"bestellt\"";
            $imOfen = "name=\"imOfen\"";
            $fertig = "name=\"fertig\"";
            $unterwegs = "name=\"unterwegs\"";

            session_start();
            $var = $this->_database->insert_id;

            if(!empty($_SESSION["ID"])){
                echo('
            <tr><td></td>
            <td>bestellt</td>
            <td>im Ofen</td>
            <td>fertig</td>
            <td>unterwegs</td>
            </tr><tr>');
                for($i = 0; $i < $size_of_table; $i++){
                $row = $data_field[$i];
                if($row["fBestellungID"] == $_SESSION["ID"]){
                    $pizza = $row["fPizzaName"];
                    $status = $row["Status"];
                    //var_dump($status);
                    $checked_b = null;
                    $checked_i = null;
                    $checked_f = null;
                    $checked_u = null;

                    switch($status){
                        case "bestellt":
                            $checked_b = "checked";
                            break;
                        case "imOfen":
                            $checked_i = "checked";
                            break;
                        case "fertig":
                            $checked_f = "checked";
                            break;
                        case "unterwegs":
                            $checked_u = "checked";
                            break;

                    }

            $bestellt = "name=\"bestellt_" .$i . "\"";
            $imOfen = "name=\"imOfen_" .$i . "\"";
            $fertig = "name=\"fertig_" .$i . "\"";
            $unterwegs = "name=\"unterwegs_" .$i . "\"";
            $disabled = "disabled";
            echo("<tr><td>" . $pizza . "</td>" );
            echo("<td><input $radio $bestellt $disabled $checked_b></td> 
                    <td><input $radio $imOfen $disabled $checked_i></td>
                    <td><input $radio $fertig $disabled $checked_f></td>
                    <td><input $radio $unterwegs $disabled $checked_u></td>
                </tr>");
                
            }
        }
            }

            if(empty($_SESSION["ID"])){
                echo("<tr><td>you have no orders!</td></tr>");
            }
            

        echo('    
            </table>
<div id="outter">
<div class="button"><a href="bestellung.php">Neue Bestellung</a></div>
</div>
</body>
</html>');

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
            $page = new kunde();
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
kunde::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >