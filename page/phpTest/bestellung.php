<?php	

require_once './Page.php';

class bestellung extends Page
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
    
    protected function __destruct() 
    {
        parent::__destruct();
    }

    protected function getViewData()
    {
        $angebote = 'SELECT PizzaName, Bilddatei, Preis FROM angebot';
        $result = $this->_database->query($angebote);

        return $result;
    }
    
    protected function generateView() 
    {
        $view = $this->getViewData();
        $this->generatePageHeader($headline = "Bestellung");
        
        
        //if(isset($_GET["optional"])){     //GET tester *old*
           // $optional = ($_GET["optional"]);
           // $items = ($_GET["selBox"]);
            //$this->processReceivedData($_GET["optional"], $_GET["selBox"]);
       // }

        $size_of_table = 0;
        while($temp = $view->fetch_assoc()){
            $test[] = $temp;
            $size_of_table++;
        }

        $pizzaScript = "src=\"pizzaScript.js\"";
        echo('<!DOCTYPE html>
            <html>
            <head>
            <meta charset="UTF-8" />
            <title>Bestellung</title>
                <link rel="stylesheet" type="text/css" href="pizzaStyle.css">
            </head>');
        echo("
            <body>");

        $head = '<div class="header"><h1>Bestellung</h1></div>';
        echo($head);
        
         
        $leftEntry = "class=\"leftEntry\"";
        $foodlist = "id=\"foodlist\"";
        $foodImage = "class=\"foodImage\"";
        $clear = "class=\"clear\"";
        $div_end = "</div>\n";
        $icon_class = "class=\"icon\"";
        $foodlist_class = "class=\"foodlist\"";
        $price_class = "class=\"price\"";
        $order_class = "class=\"order\"";
        
        echo "<div $leftEntry>\n";

        for($i = 0; $i < $size_of_table; $i++){   //todo fix output > than 6 
            $x = $test[$i];
            $foodlist = "id=\"foodlist_" .$i . "\"";
            $order = "id=\"order_" .$i . "\"";
            $price = "id=\"price_" .$i . "\"";
            $icon = "id=\"icon_" .$i . "\"";
            echo "<div $foodlist $foodlist_class>\n";
                
                $src = $x["Bilddatei"];      
                echo "<div $foodImage>\n";
                    echo "<img $icon_class src=\"$src\" alt=\"icon\">\n";  // wie aus datenbank generieren?
                echo $div_end;
                echo "<div $order_class><p $order>";
                echo $x["PizzaName"];
                echo "</p></div>";

                echo "<div $price_class><p $price>";
                echo $x["Preis"];
                echo "</p></div>";
                //echo "<div $clear></div>";
                echo $div_end; 
        
        }
        echo $div_end;

        $rightEntry = "class=\"rightEntry\"";
        $foodList = "class=\"foodList\"";
        $selBox = "class=\"selBox\"";
        $test = "id=\"test\"";
        $size = "size=\"10\"";
        $action = "id=\"action\"";
        $button = "type=\"button\"";
        $comment = "id=\"comment\"";
        $text = "type=\"text\"";
        $optional = "name=\"optional\"";
        $erase_all = "id=\"erase_all\"";
        $erase_selected = "id=\"erase_selected\"";
        $submit = "type=\"submit\"";
        $form_t = "id=\"form_t\"";
        $v_erase_all = "value=\"erase_all\"";
        $v_erase_selected = "value=\"erase_selected\"";
        $bestellen = "value=\"bestellen\"";
        $get = "method=\"get\"";
        $post = "method=\"post\"";
        $submit_n = "id=\"submit_n\"";
        $select = "name=\"select[]\"";
        $senden = "value=\"senden\"";
        $onSubmit = "action=\"bestellung.php\"";
        $address = "name=\"address\"";
        $action_c = "class=\"action_c\"";
        echo("
                <div $rightEntry>
                <form $form_t $action_c $post $onSubmit>
                <div $foodList>
                <select $select $selBox $size $test multiple></select>
                </div>
                <p $action>0€</p>
                <input $comment $text $address required><br>
                <button $button $erase_all>Alle Loeschen</button><br>
                <button $button $erase_selected>Auswahl Loeschen</button>
                <input $submit $submit_n>
                </form>
                </div>
                <div $clear></div>
                <script $pizzaScript></script>
                </body>
                </html>
            ");


        if(isset($_POST["select"]) && isset($_POST["address"])){

            $this->processReceivedData($_POST["address"], $_POST["select"]);
        }

        $this->generatePageFooter();


    }
    
    protected function processReceivedData($optional = '', $items = '') 
    {

        $optional = mysql_real_escape_string($optional);
        $optional = htmlspecialchars_decode($optional);

        $stat = "bestellt";


        $qufery = "INSERT INTO bestellung(BestellungID, Adresse, Bestellzeitpunkt) VALUES ( DEFAULT, '$optional', DEFAULT)";

        //$stat = mysql_real_escape_string($stat);

        $count = count($items);

        try{
            $connex = $this->_database->query($qufery);
            $id = $this->_database->insert_id;

            for($int = 0; $int < $count; $int++){
                $entry = $items[$int];
                $query_o = "INSERT INTO bestelltepizza(PizzaID, fBestellungID, fPizzaName, Status) VALUES (DEFAULT, '$id', '$entry', '$stat')";
                $order = $this->_database->query($query_o);
            }
        } catch(Exception $eh){
            echo($eh);
        }

        if($connex === TRUE && $order === TRUE){
            echo "  order submittet!";
        } else {
            echo "  :( that didnt work out";
        }

        session_start();

        $sessPath = ini_get('session.save_path');
        $sessCookie = ini_get('session.cookie_path');
        $sessName = ini_get('session.name');
        $sessVar = $id;

        $_SESSION["ID"] = $sessVar;
        print_r("  session id:   " . $_SESSION["ID"]);

        
    }

    public static function main() 
    {
        try {
            $page = new bestellung();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

bestellung::main();
