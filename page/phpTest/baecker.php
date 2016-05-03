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
class baecker extends Page
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
        $angebote = 'SELECT PizzaID, fBestellungID, fPizzaName, Status FROM bestelltepizza';
        $result = $this->_database->query($angebote);
       
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
        $this->generatePageHeader($headline = "Baecker");

        $size_of_table = 0;

        while($temp = $view->fetch_assoc()){
            $data_field[] = $temp;
            $size_of_table++;
        }
        var_dump($size_of_table);
        // to do: call generateView() for all members
        // to do: output view of this page
        

        echo('<!DOCTYPE html>
                <html>
                <head>
                <meta http-equiv="refresh" content="1000" URL="localhost:7777/phpTest/baecker.php" charset="UTF-8" />
                <title>Baecker</title>
                <link rel="stylesheet" type="text/css" href="pizzaStyle.css">
                </head>
                <body onunload="submit_form()">
                <h1>B&auml;cker</h1>');

        $post = "method=\"post\"";

        //$onSubmit = "action=\"baecker.php\"";
        $on_submit = "onsubmit=\"submit_form(this)\""; //$post $form_t $on_submit
        $form_t = "id=\"form_b\"";
        echo('
                <form method="post" onsubmit="bestellung.php" id="form_b">
                <a href="javascript: submit_form()">test</a>
                <table>
                <tr>
                    <td></td>
                    <td>bestellt</td>
                    <td>im Ofen</td>
                    <td>fertig</td>
                </tr>');

        $radio = "type=\"radio\"";
        //$bestellt = "name=\"bestellt\"";
        
        //$imOfen = "name=\"imOfen\"";
        
        //$fertig = "name=\"fertig\"";


        
        for($i = 0; $i < $size_of_table; $i++){
            $row = $data_field[$i];
            $pizza = $row["fPizzaName"];
            $status = $row["Status"];
            $ID = $row["PizzaID"];
            $arr[] = $ID ;
            $checked_b = null;
            $checked_i = null;
            $checked_f = null;

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

            }


            if($status == "bestellt" || $status == "imOfen"){
                $id = 'id="' . $i . '"';
            $bestellt = "name=\"data[bestellt][".$i."]\"";
            $imOfen = "name=\"data[imOfen][".$i."]\"";
            $fertig = "name=\"data[fertig][".$i."]\"";
            $v_bestellt = "value=\"bestellt\""; //".$i."
            $v_imOfen = "value=\"imOfen\"";
            $v_fertig = "value=\"fertig\"";
            //$var = "bestellt_" .$i;
            //print_r($_POST["bestellt"]);
            
            
            echo("<tr><td>" . $pizza . "</td>" );
            echo("<td><input $radio $id $bestellt $v_bestellt $checked_b></td> 
                    <td><input $radio $id $imOfen $v_imOfen $checked_i></td>
                    <td><input $radio $id $fertig $v_fertig $checked_f></td>
                </tr>");

            echo("</tr");

            }

            
            }


            //print_r($arr);
        

    echo('
        </table>
        </form>
        <script>
   
function submit_form(form)
{
    document.forms["form_b"].submit();
  
};

window.onbeforeunload = function(event){

    document.forms["form_b"].submit();
};
        </script>
        </body>
        </html>');

        //print_r($_POST["fertig"]);
        $this->generatePageFooter();

        //print_r($_POST);
        //$this->processReceivedData($_POST, $arr);                  //TODO post daten bei refresh an die datenbank weitergeben!!
        if(isset($_POST["data"])){
            $varr = $_POST["data"]["imOfen"];
            print_r($varr);
            //$varr = $_POST["data"]["ID"];
            $this->processReceivedData($varr, $arr);

        }
        
        //for($in = 5; $in < 10; $in++){
            //print_r($varr["imOfen"]);
        //}


        if(isset($_POST["imOfen"])){
            echo("wuuuuul");
        }
        //print_r($_POST["imOfen"]);
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
    protected function processReceivedData($data = '', $id_array = '') 
    {
        //parent::processReceivedData();
        // to do: call processReceivedData() for all members
        //print_r($id_array);
        //print_r($data);
        //print_r($id_array);


        $count = count($data);
        print_r($data);
        for($int = 0; $int < $count; $int++){
            $test = $data;}

            print_r($test[3]);
            //print_r($id_array);
            //$pizzaid = array_search("imOfen", $data);
            //print_r($pizzaid);
        try{
            //while()
            
            for($int = 0; $int < 5; $int++){
            $test = $data;
            //$index = $

            //if(isset($test[$int]) && isset($id_array[$int])){ //if indexx ===$id_array_entry?
                echo("jhajhaaa");
                $mii = $int++;
                $query = "UPDATE bestelltepizza SET Status = imOfen WHERE PizzaID = '$mii'";
                $update = $this->_database->query($query);}
            //}
            

        }
        catch(Exception $e){
            echo($e);
        }
        
        //print_r($test);

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
            $page = new baecker();
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
baecker::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >