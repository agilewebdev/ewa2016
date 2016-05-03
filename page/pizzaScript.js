document.getElementById("order_m").innerHTML = "Margherita";
document.getElementById("price_m").innerHTML = "4 €";

document.getElementById("order_s").innerHTML = "Salami";
document.getElementById("price_s").innerHTML = "4,50 €";

document.getElementById("order_h").innerHTML = "Hawaii";
document.getElementById("price_h").innerHTML = "5,50 €";

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
    }

    document.getElementById("action").innerHTML = price + " €";
}

document.getElementById("foodlist_m").addEventListener("click", function () {
    parseItem("margherita");
    raisePrice("margherita");
});

document.getElementById("foodlist_s").addEventListener("click", function () {
    parseItem("salami");
    raisePrice("salami");
});

document.getElementById("foodlist_h").addEventListener("click", function () {
    parseItem("hawaii");
    raisePrice("hawaii");
});

document.getElementById("erase_all").addEventListener("click", function () {
    eraseAll();
    price = 0;
    document.getElementById("action").innerHTML = price + " €";
});

document.getElementById("erase_selected").addEventListener("click", function () {
    eraseSelected();
});

function parseIcon() {
    var child = document.getElementById("foodImageTest");
    var icon = document.createElement("IMG");
    icon.setAttribute("src", "http://st.depositphotos.com/1168906/1399/v/450/depositphotos_13990278-Pizza-icon.jpg");
    icon.setAttribute("width", "65");
    icon.setAttribute("height", "65");
    icon.setAttribute("alt", "Pizza Icon");
    child.appendChild(icon);
};

document.getElementById("foodImageTest") = "parseIcon()";

function parseItem(item) {
    var field = document.getElementById("test");
    var option = document.createElement("option");

    switch (item) {
        case "margherita":
            option.text = "Margherita";
            field.add(option);
            break;
        case "salami":
            option.text = "Salami";
            field.add(option);
            break;
        case "hawaii":
            option.text = "Hawaii";
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

        var pizza = select.options[value].text;
        select.removeChild(select[value]);
        switch (pizza) {
        case "Margherita":
            price = price - 4;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "Salami":
            price = price - 4.5;
            document.getElementById("action").innerHTML = price + " €";
            break;
        case "Hawaii":
            price = price - 5.5;
            document.getElementById("action").innerHTML = price + " €";
            break;
    }
        }

};

function testForm() {
      var text = document.getElementById
}