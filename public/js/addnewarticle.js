// Construct the form and add event listener for form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/articles'; // Endpoint for article submission

    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.name = 'name';
    nameInput.placeholder = 'Article Name';

    const priceInput = document.createElement('input');
    priceInput.type = 'number';
    priceInput.name = 'price';
    priceInput.placeholder = 'Price';

    const descriptionInput = document.createElement('textarea');
    descriptionInput.name = 'description';
    descriptionInput.placeholder = 'Description';

    const saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.type = 'submit';

    form.appendChild(nameInput);
    form.appendChild(priceInput);
    form.appendChild(descriptionInput);
    form.appendChild(saveButton);

    document.body.appendChild(form);

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Validate the form data
        if (nameInput.value.trim() === '' || parseInt(priceInput.value) <= 0) {
            alert('Please enter valid article name and price');
            return;
        }

        // Send the article data to the server
        const formData = new FormData(form);
        sendData(formData);
    });
});

// Function to send article data to the server
function sendData(formData) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/articles');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.send(formData);
}
