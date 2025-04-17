var toggle_password = document.querySelectorAll(".password-visibility");

if(toggle_password)
{
    toggle_password.forEach((btn) =>{
        btn.addEventListener("click", function (){
            var input =  btn.closest(".wrap").querySelector("input");

            if(input.type === "password")
            {
                input.type = "text";
                btn.querySelector("i").classList.add("fa-eye")
            }else{
                input.type = "password";
                btn.querySelector("i").classList.remove("fa-eye")
                btn.querySelector("i").classList.add("fa-eye-slash")
            }
        });
    });
}

var filter_button = document.querySelector(".filter-list-btn");
if(filter_button)
{
    filter_button.addEventListener("click", function(){
        var body = document.querySelector(".filter-content-wrapper");
        body.classList.toggle("active");
    });
}