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
        self.closest(".thumbnail-preview-content").classList.remove("active");
        self.closest(".thumbnail-preview-content").querySelector(".element .img-fluid").setAttribute("src", "");
        self.closest(".thumbnail-preview-content").querySelector(".element .img-fluid").setAttribute("alt", "");
        self.closest(".thumbnail-preview-content").querySelector(".element span.text").innerHTML("");
        // self.closest(".element").remove();

        if(self.closest(".thumbnail-preview-content.active"))
        {
            let oldElement = self.closest(".thumbnail-preview-content.active").querySelectorAll("input", ".form-control");
            if(oldElement.length > 0)
            {
                //let oldElementInput = oldElement.querySelectorAll("input[type='text']");
                // if(oldElementInput > 0)
                // {
                oldElement[clickedIndex].setAttribute("name", "");
                oldElement[clickedIndex].setAttribute("id", "");
                // }
            }
        }
    }
});
