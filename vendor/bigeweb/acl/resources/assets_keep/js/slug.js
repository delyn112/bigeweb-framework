$(document).on('keyup', '.title, .name', function(e)
{
    e.preventDefault();
    var text = $(this).val();
     text = text.toLowerCase();
    var slug = text.replace(/[^a-zA-Z0-9]+/g,'-');
    $(this).closest("form").find(".slug").val(slug);
});



// $(document).on("keyup", "#search-input", function (e){
//     e.preventDefault();
//     var searchText = $(this).val().toLowerCase();
//     $(this).closest("#page-list-container").find(".my-list-table tbody tr").each(function(){
//         var rowText = $(this).text().toLowerCase();
//         $(this).toggle(rowText.includes(searchText));
//     });
// });




$(document).on("change", "select[name='currency-selection']", function(el){
    el.preventDefault();
    var self = $(this);
    var data = $(this).val();
    var url = $(this).data("url");

    $.ajax({
        type: "post",
        data : {currency:data},
        url: url,
        success: function (response)
        {
             response = JSON.parse(response);
            if(response.status === 200)
            {
                self.closest(".card-body").find("#currency-symbol").val(response.data.symbol);
                self.closest(".card-body").find("#currency-code").val(response.data.code);
            }
        }
    });
})


var makeeditor = document.querySelectorAll( '.ckeditor-textarea' );
if(makeeditor)
{
    makeeditor.forEach(editor =>{
        ClassicEditor
            .create(editor )
            .catch( error => {
                console.error( error );
            } );
    })

}