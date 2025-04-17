var my_list_table = document.querySelectorAll(".my-list-table");
if(my_list_table)
{
    my_list_table.forEach((tbl) =>{
        new DataTable(tbl ,{
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
            pageLength: 50,
            "searching": true, // Enable searching
            "paging": true, // Enable pagination
            "info": true // Enable table information display
        });
});
}




$(document).on("keyup", "#search-input, #search-input-page", function (event){
   event.preventDefault();
    var value = $(this).val().toLowerCase();
    $(".dt-input").val(value).trigger("keyup");
});


var filter_button = document.querySelector(".filter-list-btn");
if(filter_button)
{
    filter_button.addEventListener("click", function(){
        var body = document.querySelector(".filter-content-wrapper");
        body.classList.toggle("active");
    });
}

