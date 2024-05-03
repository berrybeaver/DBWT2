'use strict'

// Define the menu structure in JavaScript
const menuStructure = [
    { label: 'Home' },
    { label: 'Kategorien' },
    { label: 'Verkaufen'},
    {
        label: 'Unternehmen',
            children: [
                { label: 'Philosophie' },
                { label: 'Karriere' }
            ]
    }
];

// Create the navigation menu
let menuContainer = document.getElementById('menuContainer');
let menu = document.createElement('ul');
menuStructure.forEach(item =>{
    const menuItem = document.createElement('li');
    menu.appendChild(menuItem);
    const link = document.createElement('a');
    link.textContent = item.label;
    link.setAttribute('href', item.url);
    menuItem.appendChild(link);
    if(item.children){
        const subMenu = document.createElement('ul');
        item.children.forEach(subItem =>{
            const subMenuItem = document.createElement('li');
            subMenu.appendChild(subMenuItem);
            const link = document.createElement('a');
            link.textContent = subItem.label;
            link.setAttribute('href', subItem.url);
            subMenuItem.appendChild(link);

        });
        menuItem.appendChild(subMenu);
    }


});

menuContainer.appendChild(menu);
