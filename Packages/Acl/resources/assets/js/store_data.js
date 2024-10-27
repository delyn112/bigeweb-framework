$(document).on("click", "#store-data-btn, #update-data-btn", function(e){
    e.preventDefault();
    var self = $(this);
    var url = self.data("url");
    var form  = new FormData(self.closest("#data-form")[0]);
    loading_button(self);
    $.ajax({
        method : "post",
        data : form,
        url : url,
        processData: false,
        contentType: false,
        cache : false,
        success: function (response)
        {
            response =  JSON.parse(response);
            if(response.status === 400)
            {
                showDangerButton(self, response.errors);
                setTimeout(function(){
                    stopLoadingButton(self, 'danger');
                }, 5000);
            }else if(response.status === 401 || response.status === "400")
            {
                showErrorMessage(self, response.message);
                setTimeout(function (){
                    stopLoadingButton(self, 'danger');
                }, 5000);
            }
            else if(response.status === 200)
            {
                showSuccessMessage(self, response.message);
                setTimeout(function(){
                    window.location.href = response.redirectURL;
                }, 5000);
            }
        },
        error: function (err_response)
        {
            if(err_response.status === 400)
            {
                let errorResponse = err_response.responseText;
                errorResponse = JSON.parse(errorResponse);
                if(errorResponse.status === 400)
                {
                    showDangerButton(self, errorResponse.errors);
                    setTimeout(function(){
                        stopLoadingButton(self, 'danger');
                    }, 5000);
                }else if(errorResponse.status === 401 || errorResponse.status === "400")
                {
                    showErrorMessage(self, errorResponse.message);
                    setTimeout(function (){
                        stopLoadingButton(self, 'danger');
                    }, 5000);
                }
            }else{
                showErrorMessage(self, err_response.statusText);
                setTimeout(function (){
                    stopLoadingButton(self, 'danger');
                }, 5000);
            }

        }
    })
});




$(document).on("submit", ".ckeditor-form", function(e){
    e.preventDefault();
    var self = $(this).find("#store-ckdata-btn");
    var url = self.data("url");
    var form  = new FormData($(this)[0]);
    loading_button(self);
    $.ajax({
        method : "post",
        data : form,
        url : url,
        processData: false,
        contentType: false,
        cache : false,
        success: function (response)
        {
            var response =  JSON.parse(response);
            if(response.status === 400)
            {
                showDangerButton(self, response.errors);
                setTimeout(function(){
                    stopLoadingButton(self, 'danger');
                }, 5000);
            }else if(response.status === 401)
            {
                showErrorMessage(self, response.message);
                setTimeout(function (){
                    stopLoadingButton(self, 'danger');
                }, 5000);
            }
            else if(response.status === 200)
            {
                showSuccessMessage(self, response.message);
                setTimeout(function(){
                    window.location.href = response.redirectURL;
                }, 5000);
            }
        }
    })
});
