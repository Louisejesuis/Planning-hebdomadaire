/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// start the Stimulus application
import "./bootstrap";

// add class to birthday select form
var birthdayForm = document.getElementById("registration_form_birthday");
var birthdaySelect = birthdayForm.childNodes;

birthdaySelect.forEach((select) => {
    if (select.tagName === "SELECT") {
        select.classList.add("select", "is-normal", "px-6", "is-size-6");
    }
});
