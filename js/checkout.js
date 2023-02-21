let selectedState = document.querySelector('.stateSelect');
let checkoutBtn = document.querySelector('#checkout-btn')

//Update estimated tax when state selector is changed.
selectedState.addEventListener('change', updateCartTotals);

//Updates all the prices in the Cart Total area of the checkout page
function updateCartTotals() {
    let subtotal = Number(sessionStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;

    let estimatedTax = 0;
    let stateIndex = selectedState.selectedIndex;
    if (stateIndex === 4) {
        estimatedTax = Number(Math.round(subtotal * 0.0775 + 'e2') + 'e-2');
    }
    document.querySelector('.estimatedTax').textContent = `$${estimatedTax.toFixed(2)}`;

    let shipping = Number(sessionStorage.getItem('shippingTotal'));

    document.querySelector('.shipping').textContent = `$${shipping.toFixed(2)}`;
    let total = subtotal + estimatedTax + shipping;
    document.querySelector('.total').textContent = `$${total.toFixed(2)}`;
}

//Creates a list of all items in the cart and saves them to local storage.
//When user checks out this list is sent with the form.
function createCartList() {
    let checkoutList = [];
    let cartProducts = JSON.parse(sessionStorage.getItem('cartProducts'));
    // console.log(cartProducts);
    for (obj in cartProducts) {
        // console.log(cartProducts[obj]);
        listItem = { 
        };
        listItem.id = cartProducts[obj].id;
        listItem.itemName = cartProducts[obj].itemName;
        listItem.itemNameString = cartProducts[obj].itemNameString;
        listItem.itemQty = cartProducts[obj].qtyInCart; 
        listItem.options = cartProducts[obj].options; 
        listItem.mainCategory = cartProducts[obj].mainCategory; 
        checkoutList.push(listItem);
    }
    sessionStorage.setItem('cartList', JSON.stringify(checkoutList));
    document.querySelector('#cart-list-input').value = JSON.stringify(checkoutList);

    //Disable Checkout button if cart is empty
    if (checkoutList.length === 0) {
        disableCheckoutButton()
    }
}

function disableCheckoutButton() {
    checkoutBtn.classList.add('disabled');
}

document.querySelector("#checkout-btn").addEventListener('submit', openSubmitOrderModal)

function openSubmitOrderModal(event) {
    document.getElementById('waitForRedirect').style.display='block';
}

updateCartTotals();
createCartList();