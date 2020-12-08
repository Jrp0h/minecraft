//RAndom backgrounds
var body = document.querySelector('body');


function randomBackground() {

    body.style.backgroundImage = 'url(images/backgrounds/' + (Math.floor(Math.random() * 53) + 1) + '.png';
}

randomBackground();



// Remove notifications
function removeNotification() {
    let notification = document.querySelector("#notification");

    if (!notification)
        return;

    notification.remove();
}

let btnCloseNotification = document.querySelector("#notification-close");

if (btnCloseNotification) {
    btnCloseNotification.addEventListener("click", removeNotification);
}


function fuzzyFind(text, query) {
    text = text.toLowerCase().replaceAll(" ", "");
    query = query.toLowerCase().replaceAll(" ", "");

    if (query == "")
        return true;

    let index = 0;

    for (let c of text) {
        if (query[index] == c) {
            index++;

            if (index >= query.length)
                return true;
        }
    }

    if (index != query.length)
        return false;

    return true;
}

function createDropdownItem(data) {
    return `
            <div class="custom-dropdown-item-group" onclick="selectDropdown(${data.id}, '${data.name}')">
                <img src="${data.image_url}" alt="" class="custom-dropdown-item-img">
                <p class="custom-dropdown-item-title">${data.name}</p>
            </div>`;
}

function filterDropdown(filter) {
    let content = "";

    for (let item of currentItems) {
        if (fuzzyFind(item.name, filter))
            content += createDropdownItem(item);
    }

    dropdownItems.innerHTML = content;
}

function selectDropdown(id, name) {
    currentDropdown.innerHTML = `<option value="${id}" selected>${name}</option>`;
    closeDropdown();
}

function closeDropdown() {
    dropdownUI.classList.add("hide");
}

let dropdownUI = document.querySelector("#dd");
let dropdownSearch = document.querySelector("#dd-search");
let dropdownItems = document.querySelector("#dd-items");


if (dropdownSearch != undefined) {
    dropdownSearch.addEventListener("keyup", (e) => {
        filterDropdown(e.target.value);
    });
}

if (dropdownUI != undefined) {
    document.addEventListener("click", (e) => {
        if (!dropdownUI.contains(e.target) && e.target != currentDropdown) {
            closeDropdown();
        }
    });

    closeDropdown();
}

let currentItems = [];
let currentDropdown = [];

let customDropdowns = document.querySelectorAll("[data-custom-dropdown]");

for (let i = 0; i < customDropdowns.length; i++) {
    let data = JSON.parse(atob(customDropdowns[i].dataset.customDropdownData));

    customDropdowns[i].addEventListener("mousedown", (e) => {
        e.preventDefault();
        dropdownSearch.focus();

        let box = customDropdowns[i].getBoundingClientRect()

        dropdownUI.style.top = (box.y + window.scrollY + customDropdowns[i].clientHeight + 3) + "px";
        dropdownUI.style.left = box.x + "px";
        dropdownUI.style.width = customDropdowns[i].clientWidth + "px";

        if (currentDropdown == customDropdowns[i]) {
            dropdownUI.classList.toggle("hide");
            return;
        }

        currentDropdown = customDropdowns[i];

        dropdownSearch.value = "";
        dropdownSearch.focus();

        dropdownItems.innerHTML = "";

        currentItems = data;

        filterDropdown("");

        dropdownUI.classList.remove("hide");
    });
}