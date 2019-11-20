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

    var home__template = document.getElementById("home__template");
    if(home__template != null){
        $.ajax({
            type: 'GET',
            url: '/api/getJournal/',
            data: {},
            dataType: 'json'
        }).done(function (data) {
            if(data.status == '200'){
                $.each(data.data, function (index, item) {
                    var journal__item = document.createElement('div');
                    var journal__poster = document.createElement('div');
                    var journal__overlay = document.createElement('div');
                    var journal__action = document.createElement('div');
                    var journal__name = document.createElement('h3');

                    journal__item.setAttribute('class', 'journal__item');
                    journal__poster.setAttribute('class', 'journal__item--poster');
                    journal__poster.setAttribute('style', "background-image: url('" + item.poster_path + "')");
                    journal__overlay.setAttribute('class', 'journal__item--overlay');
                    journal__action.setAttribute('class', 'journal__item--action');
                    journal__name.setAttribute('style', "text-align: center");
                    journal__name.append(item.name);

                    var download = document.createElement('a');
                    download.setAttribute('href', '#');
                    download.setAttribute('download', item.name);
                    download.text = "Download";

                    var read = document.createElement('a');
                    read.setAttribute('href', "/show/" + item.id);
                    read.text = 'Read';

                    journal__action.append(
                        download,
                        read
                    );
                    journal__overlay.append(journal__action);
                    journal__poster.append(journal__overlay);
                    journal__item.append(journal__poster, journal__name);

                    home__template.append(journal__item);
                });
                console.log(data.data);
            }if(data.status == '401'){
                alert(data.msg);
            }
        });
    }

    var journal__template = document.getElementById("journal__template");
    if(journal__template != null){
            var url = new URL(window.location.href);
            var id = url.pathname.split('/')[2];

        $.ajax({
            type: 'GET',
            url: '/api/getJournal/' + id,
            data: {},
            dataType: 'json'
        }).done(function (data) {
            if(data.status == '200'){
                var pdf = document.createElement('iframe');
                pdf.setAttribute('width', '100%');
                pdf.setAttribute('height', '100%');
                pdf.setAttribute('src', data.data[0].journal_path);
                journal__template.append(pdf);
            }if(data.status == '401'){
                alert(data.msg);
            }
        });
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
});