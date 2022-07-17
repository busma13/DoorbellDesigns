document.querySelector('#selectProduct').addEventListener('click', getProductInfo);

async function getProductInfo() {
    let productInput = document.querySelector("#selectProductName")
    let productName = productInput.value;
    let data;
    if (productName !== '') {
        editProduct = {
            'name': productName
        }
        try{
            const response = await fetch (
            './includes/get-edit-product-info.inc.php', 
                {
                    method:'POST',
                    mode: "same-origin",
                    cache: 'no-cache',
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept":       "application/json"
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify(editProduct)
                }
            )
            data = await response.json();
        
            const errorLine = document.querySelector('#select-product-error');
            const editForm = document.querySelector('#edit-product');
            const tableContainer = document.querySelector('#table-container');
            const tableRow = document.querySelector('.table-data');
            if (data === 'not-found') {
                errorLine.hidden = false;
                errorLine.textContent = 'Product not found.';
                editForm.hidden = true;
                tableContainer.hidden = true;
            } else if (data === 'retreive-fail') {
                errorLine.hidden = false;
                errorLine.textContent = 'Failed to retrieve item data. Please try again.'
                editForm.hidden = true;
                tableContainer.hidden = true;
            } else {
                productInput.value = '';
                originalProductName.value = productName;
                tableContainer.hidden = false;
                errorLine.hidden = true;
                errorLine.textContent = '';
                editForm.hidden = false;
                console.log(data);
                let td = document.createElement('td');
                td.textContent = data['itemNameString'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['mainCategory'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['subCategories'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['price'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['shipping'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['dimensions'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['imgUrl'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['active'] == 1 ? 'active' : 'inactive';
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['featured'] == 1 ? 'featured' : 'not featured';
                tableRow.appendChild(td);
            }
        } 
        catch(error) {
            console.error(`Could not get product: ${error}`);
        }
    }
}