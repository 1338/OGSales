/* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.element.addEventListener('click', () => {
            let x = document.getElementById("main-nav");
            if (x.style.display === "grid") {
                x.style.display = "none";
            } else {
                x.style.display = "grid";
            }
        })
    }
}