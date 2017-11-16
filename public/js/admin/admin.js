$(document).ready(function() {
    $('#addNew').click(function() {
        var autoDiv = $("#basicToggle");
        if (autoDiv.is(":visible")) {
            autoDiv.height(200).animate({
                height: 0
            }, 1000);
            setTimeout(function() {
                autoDiv.hide();
            }, 1000);
        } else {
            autoDiv.css('height', 'auto');
            var AutoHeight = autoDiv.height();
            autoDiv.height(0).animate({
                height: AutoHeight
            }, 1000);
            autoDiv.show();
        }
    });
    $('a#errorDetails').click(function(e) {
        e.preventDefault();

        var detailsDiv = $(this).closest('div').find('#ErrorMsgDetails');
        if (detailsDiv.is(':visible'))
        {
            detailsDiv.fadeOut();
        } else {
            detailsDiv.fadeIn();
        }
    });
    $('a.deleteItem').click(function(event) {
        event.preventDefault();
        var name = $(this).attr("title");
        var form = $(this).closest('form');
        if (!confirm('You want to delete ' + name + " !!")) {
            return false;
        }
        form.submit();
    });
    $('select#detailsNavigatore').change(function() {
        var form = $(this).closest('form');
        form.submit();
    });
    $('#addRow').click(function() {
        var textGroup = $(this).closest(".box-body").find("#text-group");
        var text = createRow();
        textGroup.append(text);
        $("a#deleteRow").click(function() {
            var row = $(this).closest('.row');
            row.empty();
        });
    });
    $('select#galleryNav').change(function() {
        var url = $(this).val();
        window.location.replace(url);
    });
    $('#selectNav').change(function() {
        var value = $(this).val();
        if (value == 'all')
        {
            $('.checkbox').prop('checked', true);
        } else
        {
            $('.checkbox').removeAttr('checked');
        }

    });
});

function createRow() {
    var row = document.createElement('div');
    row.setAttribute('class', 'row');
    row.innerHTML = '<div class="col-md-11"> <div class="form-group"><input class="form-control" name="text[]" value="" placeholder="Text" required></div></div>';
    var trashDiv = document.createElement('div');
    trashDiv.setAttribute('class', 'col-md-1');
    var formGroup = document.createElement('div');
    formGroup.setAttribute('class', 'form-group');
    var deleteRowIcon = document.createElement('a');
    deleteRowIcon.setAttribute('id', 'deleteRow');
    deleteRowIcon.setAttribute('class', 'btn btn-default');
    deleteRowIcon.innerHTML = '<i class="fa fa-fw fa-trash-o"></i>';
    formGroup.appendChild(deleteRowIcon);
    trashDiv.appendChild(formGroup);
    row.appendChild(trashDiv);
    return row;
}