// Construct the form and add event listener for form submission
function AddNewArticle(){
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/articles'; // Endpoint for article submission
    form.enctype = 'multipart/form-data';

    const nameLabel = document.createElement("label");
    nameLabel.setAttribute('for', 'name');
    nameLabel.textContent = "Name";

    const name = document.createElement('input');
    name.type = 'text';
    name.name = 'name';
    name.id = 'name';
    name.required = true;

    const priceLabel = document.createElement('Label');
    priceLabel.for = 'price';
    priceLabel.textContent = "Price";
    const price = document.createElement('input');
    price.type = 'number';
    price.id = 'price';
    price.required = true;
    price.name = 'price';
    price.min = '0';

    const descriptionLabel = document.createElement("label");
    descriptionLabel.setAttribute('for', 'description');
    descriptionLabel.textContent = 'Description';
    const descriptionInput = document.createElement('textarea');
    descriptionInput.name = 'description';
    descriptionInput.id = 'description';

    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let csrf = document.createElement("input");
    csrf.setAttribute("type", "hidden");
    csrf.setAttribute("name", "_token");
    csrf.setAttribute("value", csrfToken);

    let br = document.createElement('br');

    const ImageLabel = document.createElement("label");
    ImageLabel.setAttribute('for', 'image');
    ImageLabel.textContent = 'Image';
    const Image = document.createElement('input');
    Image.type = 'file';
    Image.name = 'image';
    Image.id = 'image';



    const saveButton = document.createElement('button');
    saveButton.setAttribute("class", "btn btn-primary");
    saveButton.textContent = 'Save';
    saveButton.onclick = function () {
        submitFormViaAjax(form);
    }

    form.appendChild(nameLabel);
    form.appendChild(name);
    form.appendChild(priceLabel);
    form.appendChild(price);
    form.appendChild(descriptionLabel);
    form.appendChild(descriptionInput);
    form.appendChild(br);
    form.appendChild(ImageLabel);
    form.appendChild(Image);
    form.appendChild(br);
    form.appendChild(saveButton);
    form.appendChild(csrf)

    document.body.appendChild(form);
}

// Function to submit form via AJAX
function submitFormViaAjax(form) {
    event.preventDefault(); // Prevent default form submission behavior
    const formData = new FormData(form);

    // Check if required fields are empty
    const nameValue = formData.get('name');
    const priceValue = formData.get('price');
    const descriptionValue = formData.get('description');

    if (!nameValue || !priceValue || !descriptionValue) {
        window.alert('Bitte füllen Sie alle erforderlichen Felder aus.'); // Display error message
        return; // Exit the function without submitting the form
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            window.alert('Erfolgreich'); // Display success message
            window.location.href = '/articles';
        }else {
            window.alert('Fehler: ' + xhr.responseText); // Display error message
        }
    };
    xhr.onerror = function() {
        displayMessage('Fehler: Die Anfrage konnte nicht verarbeitet werden.');
    };
    xhr.send(formData);
}

// Function to display message under the form
function displayMessage(message) {
    const messageElement = document.createElement('p');
    messageElement.textContent = message;
    document.body.appendChild(messageElement);
}

window.addEventListener('load', function (){
   AddNewArticle();
});

//     form.addEventListener('submit', function(event) {
//         event.preventDefault(); // Prevent default form submission
//
//         // Validate the form data
//         if (nameInput.value.trim() === '' || parseInt(priceInput.value) <= 0) {
//             alert('Please enter valid article name and price');
//             return;
//         }
//
//         // Send the article data to the server
//         const formData = new FormData(form);
//         sendData(formData);
//     });
// });
//
// // Function to send article data to the server
// function sendData(formData) {
//     let xhr = new XMLHttpRequest();
//     xhr.open('POST', '/articles');
//     xhr.setRequestHeader('Content-Type', 'application/json');
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 console.log(xhr.responseText);
//             } else {
//                 console.error(xhr.statusText);
//             }
//         }
//     };
//     xhr.send(formData);
// }
