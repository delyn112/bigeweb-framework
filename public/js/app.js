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
function showPasswordBox(s){s.closest(".wrapper").querySelector(".password-content-wrapper").classList.toggle("show")}

function delete_data(e){$(document).on("click",e,(function(e){e.preventDefault();var t=$(this).data("url");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then((e=>{e.isConfirmed&&$.ajax({method:"get",url:t,success:function(e){e=JSON.parse(e),console.log(e),400===e.status||"400"===e.status||"401"===e.status?Swal.fire({title:"Error Notice",text:e.message,icon:"error"}):200!==e.status&&"200"!==e.status||(Swal.fire({title:"Success Confirmation",text:e.message,icon:"success"}),setTimeout((function(){window.location.href=window.location.href}),3e3))},error:function(e){if(400===e.status){let t=e.responseText;t=JSON.parse(t),401!==t.status&&"400"!==t.status||Swal.fire({title:"Error Notice",text:t.message,icon:"error"})}else Swal.fire({title:"Error Notice",text:e.statusText,icon:"error"})}})}))}))}function loading_button(e){e.prop("disabled",!0),e.find(".loading-text").css("display","inline-block"),e.find(".spinner").css("display","inline-block"),e.find(".btn-text").css("display","none")}function stopLoadingButton(e,t){e.closest("body").find(".alert-container").find(".alert-"+t).removeClass("show"),e.closest("body").find(".alert-container").find(".alert-"+t).css("display","none"),e.prop("disabled",!1),e.find(".loading-text").css("display","none"),e.find(".spinner").css("display","none"),e.find(".btn-text").css("display","inline-block"),e.closest("form").find(".form-control").removeClass("is-invalid"),e.closest("form").find(".form-select").removeClass("is-invalid"),e.closest("form").find(".form-check-input").removeClass("is-invalid"),e.closest("form").find(".image-file-uploader").removeClass("error")}function showSuccessMessage(e,t){e.closest("body").find(".alert-container").find(".alert-success").addClass("show"),e.closest("body").find(".alert-container").find(".alert-success").css("display","inline-block"),e.closest("body").find(".alert-container").find(".alert-success").find(".text").text(t)}function showErrorMessage(e,t){e.closest("body").find(".alert-container").find(".alert-danger").addClass("show"),e.closest("body").find(".alert-container").find(".alert-danger").css("display","inline-block"),e.closest("body").find(".alert-container").find(".alert-danger").find(".text").text(t)}function showWarningMessage(e,t){e.closest("body").find(".alert-container").find(".alert-warning").addClass("show"),e.closest("body").find(".alert-container").find(".alert-warning").css("display","inline-block"),e.closest("body").find(".alert-container").find(".alert-warning").find(".text").text(t)}function showDangerButton(e,t){e.closest("body").find(".alert-container").find(".alert-danger").addClass("show"),e.closest("body").find(".alert-container").find(".alert-danger").css("display","inline-block"),e.closest("body").find(".alert-container").find(".alert-danger").find(".text").text(""),$.each(t,(function(t,n){e.closest("form").find("."+t).addClass("is-invalid"),e.closest("form").find("#"+t).addClass("is-invalid"),e.closest("form").find("input[name="+t+"]").addClass("is-invalid"),e.closest("form").find("input[name="+t+"]").closest(".image-file-uploader").addClass("error"),e.closest("body").find(".alert-container").find(".alert-danger").find(".text").append("<li>"+n+"</li>")}))}delete_data("#delete-from-list"),$(document).on("click","#store-data-btn, #update-data-btn",(function(e){e.preventDefault();var t=$(this),n=t.data("url"),s=new FormData(t.closest("#data-form")[0]);loading_button(t),$.ajax({method:"post",data:s,url:n,processData:!1,contentType:!1,cache:!1,success:function(e){400===(e=JSON.parse(e)).status?(showDangerButton(t,e.errors),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3)):401===e.status||"400"===e.status?(showErrorMessage(t,e.message),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3)):200===e.status&&(showSuccessMessage(t,e.message),setTimeout((function(){window.location.href=e.redirectURL}),5e3))},error:function(e){if(400===e.status){let n=e.responseText;n=JSON.parse(n),400===n.status?(showDangerButton(t,n.errors),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3)):401!==n.status&&"400"!==n.status||(showErrorMessage(t,n.message),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3))}else showErrorMessage(t,e.statusText),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3)}})})),$(document).on("submit",".ckeditor-form",(function(e){e.preventDefault();var t=$(this).find("#store-ckdata-btn"),n=t.data("url"),s=new FormData($(this)[0]);loading_button(t),$.ajax({method:"post",data:s,url:n,processData:!1,contentType:!1,cache:!1,success:function(e){400===(e=JSON.parse(e)).status?(showDangerButton(t,e.errors),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3)):401===e.status?(showErrorMessage(t,e.message),setTimeout((function(){stopLoadingButton(t,"danger")}),5e3)):200===e.status&&(showSuccessMessage(t,e.message),setTimeout((function(){window.location.href=e.redirectURL}),5e3))}})}));var button=document.querySelectorAll(".close.alert-btn");function gtag(){dataLayer.push(arguments)}function imageUpload(e){const t=e,n=t[0],s=n.files,o=t.closest(".thumbnail-element"),i=o.find(".error-text").first(),a=new DataTransfer;for(let e=0;e<s.length;e++){const t=s[e],r=t.name;if(!t.type.startsWith("image/"))return i.addClass("image-error"),void setTimeout((()=>i.removeClass("image-error")),3e3);const l=o.find(".thumbnail-preview-content .element").first().clone()[0];l.hasAttribute("id")&&l.removeAttribute("id"),l.querySelector("span.text").textContent=r,l.querySelector("img.img-fluid").src=URL.createObjectURL(t),o.find(".thumbnail-preview-content").append(l);const d=o.find(".thumbnail-preview-content .element[id='removeable']");if(d.length&&d.remove(),!n.multiple){o.find(".thumbnail-preview-content .element:not(:last-child)").remove()}o.find(".thumbnail-preview-content").addClass("active"),a.items.add(t)}n.files=a.files}function videoUpload(e){const t=e,n=t[0],s=n.files,o=t.closest(".thumbnail-element"),i=o.find(".error-text").last(),a=new DataTransfer;for(let e=0;e<s.length;e++){const t=s[e],r=t.name;if(!t.type.startsWith("video/"))return i.addClass("image-error"),void setTimeout((()=>i.removeClass("image-error")),3e3);const l=o.find(".thumbnail-preview-content .element").first().clone()[0];l.hasAttribute("id")&&l.removeAttribute("id"),l.querySelector("span.text").textContent=r;const d=l.querySelector("video");if(d)d.src=URL.createObjectURL(t);else{const e=document.createElement("video");e.classList.add("img-fluid"),e.setAttribute("controls",""),e.src=URL.createObjectURL(t),l.appendChild(e)}l.querySelector("img.img-fluid")&&l.querySelector("img.img-fluid").remove(),o.find(".thumbnail-preview-content").append(l);const c=o.find(".thumbnail-preview-content .element[id='removeable']");if(c.length&&c.remove(),!n.multiple){o.find(".thumbnail-preview-content .element:not(:last-child)").remove()}o.find(".thumbnail-preview-content").addClass("active"),a.items.add(t)}n.files=a.files}button&&button.forEach((e=>{e.addEventListener("click",(function(){this.closest(".alert").style.display="none"}))})),window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","GA_MEASUREMENT_ID"),$(document).on("change",".photo-uploader, .video-uploader",(function(e){const t=$(this),n=t[0];n.classList.contains("photo-uploader")?imageUpload(t):n.classList.contains("video-uploader")&&videoUpload(t)})),$(document).on("click",".rm-button.remove-current-img",(function(e){let t=this,n=$(this).closest(".thumbnail-element").find("input[type='file']"),s=n[0].files,o=$(t).closest(".element").index(),i=new DataTransfer;for(let e=0;e<s.length;e++)e!==o&&i.items.add(s[e]);if(n[0].files=i.files,t.closest(".thumbnail-preview-content.active").querySelectorAll(".element").length>1)t.closest(".element").remove();else{t.closest(".element").remove();let e=document.createElement("div");e.classList.add("element"),e.setAttribute("id","removeable");let n=document.createElement("span");n.classList.add("rm-button","remove-current-img");let s=document.createElement("i");s.classList.add("fa-solid","fa-xmark"),n.appendChild(s),e.appendChild(n);let i=document.createElement("span");i.classList.add("text"),e.appendChild(i);let a=document.createElement("img");if(a.classList.add("img-fluid"),e.appendChild(a),document.querySelector(".thumbnail-preview-content.active").appendChild(e),document.querySelector(".thumbnail-preview-content").classList.remove("active"),document.querySelector(".thumbnail-preview-content.active")){let e=document.querySelector(".thumbnail-preview-content.active").querySelectorAll("input",".form-control");e.length>0&&(e[o].setAttribute("name",""),e[o].setAttribute("id",""))}}}));
