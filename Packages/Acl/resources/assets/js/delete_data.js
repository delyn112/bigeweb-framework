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