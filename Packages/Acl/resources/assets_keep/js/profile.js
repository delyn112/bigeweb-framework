$(document).on("click", "#change-password", function () {
    var self = $(this);

    if(self.is(':checked'))
    {
        self.closest(".wrapper").find(".password-content-wrapper").attr("hidden", false);
    }else{
        self.closest(".wrapper").find(".password-content-wrapper").attr("hidden", true);
    }
})


var password_auto_generate = document.querySelector("#auto-generate-password");
if(password_auto_generate)
{
    password_auto_generate.addEventListener("click", function (event){
        event.preventDefault();
        let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        const length = characters.length;
        result = '';
        var password_length = 15;
        for(let i = 0; i < password_length; i++){
            result += characters.charAt(Math.floor(Math.random() * length));
        }
       this.closest(".wrap").querySelector(".form-control").value = result;
    });
}