//document.getElementById("order_m").innerHTML = "Margherita";
//document.getElementById("price_m").innerHTML = "3 €";

//document.getElementById("order_s").innerHTML = "Salami";
//document.getElementById("price_s").innerHTML = "4,50 €";

//document.getElementById("order_h").innerHTML = "Hawaii";
//document.getElementById("price_h").innerHTML = "5,50 €";

var price = 0;

function raisePrice(p) {
    switch (p) {
        case "margherita":
            price = price + 4;
            break;
        case "salami":
            price = price + 4.5;
            break;
        case "hawaii":
            price = price + 5.5;
            break;
        case "thunfish":
            price = price + 6.5;
            break;
        case "speciale":
            price = price + 6;
            break;
        case "salmone":
            price = price + 7;
            break;
        case "ruccola":
            price = price + 7;
            break;
    }

    document.getElementById("action").innerHTML = price + " €";
}

document.getElementById("foodlist_0").addEventListener("click", function () {
    parseItem("Margherita");
    raisePrice("margherita");
});

document.getElementById("foodlist_1").addEventListener("click", function () {
    parseItem("Salami");
    raisePrice("salami");
});

document.getElementById("foodlist_2").addEventListener("click", function () {
    parseItem("Hawaii");
    raisePrice("hawaii");
});

document.getElementById("foodlist_3").addEventListener("click", function () {
    parseItem("Thunfish");
    raisePrice("thunfish");
});

document.getElementById("foodlist_4").addEventListener("click", function () {
    parseItem("Speciale");
    raisePrice("speciale");
});

document.getElementById("foodlist_5").addEventListener("click", function () {
    parseItem("Salmone");
    raisePrice("salmone");
});

document.getElementById("foodlist_6").addEventListener("click", function () {
    parseItem("Ruccola");
    raisePrice("ruccola");
});
document.getElementById("erase_all").addEventListener("click", function () {
    eraseAll();
    price = 0;
    document.getElementById("action").innerHTML = price + " €";
});

document.getElementById("erase_selected").addEventListener("click", function () {
    eraseSelected();
});

document.getElementById("submit_n").addEventListener("click", function () {
    selectAllElements();
});

function parseIcon() {
    var child = document.getElementById("foodImageTest");
    var icon = document.createElement("IMG");
    icon.setAttribute("src", "pizza.jpg");
    icon.setAttribute("width", "65");
    icon.setAttribute("height", "65");
    icon.setAttribute("alt", "Pizza Icon");
    child.appendChild(icon);
};

//document.getElementById("foodImageTest") = "parseIcon()";

function parseItem(item) {
    var field = document.getElementById("test");
    var option = document.createElement("option");

    switch (item) {
        case "Margherita":
            option.text = "margherita";
            field.add(option);
            break;
        case "Salami":
            option.text = "salami";
            field.add(option);
            break;
        case "Hawaii":
            option.text = "hawaii";
            field.add(option);
            break;
        case "Thunfish":
            option.text = "thunfish";
            field.add(option);
            break;
        case "Speciale":
            option.text = "speciale";
            field.add(option);
            break;
        case "Salmone":
            option.text = "salmone";
            field.add(option);
            break;
        case "Ruccola":
            option.text = "ruccola";
            field.add(option);
            break;
    }
};

function eraseAll() {
    var field = document.getElementById("test");

    while(field.length > 0){
    field.remove(0);}

};

function eraseSelected() {
    var select = document.getElementById("test");

     while(select.selectedIndex > 0){
        value = select.selectedIndex;

        var pizza = select.options[value].text;+
        select.removeChild(select[value]);
        switch (pizza) {
        case "margherita":
            price = price - 4;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "salami":
            price = price - 4.5;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "hawaii":
            price = price - 5.5;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "thunfish":
            price = price - 6.5;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "speciale":
            price = price - 6;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "salmone":
            price = price - 7;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "ruccola":
            price = price - 7;
            document.getElementById("action").innerHTML = price + " €";
            break;
    }
        }

};

function selectAllElements(){
    var field = document.getElementById("test");

    for(var int=0; int<field.options.length; int++){
        field.options[int].selected = true;
    }
};



