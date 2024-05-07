'use strict'
class Menu {
    constructor(menuStructure, containerId) {
        this.menuStructure = menuStructure;
        this.container = document.getElementById(containerId);
        this.menu = document.createElement('ul');
        this.buildMenu();
    }

    buildMenu() {
        this.menuStructure.forEach(item => {
            const menuItem = document.createElement('li');
            this.menu.appendChild(menuItem);
            const link = document.createElement('a');
            link.textContent = item.label;
            link.setAttribute('href', item.url || '#'); // Default to '#' if URL is not provided
            menuItem.appendChild(link);
            if (item.children) {
                const subMenu = document.createElement('ul');
                item.children.forEach(subItem => {
                    const subMenuItem = document.createElement('li');
                    subMenu.appendChild(subMenuItem);
                    const subLink = document.createElement('a');
                    subLink.textContent = subItem.label;
                    subLink.setAttribute('href', subItem.url || '#'); // Default to '#' if URL is not provided
                    subMenuItem.appendChild(subLink);
                });
                menuItem.appendChild(subMenu);
            }
        });
        this.container.appendChild(this.menu);
    }
}

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

// Create an instance of the Menu class
const menu = new Menu(menuStructure, 'menuContainer');

// // Create the navigation menu
// let menuContainer = document.getElementById('menuContainer');
// let menu = document.createElement('ul');
// menuStructure.forEach(item =>{
//     const menuItem = document.createElement('li');
//     menu.appendChild(menuItem);
//     const link = document.createElement('a');
//     link.textContent = item.label;
//     link.setAttribute('href', item.url);
//     menuItem.appendChild(link);
//     if(item.children){
//         const subMenu = document.createElement('ul');
//         item.children.forEach(subItem =>{
//             const subMenuItem = document.createElement('li');
//             subMenu.appendChild(subMenuItem);
//             const link = document.createElement('a');
//             link.textContent = subItem.label;
//             link.setAttribute('href', subItem.url);
//             subMenuItem.appendChild(link);
//
//         });
//         menuItem.appendChild(subMenu);
//     }
//
//
// });
//
// menuContainer.appendChild(menu);
