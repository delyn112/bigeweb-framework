function delete_data(btn)
{
    $(document).on("click", btn, function (e) {
        e.preventDefault();
        var self = $(this);
        var url = self.data("url");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "get",
                    url: url,
                    success: function (response) {
                        response = JSON.parse(response);
                        console.log(response);
                        if (response.status === 400 || response.status === "400" || response.status === "401") {
                            Swal.fire({
                                title: "Error Notice",
                                text: response.message,
                                icon: "error",
                            });
                        } else if (response.status === 200 || response.status === "200") {
                            Swal.fire({
                                title: "Success Confirmation",
                                text: response.message,
                                icon: "success"
                            });
                            setTimeout(function () {
                                window.location.href = window.location.href;
                            }, 3000);
                        }
                    },
                    error: function (err_response)
                    {
                        if(err_response.status === 400)
                        {
                            let errorResponse = err_response.responseText;
                            errorResponse = JSON.parse(errorResponse);
                             if(errorResponse.status === 401 || errorResponse.status === "400")
                            {
                                Swal.fire({
                                    title: "Error Notice",
                                    text: errorResponse.message,
                                    icon: "error",
                                });
                            }
                        }else{
                            Swal.fire({
                                title: "Error Notice",
                                text: err_response.statusText,
                                icon: "error",
                            });
                        }

                    }
                });
            }
        });
    });

}

delete_data("#delete-from-list");
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
$(document).on("change", ".photo-uploader, .video-uploader", function (event){
   const self = $(this);
   const fileInput = self[0];

   if(fileInput.classList.contains("photo-uploader"))
   {
       imageUpload(self);
   }else if(fileInput.classList.contains("video-uploader"))
   {
       videoUpload(self);
   }
});


function imageUpload(event) {
    const self = event;
    const fileInput = self[0];
    const images = fileInput.files;
    const uploadContainer = self.closest(".thumbnail-element");
    const errorText = uploadContainer.find(".error-text").first();

    // Create a new DataTransfer object outside the loop
    const newFileList = new DataTransfer();

    // Loop through the files using a for loop
    for (let i = 0; i < images.length; i++) {
        const currentImage = images[i];
        const imageName = currentImage.name;
        const imageType = currentImage.type;

        // Check if the image is valid
        if (!imageType.startsWith("image/")) {
            errorText.addClass("image-error");
            setTimeout(() => errorText.removeClass("image-error"), 3000);
            return; // Stop further processing if there's an error
        }

        // Continue with the upload process
        const imageElement = uploadContainer.find(".thumbnail-preview-content .element").first().clone();
        const newImageElement = imageElement[0];

        if (newImageElement.hasAttribute("id")) {
            newImageElement.removeAttribute("id");
        }

        // Insert the image name
        newImageElement.querySelector("span.text").textContent = imageName;
        newImageElement.querySelector("img.img-fluid").src = URL.createObjectURL(currentImage);

        // Append the new imageElement
        uploadContainer.find(".thumbnail-preview-content").append(newImageElement);

        // Remove the old element if it has the 'removeable' id
        const oldElement = uploadContainer.find(".thumbnail-preview-content .element[id='removeable']");
        if (oldElement.length) {
            oldElement.remove();
        }

        // Remove other images if it's a single image
        if (!fileInput.multiple) {
            const oldImages = uploadContainer.find(".thumbnail-preview-content .element:not(:last-child)");
            oldImages.remove();
        }

        uploadContainer.find(".thumbnail-preview-content").addClass("active");

        // Append the current image to the new FileList
        newFileList.items.add(currentImage);
    }

    // Finally, set the new FileList to the input
    fileInput.files = newFileList.files;
}



