function swalSuccess(message) {
    swal.fire("", message, "success");
}
function swalError(message = "Error") {
    swal.fire("", message, "error");
}
$('#simple-table').DataTable({
    "aaSorting": [],
    "serverSide": false,
    "ordering": false,
    "stateSave": true,
    "pagingType": "full_numbers",
    "lengthMenu": [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]]
});
function deleteRecord(route, id = 0) {
    swal.fire({
        title: "Delete Record",
        text: "Are you sure you want to delete ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
    }).then(function (result) {
        if (result.value) {
            var routeString = "/" + route + "/" + id;
            $.ajax({
                url: routeString,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status) {
                        ajaxTable.ajax.reload();
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                    }

                }
            });

        }
    });
}
function swalSuccessWithRedirect(message, url = "/") {
    // window.location.href = url;
    swal.fire("", message, "success").then(function (result) {
        swal.close();
        window.location.href = url;
    });
    setTimeout(function () {
        swal.close();
        window.location.href = url;
    }, 1500);
}
function postDataWithRedirect(route, redirectUrl = "/", form = "form") {
    $.ajax({
        url: route,
        type: "POST",
        data: $("#" + form).serialize(),
        success: function (response) {
            console.log(response, "RESPONSE");
            if (response.success) {
                swalSuccessWithRedirect(response.message, "/" + redirectUrl);
            } else {
                swalError(response.message);
            }
        },
        error: function (response) {
            swalError();
        },
    });
}
$('.add-session-time').on('click', function () {
    var dayId = $(this).parent().parent().parent().data('day');
    $.ajax({
        url: "/get-session-time",
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            day_id: dayId,
        },
        success: function (response) {
            if (response.data) {
                var e = $('.weekly-content[data-day="'.concat(dayId, '"]'));
                $(e).find(".session-times").append(response.data);
            }
        }
    });
});





