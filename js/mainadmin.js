(function($) {
    $(document).ready(function () {
        document.title = config.title;
        $(".bindselect select").append($('<option>', {
            value: "none",
            text: "change bind"
        }));
        $.getJSON( "js/rooms.json.php", function( datarooms ) {
            $.each(datarooms.rooms, function(index,value){
               $(".bindselect select").append($('<option>', {
                   value: value.id,
                   text: value.name,
               }));
            });
        });

        $(".bindselect select").change(function() {
            sendAjax($(this).parent().data("id"),this.value)
        });

        function sendAjax($bind,$id) {
            $.ajax({
                url: 'inc/rest.php',
                type: "post",
                dataType:"json",
                data: { call: "bind",bind:$bind,id:$id,fid:0,group:0 },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(errorThrown);
                },
                success: function (data) {
                    if (data.status == "done") {
                        location.reload();
                    };
                }
            });
        }

        setTimeout(function(){
            window.location.reload(1);
        }, 30000);

    });
})(jQuery);