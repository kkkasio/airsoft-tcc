<script>
    $('select').on('change', function() {
    $('#whole_page_loader').css('display','block');
        var squad = $('#squad').val($("option:selected", this).val());
        var profile = $('#profile').val($(this).attr('data-profile-id'));
        var event = $('#event').val($('#event-id').val());

        $('#form-squad').submit();
    });


    $('#sendForm').on('click', function(){
        $('#form-create-squad').submit();
    })

    $("[data-squad-id-delete]").click(function() {
        var id = $(this).attr('data-squad-id-delete');
        $('#squadId').val(id);
    });

    $("#squadDeleteButton").click(function(){
        $('#squadForm').submit();
    });


</script>
