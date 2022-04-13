require("./bootstrap");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

window.Echo.private("notifications")
    .listen("UserSessionChanged", (e) => {
        const notificationElement = document.getElementById("notification");
        const notificationContainerElement = document.getElementById("notification-container");
        const notificationMessageElement = document.getElementById("notification-message");

        notificationElement.classList.remove("invisible");

        notificationContainerElement.classList.remove(`bg-red-500`);
        notificationContainerElement.classList.remove(`bg-green-500`);

        notificationContainerElement.classList.add(`bg-${e.type}-500`);

        notificationMessageElement.innerText = e.message;
    });
