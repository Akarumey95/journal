$(document).ready(function () {

    // Get the modal
    var modal = document.getElementById("createModal");

// Get the button that opens the modal
    var btn = document.getElementById("createModalBtn");

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    if(modal != null){

// When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

// When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

// When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }


    $(".trigger__deleteJournal").on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'POST',
            url: '/admin/journal/delete',
            data: {id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        }).done(function (data) {
            if(data.status == '200'){
                //alert(data.msg);
                window.location.reload();
            }if(data.status == '401'){
                alert(data.msg);
            }
        });
    });


    $(".trigger__saveJournal").on('submit', function (e) {
        e.preventDefault();

        //var form = ;

        var FD = new FormData($(this)[0]);

        $.ajax({
            type: 'POST',
            url: '/admin/journal/save',
            data: FD,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function (data) {
            if(data.status == '200'){
                //alert(data.msg);
                window.location.reload();
                modal.style.display = "none";
            }if(data.status == '401'){
                alert(data.msg);
            }
        });
    });

    $(".trigger__download").on('click', function (e) {
        e.preventDefault();

        var url = $(this).attr('data-path');
        var name =$(this).attr('data-name');

        $.ajax({
            url: url,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = name;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            }
        });
    });
});