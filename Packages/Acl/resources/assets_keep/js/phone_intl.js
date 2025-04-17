// const input = document.querySelector("#phone");
// if(input)
// {
//     window.intlTelInput(input, {
//         initialCountry: system_country_of_use,
//         // separateDialCode: true,
//         // phone: "phone_full",
//         hiddenInput : "full_phone",
//         utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@22.0.2/build/js/utils.js",
//     });
// }

var input_tel = document.querySelectorAll("input[type='tel']");
input_tel.forEach((input)=>{
    intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
        initialCountry: system_country_of_use,
        geoIpLookup: function(callback) {
            fetch("https://ipapi.co/json")
                .then(function(res) { return res.json(); })
                .then(function(data) { callback(data.country_code); })
                .catch(function() { callback("us"); });
        },
        separateDialCode: true,
        hiddenInput: () => ({ phone: "dial_code", country: "country_code" }),
    });
});


$(document).on("keydown", "input[type='tel']",  function (event){
    var self = $(this);
    var code = self.closest(".iti").find(".iti__country-container .iti__selected-dial-code").text();
    $("input[name='dial_code']").val(code);
})

$(document).ready(function (event){
    var self = $("input[type='tel']");
   self.trigger("keydown");
})

$(document).on("countrychange", function (event){
    var self = $("input[type='tel']");
    var code = self.closest(".iti").find(".iti__country-container .iti__selected-dial-code").text();
    $("input[name='dial_code']").val(code);
})