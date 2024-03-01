// Reduce the amount
document.querySelectorAll('.minus-btn').forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        var input = this.closest('.amount-div').querySelector('.amount');
        var id = this.closest('.amount-div').querySelector('form > .id').value
        const totalPrice = this.closest('.main-row').querySelector('.totalPrice')
        const price = this.closest('.amount-div').querySelector(".price").value
        var value = parseInt(input.value);
        //value mustn't be bellow 1
        if (value > 1) {
            value = value - 1;
            //update item's price
            const cartTotalPrice = document.getElementById("cartTotalPrice");
            let newPrice = parseFloat(totalPrice.innerText) - parseFloat(price);
            totalPrice.innerText = newPrice;
            //update cart's price
            let newPrice2 = parseFloat(cartTotalPrice.innerText) - parseFloat(price);
            cartTotalPrice.innerText = newPrice2;

            //create a json with data
            let json = new Object();
            json.id = id;
            json.qty = value;
            json.price = price;
            let vals = JSON.stringify(json)
            //send request to update the cart
            const request = new XMLHttpRequest();
            request.open("GET", "../controllers/cart.php?updateCart=" + vals + "&op=sub", true);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                }
            }
            request.send();
        } else {
            value = 1;
        }

        input.value = value;


    });
});

// Increase the amount
document.querySelectorAll('.plus-btn').forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        var input = this.closest('.amount-div').querySelector('.amount');
        var id = this.closest('.amount-div').querySelector('form > .id').value
        const totalPrice = this.closest('.main-row').querySelector('.totalPrice')
        const price = this.closest('.amount-div').querySelector(".price").value
        var value = parseInt(input.value);

        //value mustn't be above max value
        if (value < input.max) {
            value = value + 1;

            const cartTotalPrice = document.getElementById("cartTotalPrice");
            //update item's price
            let newPrice = parseFloat(totalPrice.innerText) + parseFloat(price);
            totalPrice.innerText = newPrice;
            //update cart's total price
            let newPrice2 = parseFloat(cartTotalPrice.innerText) + parseFloat(price);
            cartTotalPrice.innerText = newPrice2;

            //create a json with data
            let json = new Object();
            json.id = id;
            json.qty = value;
            json.price = price;
            let vals = JSON.stringify(json)
            //send request to update the cart
            const request = new XMLHttpRequest();
            request.open("GET", "../controllers/cart.php?updateCart=" + vals + "&op=add", true);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                }
            }
            request.send();
        } else {
            value = input.max;
        }

        input.value = value;


    });
});