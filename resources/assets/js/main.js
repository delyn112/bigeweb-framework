function open_menu_header(event, btn)
{
    event.preventDefault();
    // Find the closest ancestor with the specified class
    let closestWrapper = btn.closest(".top-bar-content");

    if (closestWrapper) {
        // Find the first child element with the class 'menu-widget' within the ancestor
        let menuWidget = closestWrapper.querySelector(".menu-container");

        if (menuWidget) {
            // Toggle the visibility of the menu widget with a sliding animation
          menuWidget.classList.toggle("show");


            // Adjust the height for the slide effect
            if (menuWidget.style.maxHeight) {
                menuWidget.style.maxHeight = null;
            } else {
                menuWidget.style.maxHeight = menuWidget.scrollHeight + "px";
            }
        }
    }
}