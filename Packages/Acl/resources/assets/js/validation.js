function loading_button(btn)
{
    btn.prop('disabled', true);
    btn.find(".loading-text").css('display', 'inline-block');
    btn.find(".spinner").css('display', 'inline-block');
    btn.find(".btn-text").css('display', 'none');
}


function stopLoadingButton(btn, type)
{
    btn.closest("body").find(".alert-container").find(".alert-"+type).removeClass("show");
    btn.closest("body").find(".alert-container").find(".alert-"+type).css("display", "none");
    btn.prop('disabled', false);
    btn.find(".loading-text").css('display', 'none');
    btn.find(".spinner").css('display', 'none');
    btn.find(".btn-text").css('display', 'inline-block');
    btn.closest("form").find(".form-control").removeClass("is-invalid");
    btn.closest("form").find(".form-select").removeClass("is-invalid");
    btn.closest("form").find(".form-check-input").removeClass("is-invalid");
    btn.closest("form").find(".image-file-uploader").removeClass("error");
}

function showSuccessMessage(btn, res)
{
    btn.closest("body").find(".alert-container").find(".alert-success").addClass("show");
    btn.closest("body").find(".alert-container").find(".alert-success").css("display", "inline-block");
    btn.closest("body").find(".alert-container").find(".alert-success").find(".text").text(res);
}

function showErrorMessage(btn, res)
{
    btn.closest("body").find(".alert-container").find(".alert-danger").addClass("show");
    btn.closest("body").find(".alert-container").find(".alert-danger").css("display", "inline-block");;
    btn.closest("body").find(".alert-container").find(".alert-danger").find(".text").text(res);
}

function showWarningMessage(btn, res)
{
    btn.closest("body").find(".alert-container").find(".alert-warning").addClass("show");
    btn.closest("body").find(".alert-container").find(".alert-warning").css("display", "inline-block");
    btn.closest("body").find(".alert-container").find(".alert-warning").find(".text").text(res);
}


function showDangerButton(btn, res)
{
    btn.closest("body").find(".alert-container").find(".alert-danger").addClass("show");
    btn.closest("body").find(".alert-container").find(".alert-danger").css("display", "inline-block");
    btn.closest("body").find(".alert-container").find(".alert-danger").find(".text").text('');
                $.each(res, function(key , value)
                {
                    btn.closest("form").find("."+key).addClass("is-invalid");
                    btn.closest("form").find("#"+key).addClass("is-invalid");
                    btn.closest("form").find("input[name="+key+"]").addClass("is-invalid");
                    btn.closest("form").find("input[name="+key+"]").closest(".image-file-uploader").addClass("error");
                    btn.closest("body").find(".alert-container").find(".alert-danger").find(".text").append(
                    "<li>"+ value +"</li>");
                });
}


var button = document.querySelectorAll(".close.alert-btn");

if(button)
{
    button.forEach((btn) =>{
            btn.addEventListener("click", function(){
             this.closest(".alert").style.display = "none";  
            })
    });
}

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'GA_MEASUREMENT_ID');