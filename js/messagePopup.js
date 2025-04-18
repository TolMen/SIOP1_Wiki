document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".show-popup");
    const popup = document.getElementById("popup");
    const popupMessage = document.getElementById("popup-message");
    const closeBtn = document.getElementById("closePopup");

    buttons.forEach((button) => {
        button.addEventListener("click", () => {
            const name = button.getAttribute("data-nom");
            const email = button.getAttribute("data-email");
            const objet = button.getAttribute("data-objet");
            const message = button.getAttribute("data-message");

            popupMessage.innerHTML = `
                <strong>De :</strong> ${name} (${email})<br>
                <strong>Objet :</strong> ${objet}<br><br>
                ${message.replace(/\n/g, "<br>")}
            `;
            popup.classList.add("show");
        });
    });

    closeBtn.addEventListener("click", () => {
        popup.classList.remove("show");
    });
});
