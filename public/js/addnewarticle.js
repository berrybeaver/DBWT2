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
        form.submit();
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
