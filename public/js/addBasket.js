let items;


window.onload = function() {
    items = [];
    showItems(items);

}

function addProduct(article){
    //if item not in basket yet
    if(!items.find(item => item.id === article.id) ){
        items.push(article);
        console.log(items);
        showItems(items);
    }

}

function removeProduct(article){
    items = items.filter(item => item !== article);
    console.log(items);
}

let table = document.createElement('table');
table.style = 'width: 100%;';
document.getElementById("myBasket").appendChild(table);

function showItems() {
    // Clear the table
    table.innerHTML = '';

    // Create table headers
    let headers = ['Name', 'Price', 'Action'];
    let thead = document.createElement('thead');
    let headerRow = document.createElement('tr');

    headers.forEach(header => {
        let th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    let sum = 0;

    // Iterate over the items array
    for (let i = 0; i < items.length; i++) {
        // Create a new row and cells
        let row = document.createElement('tr');
        //row.style = 'border-bottom: dashed 1px grey; padding: 10px;';

        let cell = document.createElement('td');
        cell.style = 'background-color: lightgrey; font-color:black;';
        //cell.classList.add('text-black');

        let cell3 = document.createElement('td');
        cell3.style = 'background-color: lightgrey;';
        let pr = items[i].ab_price/100
        cell3.textContent = pr.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
        cell3.classList.add('text-black');
        sum += pr;

        let cell2 = document.createElement('td');
        let removeButton = document.createElement('button');
        removeButton.textContent = '-';

        cell2.onclick = function() {
            removeProduct(items[i]);
            showItems();
        }

        cell2.style = 'background-color: darkred;';
        cell2.classList.add('text-white');


        cell2.appendChild(removeButton);



        // Set the text of the cell to the item
        let item = items[i];
        cell.textContent = item.ab_name; // Assuming 'ab_name' is a property of the item

        // Add the cells to the row
        row.appendChild(cell);
        row.appendChild(cell3);
        row.appendChild(cell2);

        // Add the row to the table
        table.appendChild(row);

    }

    let footer = document.createElement('tfoot'); // Create a new row

    let foot1 = document.createElement('td');// Create a new cell
    foot1.textContent = 'Total';

    let foot2 = document.createElement('td');
    foot2.textContent = sum.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';

    let foot3 = document.createElement('td');
    foot3.style = 'background-color: darkred;';

    let RemoveAllButton = document.createElement('button');
    RemoveAllButton.textContent = 'Remove All';
    RemoveAllButton.onclick = function() {
        items = [];
        showItems();
    }

    foot3.appendChild(RemoveAllButton);

    footer.appendChild(foot1);
    footer.appendChild(foot2);
    footer.appendChild(foot3);

    table.appendChild(footer);


}
