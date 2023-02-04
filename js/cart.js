// This script file controls all shopping cart functionality

const goToCheckoutBtn = document.querySelector('.go-to-checkout')
const addToCartBtnSinglePage = document.querySelector('.add-to-cart-single');

// Stores an item in local storage with an expiration
var ls = {
    set: function (variable, value, ttl_ms) {
        var data = {value: value, expires_at: new Date().getTime() + ttl_ms / 1};
        localStorage.setItem(variable.toString(), JSON.stringify(data));
    },
    get: function (variable) {
        var data = JSON.parse(localStorage.getItem(variable.toString()));
        if (data !== null) {
            if (data.expires_at !== null && data.expires_at < new Date().getTime()) {
                localStorage.removeItem(variable.toString());
            } else {
                return data.value;
            }
        }
        return null;
    }
};

// load the product list from local storage or retrieve from database
let productList = ls.get('productList')
if (productList === null) {
    getProductList();   
}

// if (addToCartBtnSinglePage) {
//     addToCartBtnSinglePage.addEventListener('click', addToCartSingle)
// }
    
function addToCartSingle(event) {

    let qty = Number(document.querySelector('.input-text').value);
    const options = { optionsIDString: '', optionsPairStrings: []};
    console.log(options.optionsIDString)

    // TODO: change for variable options 
    const selectPickers = document.querySelectorAll('.selectpicker');
    if (selectPickers.length > 0) {
        for (const select of selectPickers) {
            console.log(select)
            const optionKey = select.dataset.id; 
            const newValue = Number(select.selectedOptions[0].dataset.id);
            options.optionsIDString += newValue;
            console.log(optionKey, newValue)
            options[optionKey] = newValue;
            const stringKey = select.childNodes[1].innerText;
            console.log(select.childNodes[1])
            const stringValue = select.selectedOptions[0].innerText;
            console.log(stringKey, stringValue)
            options.optionsPairStrings.push({ stringKey, stringValue })
        }
        console.log(options)
    }
    let productName = event.submitter.id;
    let product;
    if (ls.get('productList') === null) {
        getProductList();
    } 
    product = ls.get('productList').find(product => product.itemName === productName);
    product.options = options;
    cartItemCount(qty);
    setItems(qty, product)
    updateTotalCost(qty, product);
    return false;
}

// Get the product list
async function getProductList() {
    try{
        const response = await fetch ('./includes/get-product-list.inc.php', {
            dataType: "json",
            contentType: 'application/json',
            mimeType: 'application/json'
        });
        
        data = await response.json();
        ls.set('productList', data, 86400000)
        productList = ls.get('productList')
        console.log('product list set');
    } 
    catch(error) {
        console.error(`Could not get product list: ${error}`);
    }
}

//Clear the shopping cart on confirmation of a succesful checkout.
const confPage = document.querySelector('#confirmation');
if (confPage) {
    console.log(confPage)
    localStorage.removeItem('cartList')
    localStorage.removeItem('shippingTotal')
    localStorage.removeItem('cartTotal')
    localStorage.removeItem('cartItemCount')
    localStorage.removeItem('cartProducts')
}


// Update the localStorage cartItemCount
function cartItemCount(qty) {
    console.log(qty);
    let numOfItems = Number(localStorage.getItem('cartItemCount'));

    if (numOfItems) {
        localStorage.setItem('cartItemCount', numOfItems + qty);
        document.querySelector('.cartCount').textContent = numOfItems + qty;
    } else {
        localStorage.setItem('cartItemCount', qty);
        document.querySelector('.cartCount').textContent = qty;
    }
}

