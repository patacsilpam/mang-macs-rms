$(document).ready(function () {
    $('#example').DataTable({
        stateSave: true,
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ]
    });
});