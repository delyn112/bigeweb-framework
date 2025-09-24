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


function toggleMainDropdown()
{
    let dropDownbtn = document.querySelectorAll(".dropdown-btn");

    if(dropDownbtn.length > 0)
    {
        dropDownbtn.forEach((btn) => {
            btn.classList.remove("active");
            btn.addEventListener("click", function (event)
            {
                event.currentTarget.closest(".item.dropdown").querySelector(".dropdown-content")
                    .classList.toggle("active");
            })
        })
    }
}toggleMainDropdown();


document.addEventListener("click", function (event)
{
    let dropdownsElement = document.querySelectorAll(".dropdown-btn");
    if(dropdownsElement.length > 0) {
        let DropdownClicked = false;
        dropdownsElement.forEach((dropdown) => {
            if (dropdown.contains(event.target)) {
                DropdownClicked = true;
            }


            if(!DropdownClicked)
            {
                dropdownsElement.forEach((dropdown) =>{
                    if(dropdown.closest(".item.dropdown").querySelector(".dropdown-content").classList.contains("active"))
                    {
                        dropdown.closest(".item.dropdown").querySelector(".dropdown-content").classList.remove("active");
                    }
                });
            }
        });
    }
})