// Add product to local storage and update quantity
function setItems(qty, product) {
    let cartContents = JSON.parse(localStorage.getItem('cartProducts'));
    const optionsIDString = product.options.optionsIDString;
    const key = product.itemName+optionsIDString;
    if(cartContents) {//there are items in the cart
        if (!cartContents[key]) {//no product with this name & options in cart
            console.log(1)
            product.qtyInCart = qty;
            cartContents = {
                ...cartContents,
                [key]: product
            }
        } else {//product with this name & options is in the cart
            console.log(3)
            cartContents[key].qtyInCart += qty;
        }
    } else {//there are no items in the cart
        console.log(4)
        product.qtyInCart = qty;
        cartContents = {
            [key]: product
        }
    }
    
    localStorage.setItem('cartProducts', JSON.stringify(cartContents))
}

// When page loads/changes get the number of items in the shopping cart and display it in the nav bar.
function updateCartCount() {
    let numOfItems = Number(localStorage.getItem('cartItemCount'));
    if(numOfItems != undefined) {
        document.querySelector('.cartCount').textContent = numOfItems;
        if (goToCheckoutBtn) {
            if (numOfItems === 0) {
                goToCheckoutBtn.classList.add('disabled');
            } else {
                goToCheckoutBtn.classList.remove('disabled');
            }
        }
    }
}

// Update local storage with the total cost of all items in the cart.
function updateTotalCost(qty, product) {
    let cartTotal = Number(localStorage.getItem('cartTotal'));
    if (cartTotal) {
        localStorage.setItem('cartTotal', (cartTotal + product.price * qty).toFixed(2))
    } else {
        localStorage.setItem('cartTotal', (product.price * qty).toFixed(2));
    }
}

// Loads all of the products into the shopping cart table and updates the cart totals
function displayCart() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    if (productsInCart) console.log(Object.entries(productsInCart).length);
    let productTable = document.querySelector('.cart-table-body')
    if (productTable) {
        if (productsInCart && Object.entries(productsInCart).length > 0){
            productTable.innerHTML = '';
            Object.values(productsInCart).map(item => {
                const pairsArray = item.options.optionsPairStrings;
                console.log(pairsArray)
                let pairsArrayString = '';
                for (obj of pairsArray) {
                    console.log(obj)
                    pairsArrayString += `<span>${obj.stringKey} ${obj.stringValue}</span>`
                }
                productTable.innerHTML += `
                <tr class="cart-item" id="${item.itemName}${item.options.optionsIDString}">
                    <td class="image"><a href="single-product.php?category=${item.mainCategory}&product=${item.id}"><img src="${item.urlsArray[0]}" alt="${item.itemNameString}"></a></td>
                    <td><a href="single-product.php?category=${item.mainCategory}&product=${item.id}">${item.itemNameString}</a></td>
                    <td><div class="flex-container col">${pairsArrayString}</div></td>
                    <td>$${item.price}</td>
                    <td class="qty"><input type="number" step="1" min="1" name="cart" value="${item.qtyInCart}" title="Qty" class="input-text qty text qty-input-box" size="4"></td>
                    <td>$${(item.price * item.qtyInCart).toFixed(2)}</td>
                    <td class="remove"><a href="#x" class="btn btn-danger-filled x-remove">×</a></td>
                </tr>
                `; 
            });
            
            updateSingleProductTotals()
            removeProductFromCart()
            updateCartTotals()
        } else {
            productTable.innerHTML += '<tr><td>Your cart is empty</td></tr>'
        }
    }
}

// Updates a single products total price when quantity is changed in the shopping cart. Updates the localStorage cartItemCount and the products qtyInCart
function updateSingleProductTotals() {
    let qtyBoxes = document.querySelectorAll('.qty-input-box');
    qtyBoxes.forEach(qtyBox => {
        qtyBox.addEventListener('input', (e) => {
            let qty = e.currentTarget.value;
            if (qty != '') {
                let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
                let tdQty = e.currentTarget.parentNode;
                let tableRow = tdQty.parentNode;
                let product = cartProducts[tableRow.id];
                let qtyToAdd = qty - product.qtyInCart;

                // Update the total price in the DOM
                tdQty.nextElementSibling.textContent = `$${(tdQty.previousElementSibling.textContent.slice(1) * qty).toFixed(2)}`;
                
                // Update the localStorage cartItemCount value
                cartItemCount(qtyToAdd)
                setItems(qty, product)
                
                //Update the localStorage cartTotal value
                updateTotalCost(qtyToAdd, product)

                // update cart total in the nav bar
                updateCartCount()

                // update cart totals on the shupping cart page
                updateCartTotals()
            }
        });
    });
}

