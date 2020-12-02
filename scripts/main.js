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
    // Selfdestruct?
    // let notificationSelfDestruct = setTimeout(removeNotification, 5000);

    btnCloseNotification.addEventListener("click", () => {
        // clearTimeout(notificationSelfDestruct);
        removeNotification();
    });
}