function videoUpload(event) {
    const self = event;
    const fileInput = self[0];
    const videos = fileInput.files;
    const uploadContainer = self.closest(".thumbnail-element");
    const errorText = uploadContainer.find(".error-text").last(); // Assuming the video error text is last

    // Create a new DataTransfer object outside the loop
    const newFileList = new DataTransfer();

    // Loop through the files using a for loop
    for (let i = 0; i < videos.length; i++) {
        const currentVideo = videos[i];
        const videoName = currentVideo.name;
        const videoType = currentVideo.type;

        // Check if the file is a video
        if (!videoType.startsWith("video/")) {
            errorText.addClass("image-error");
            setTimeout(() => errorText.removeClass("image-error"), 3000);
            return; // Stop further processing if there's an error
        }

        // Continue with the upload process
        const videoElement = uploadContainer.find(".thumbnail-preview-content .element").first().clone();
        const newVideoElement = videoElement[0];

        if (newVideoElement.hasAttribute("id")) {
            newVideoElement.removeAttribute("id");
        }

        // Insert the video name
        newVideoElement.querySelector("span.text").textContent = videoName;

        // Update the element to be a video instead of an image
        const videoTag = newVideoElement.querySelector("video");
        if (!videoTag) {
            // If there is no video tag, create one
            const newVideoTag = document.createElement("video");
            newVideoTag.classList.add("img-fluid");
            newVideoTag.setAttribute("controls", "");
            newVideoTag.src = URL.createObjectURL(currentVideo);
            newVideoElement.appendChild(newVideoTag);
        } else {
            videoTag.src = URL.createObjectURL(currentVideo);
        }

        //remove img-fluid
       if( newVideoElement.querySelector("img.img-fluid"))
       {
           newVideoElement.querySelector("img.img-fluid").remove();
       }

        // Append the new videoElement
        uploadContainer.find(".thumbnail-preview-content").append(newVideoElement);

        // Remove the old element if it has the 'removeable' id
        const oldElement = uploadContainer.find(".thumbnail-preview-content .element[id='removeable']");
        if (oldElement.length) {
            oldElement.remove();
        }

        // Remove other videos if it's a single upload
        if (!fileInput.multiple) {
            const oldVideos = uploadContainer.find(".thumbnail-preview-content .element:not(:last-child)");
            oldVideos.remove();
        }

        uploadContainer.find(".thumbnail-preview-content").addClass("active");

        // Append the current video to the new FileList
        newFileList.items.add(currentVideo);
    }

    // Finally, set the new FileList to the input
    fileInput.files = newFileList.files;
}


$(document).on("click", ".rm-button.remove-current-img", function (event) {
    let self = this;
    let fileInput = $(this).closest(".thumbnail-element").find("input[type='file']");
    let fileArray = fileInput[0].files;


    // Get the index of the clicked element
    let clickedIndex = $(self).closest(".element").index();

   let dataTransfer = new DataTransfer();

       for(let i=0; i < fileArray.length; i++)
       {
            if(i !== clickedIndex)
            {
                dataTransfer.items.add(fileArray[i]);
            }
       }

    fileInput[0].files = dataTransfer.files;
       //get the elements
       let Elements = self.closest(".thumbnail-preview-content.active").querySelectorAll(".element");

       if(Elements.length > 1)
       {
           self.closest(".element").remove();
           return;
       }else{
           self.closest(".element").remove();

           let newElement = document.createElement("div");
           newElement.classList.add("element");
           newElement.setAttribute("id", "removeable");

           let newSpan = document.createElement("span");
           newSpan.classList.add("rm-button", "remove-current-img");

           let newTag = document.createElement("i");
           newTag.classList.add("fa-solid", "fa-xmark");

           newSpan.appendChild(newTag);
            newElement.appendChild(newSpan);

           let newSpan2 = document.createElement("span");
           newSpan2.classList.add("text");

           newElement.appendChild(newSpan2);

           let img = document.createElement("img");
           img.classList.add("img-fluid");
           newElement.appendChild(img);

           self.closest(".thumbnail-preview-content.active").appendChild(newElement);

           //remove old input from database
           let oldElement = self.closest(".thumbnail-preview-content.active").querySelectorAll(".old_element");
           let oldElementInput = oldElement.querySelectorAll("input[type='text']");
           if(oldElementInput > 0)
           {
               oldElementInput[clickedIndex].setAttribute("name", "");
               oldElementInput[clickedIndex].setAttribute("id", "");
           }
       }
});