// Removes a product from the cart when you click the X button
function removeProductFromCart() {
    let removeBtns = document.querySelectorAll('.x-remove');
    removeBtns.forEach(removeBtn => {
        removeBtn.addEventListener('click', (e) => {
            let tableRow = e.currentTarget.parentNode.parentNode;
            let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
            let qty = tableRow.childNodes[9].firstElementChild.value;
            let product = cartProducts[tableRow.id];

            //update the localStorage cartTotal value
            updateTotalCost(-qty, product)

            // update the localStorage cartItemCount value
            cartItemCount(-qty)
            setItems(qty, product)

            // update the localStorage cartProducts value
            delete cartProducts[tableRow.id];
            localStorage.setItem('cartProducts', JSON.stringify(cartProducts));

            // remove the tableRow that holds all the product info
            tableRow.parentNode.removeChild(e.currentTarget.parentNode.parentNode);
            
            // update cart total in the nav bar
            updateCartCount();

            updateCartTotals()
            
        })
    });
}

//Calculate shipping total
function calculateShippingTotal() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    // console.log('productsInCart', productsInCart.bambooDoorbell);
    let shippingTotal = 0;
    let shippingQuantities = {'doorbells5': 0, 'doorbells3.5': 0, 'fanPulls': 0, 'airPlantCradles': 0};
    for (let product in productsInCart) {
        // console.log(product);
        // console.log(`${productsInCart[product].shipping}`);
        let itemCategory = productsInCart[product].mainCategory;
        let itemShipping = productsInCart[product].shipping;
        let itemQty = productsInCart[product].qtyInCart;

        if (itemCategory === 'Air-Plant-Cradles') {
            shippingQuantities['airPlantCradles'] += itemQty;
        }
        if (itemCategory === 'Doorbells') {
            if (itemShipping === '3.50') {
                shippingQuantities['doorbells3.5'] += itemQty;
            } else if (itemShipping === '5.00') {
                shippingQuantities['doorbells5'] += itemQty;
            }
        }
        if (itemCategory === 'Fan-Pulls') {
            shippingQuantities['fanPulls'] += itemQty;
        }

    }
    console.table(shippingQuantities)

    //update for fan pulls, artwork, etc
    for (let category in shippingQuantities) {
        console.log('category: ',category);
        if (category == 'doorbells3.5') {
            if(shippingQuantities[category] % 2 === 0) {
                console.log('even')
                console.log(3.5 * shippingQuantities[category] / 2)
                shippingTotal += 3.5 * shippingQuantities[category] / 2;
                console.log(shippingTotal)
            } else {
                console.log('odd')
                shippingTotal += 3.5 * (shippingQuantities[category] + 1) / 2;
                console.log(shippingTotal)
            }
        } else if (category === 'doorbells5') {
            // console.log(`${qtyAtEachShippingPrice[price]}`)
            shippingTotal += 5 * shippingQuantities[category];
            console.log(shippingTotal)
        } else if (category === 'airPlantCradles') {
            shippingTotal += 5 * shippingQuantities[category];
        } else if (category === 'fanPulls') {
            if (shippingQuantities[category] > 0) shippingTotal += 5;
            console.log(shippingTotal)
        }
    }
    localStorage.setItem('shippingTotal', shippingTotal);

    return shippingTotal;
}

//Updates all the prices in the Cart Total area of the shopping cart
function updateCartTotals() {
    let subtotal = Number(localStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;

    let shipping = calculateShippingTotal();

    document.querySelector('.shipping').textContent = `$${shipping.toFixed(2)}`;
    let total = subtotal + shipping;
    document.querySelector('.total').textContent = `$${total.toFixed(2)}`;
}

updateCartCount();
displayCart();