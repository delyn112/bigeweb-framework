$(document).on('change', ".get-region", function (event){
    event.preventDefault();
    var self = $(this);
    var url = self.data("url");
    var type = self.attr("name");
    var country = self.closest(".card-body").find("select[name='country']").val();
    var state = self.closest(".card-body").find("select[name='state']").val();

    $.ajax({
        method : 'post',
        data : {'country' : country, 'type' : type, 'state' : state},
        url : url,
        success : function (response)
        {
            var response = JSON.parse(response);
            if(type === 'country')
            {
                var state_selector = self.closest(".card-body").find("select[name='state']");
                state_selector.empty();
                if(response.status === 200)
                {
                    state_selector.append($('<option>').val('').text('--- State --'));
                    $.each(response.data.states, function(index, value) {
                        var newOption = $('<option>').val(value).text(value);
                        state_selector.append(newOption);
                    });
                }else if(response.status === 400)
                {
                    state_selector.append($('<option>').val('').text('--- State --'));
                    var newOption = $('<option>').val(response.data).text(response.data);
                    state_selector.append(newOption);
                }
                state_selector.trigger("chosen:updated");
            }else if(type === 'state')
            {
                var zipcode_selector = self.closest(".card-body").find("select[name='postcode']");
                zipcode_selector.empty();
                if(response.status === 200)
                {
                    zipcode_selector.append($('<option>').val('').text('--- Zipcode --'));
                    $.each(response.data, function(index, value) {
                        var newOption = $('<option>').val(value).text(value);
                        zipcode_selector.append(newOption);
                    });
                }else if(response.status === 400)
                {
                    zipcode_selector.append($('<option>').val('').text('--- Zipcode --'));
                    var newOption = $('<option>').val(response.data).text(response.data);
                    zipcode_selector.append(newOption);
                }
                zipcode_selector.trigger("chosen:updated");
            }
        }
    });
})

