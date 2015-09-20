
function processData(data) {
    var items = data.items;
    var dataSet = [];
    var getExtension = function(fileName) {
        return fileName.split('.').pop();
    };
    
    var getDate = function (UNIX_timestamp) {
        var date = new Date(UNIX_timestamp*1000);
        return date.toDateString();
    };
    
    var transform = function(el) {
        var nameLink = "<a href='#' class='file-download'>"+el.name+"</a>";

        var filesListElement = [];
        filesListElement.push(getExtension(el.name));
        filesListElement.push(nameLink);
        filesListElement.push(getDate(el.time));
        filesListElement.push(el.size);
        filesListElement.push("X");
        return filesListElement;
    };
    
    var displayInfo = function() {
        $(".current-dir").html(data.path);
    };
    
        
    var mydataSet = items.map(transform);
    console.log(mydataSet);
    displayInfo();
    populateTable(mydataSet);
    attachEvents();
}
 
function populateTable(files) {
    $('#table').dataTable( {
        "data": files,
        "columns": [
            { "title": "Type", "class": "filestable-extension" },
            { "title": "Name", "class": "filestable-filename" },
            { "title": "Date", "class": "filestable-filedate" },
            { "title": "Size", "class": "filestable-fileize"},
            { "title": "Delete", "class": "filestable-deletefile" }
        ]
    } );  
}
 
function attachEvents() {
    $('.file-download').on('click', function() {
        var fileName = $(this).text();
        $('#modal-action-type').text("download");
        $('#action-button').attr("data-action", "download").text("Download");
        $('#current-file').text(fileName);
        $('#action-file').val(fileName);
        $('#action-modal').modal();
    });

    
    $('#action-button').on('click', function() {
        var action = $(this).attr('data-action');
        var requestedFile = $('#current-file').text();
        if(action === "download")
            $('#action-form').submit();
    });
}

function downloadFile(fileName) {
    var password = $('#action-password').val();
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: '/download.php',
        data: {file: fileName, password: password },
        success: function(resp) {
            
        },
        error: function() {
            console.log("download went wrong");
        }
    });
    
}
 
$(document).ready(function() {
    $.ajax({
          type: 'GET',
          dataType: 'json',
          url: 'index.php',
          success: function(resp) {
            var data = resp;
            console.log(data);
            processData(data);
          },
          error: function() {
            console.log("something wrong");
          }
    });
    
});