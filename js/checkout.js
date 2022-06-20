//Updates all the prices in the Cart Total area of the checkout page
function updateCartTotals() {
    let subtotal = Number(localStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal}`;

    let shipping = Number(localStorage.getItem('shippingTotal'));

    document.querySelector('.shipping').textContent = `$${shipping}`;
    let total = subtotal + shipping;
    document.querySelector('.total').textContent = `$${total}`;
}

function createCartList() {
    let checkoutList = [];
    let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
    // console.log(cartProducts);
    for (obj in cartProducts) {
        // console.log(cartProducts[obj]);
        listItem = { 
        };
        listItem.itemName = cartProducts[obj].itemName;
        listItem.itemNameString = cartProducts[obj].itemNameString;
        listItem.itemQty = cartProducts[obj].qtyInCart; 
        checkoutList.push(listItem);
    }
    localStorage.setItem('cartList', JSON.stringify(checkoutList));
    document.querySelector('#cart-list-input').value = JSON.stringify(checkoutList);
    // console.log(checkoutList)
}

// function sendData () {
//         // Get products from the cart
//     let cartProducts = localStorage.getItem('cartProducts');
//         // Check if there are items in the cart
//         // console.log(cartProducts)
//     if (cartProducts) { 
//         //GET FORM DATA
//         var data = new FormData(document.getElementById("orderForm"));
//         data.append("state", document.querySelector('select').value);
//         data.append("cart-products", cartProducts);
//         data.append("submit", "submit");
    
//         // INIT FETCH POST
//         fetch("./includes/order.inc.php", {
//         method: "POST",
//         body: data
//         })

//         // RETURN SERVER RESPONSE AS TEXT
//         .then((result) => {
//             console.log(result)
//             if (result.status != 200) { throw new Error("Bad Server Response"); }
//             return result.json();
//         })
    
//         // SERVER RESPONSE
//         .then((response) => {
//             // console.log(response.text());
//             console.log(response);
//             // fetch(response, {mode: "no-cors"})
//             //     .then((res) => {
//             //         console.log(res);
//             //     })

//             //     .catch(err => {
//             //         console.log(err);
//             //     })
//             window.location.href = response;
//         })

//         .catch(err => {
//             console.log(err);
//         })
    
//         // // GET SERVER RESPONSE
//         // .then((result) => {
//         //     if (result.status != 200) { throw new Error("Bad Server Response"); }
//         //     return result;
//         // })
    
//         // // REDIRECT TO SQUARE CHECKOUT URL
//         // .then((response) => {
//         //     window.location.href = response.url;//TURN THIS INTO A FETCH?
//         // })
    
//         // HANDLE ERRORS
//         .catch((error) => { console.log(error); });
    
//         // PREVENT FORM SUBMIT
//         return false;
//     } 
//   }

updateCartTotals();
createCartList();