
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
        var downloadLink = "<a href='#' class='file-download'>"+el.name+"</a>";
        var deleteLink = "<a href='#' class='file-delete'>"+"X"+"</a>";
        
        var filesListElement = [];
        filesListElement.push(getExtension(el.name));
        filesListElement.push(downloadLink);
        filesListElement.push(getDate(el.time));
        filesListElement.push(el.size);
        filesListElement.push(deleteLink);
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
    var table = $('#table')[0];
    if ( $.fn.dataTable.isDataTable( table ) ) {
        $(table).DataTable().destroy();
        $(table).html();
    }
    $('#table').dataTable( {
        "data": files,
        "columns": [
            { "title": "Type", "class": "filestable-extension" },
            { "title": "Name", "class": "filestable-filename" },
            { "title": "Date", "class": "filestable-filedate" },
            { "title": "Size (B)", "class": "filestable-fileize"},
            { "title": "Delete", "class": "filestable-deletefile" }
        ]
    } );  
}
 
function attachEvents() {
    $('.file-download').on('click', function prepareDownloadModal() {
        var fileName = $(this).text();
        $('#modal-action-type').text("download");
        $('#current-file').text(fileName);
        $('#action-button').attr("data-action", "download").text("Download");
        
        $('#action-form').attr('action', 'download.php');
        $('#action-file').val(fileName);
        $('#action-type').val("download");
        
        $('#action-modal').modal('show');
    });
    
    $('.file-delete').on("click", function prepareDeleteModal() {
        var fileName = $(this).parents("tr").find(".file-download").text()
        $('#modal-action-type').text("delete");
        $('#current-file').text(fileName);
        $('#action-button').attr("data-action", "delete").text("Delete");
        
        $('#action-form').attr('action', 'delete.php');
        $('#action-file').val(fileName);
        $('#action-type').val("delete");
        
        $('#action-modal').modal('show');
    });
    
    $('#action-button').on('click', function() {
        submitRequest();
        $('action-password').val("");
        $('#action-modal').modal('hide');
    });
}

function submitRequest() {
    var $form = $('#action-form');
    var action = $('#action-type').val()
    
    if (action === 'download') {
        $form.submit();
    }
    else {
        var url = $form.attr("action");
        var data = $form.serialize();
        
        $.post(url, data, function (resp) {
            fetchListOfFiles();
        })
    }
}
 
 function fetchListOfFiles() {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'start.php',
        success: function(data) {
            console.log(data);
            processData(data);
        },
            error: function() {
            console.log("something wrong");
        }
    });
 }
 
 var ListOfFiles = [];
 
$(document).ready(function() {
    fetchListOfFiles();
    
});