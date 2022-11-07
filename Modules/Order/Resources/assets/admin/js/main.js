$('#order-status').change((e) => {
    $.ajax({
        type: 'PUT',
        url: route('admin.orders.status.update', e.currentTarget.dataset.id),
        data: { status: e.currentTarget.value },
        success: (message) => {
            success(message);
        },
        error: (xhr) => {
            error(xhr.responseText);
        },
    });
});

$('#save').click((e) => {
    $.ajax({
        type: 'PUT',
        url: route('admin.orders.status.updateBasic', e.currentTarget.dataset.id),
        data: { no_resi: $('#no_resi').val() },
        success: (message) => {
            success(message);
        },
        error: (xhr) => {
            error(xhr.responseText);
        },
    });

});
