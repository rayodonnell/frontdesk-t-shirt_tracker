(function($){
    $(document).ready(function(){
        Handlebars.registerHelper("math", function(lvalue, operator, rvalue, options) {
            lvalue = parseFloat(lvalue);
            rvalue = parseFloat(rvalue);
            return {
                "+": lvalue + rvalue,
                "-": lvalue - rvalue,
                "*": lvalue * rvalue,
                "/": lvalue / rvalue,
                "%": lvalue % rvalue
            }[operator];
        });
        Handlebars.registerHelper("checkDisabled", function(lvalue, operator, rvalue, options) {
            lvalue = parseFloat(lvalue);
            rvalue = parseFloat(rvalue);
            if (operator == "-") {
                if ((lvalue - rvalue) < 1) {
                    return "disabled"
                }
            }
            else {
                return "";
            }
        });

        init();

        function init() {
            $('#remove input:checkbox').change(
                function(){
                    if ($(this).is(':checked')) {
                        $('#remove .removelabel').addClass("active");
                        $("body").addClass("rem");
                        $('#remove .removelabel').empty().text("disable remove");
                    }
                    else {
                        $('#remove .removelabel').removeClass("active");
                        $("body").removeClass("rem");
                        $('#remove .removelabel').empty().text("enable remove");
                    }
                }
            );
            callsBeforeTemplate();
            //renderTemplate();
        }
        function callsBeforeTemplate() {
            document.title = config.title;
            $("#fosdemPosTitle").empty().append(config.title);
            $.getJSON( "js/rooms.json.php", function( datarooms ) {
                $.get('/js/template/partials/rooms.tpl.php', function () {
                }, 'html').done(function(e){
                    var template=Handlebars.compile(e);
                    $("#roomselect").append(template(datarooms));
                    renderTemplate();
                });
            });
        }
        function renderTemplate() {
            $.getJSON( "js/events.json.php", function( data ) {
                var len = data.category.length;
                $.each( data.category, function( key, val ) {
                    $.get('/js/template/partials/category.tpl.php', function () {
                    }, 'html').done(function(e){
                        var template=Handlebars.compile(e);
                        $("#hidden").append(template(val));
                        if (key == len - 1) {
                            $("#pos").html($("#hidden").html());
                            $("#hidden").empty();
                            callsAfterTemplate();
                        }
                    });
                });
            });
        }
        function callsAfterTemplate() {
            if (config.debug) {
                $(".count").css("visibility","visible");
                $(".totalCount").css("visibility","visible");
            }
            $('.circle').unbind().click(function() {
                $call = "add"; //change this to also add "min"
                if ($('#remove input:checkbox').is(":checked")) {
                    $call = "min";
                }
                var currentdate = new Date();
                var datetime = currentdate.getHours() + ":"
                    + currentdate.getMinutes() + ":"
                    + currentdate.getSeconds();
                $fid = $(this).data("fid");
                $group = $(this).data("group");
                $title = $(this).data("title");
                $room = $("#roomselect option:selected").val();
                $print = $(this).data("print");
                $print2 = $(this).data("print2");
                if ($call == "add") {
                    if (!$(this).hasClass('disabled')) {
                        $('.alerts').prepend('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>You added the item: '+$(this).text()+' - '+datetime+'</div>');
                        sendAjax($fid,$group,$call,$title,$room,$print,$print2);
                    }
                }
                else {
                    $('.alerts').prepend('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>You removed the item: '+$(this).text()+' - '+datetime+'</div>');
                    sendAjax($fid,$group,$call,$title,$room);
                }
            });
            $(".panel-title").unbind().click(function() {
                $room = $("#roomselect option:selected").val();
                if ($(this).closest('.panel-default').children('.panel-body').is(":hidden")) {
                    $group = $(this).data("group");
                    $(this).closest('.panel-default').children('.panel-body').show("fast");
                    sendAjax(1,$group,"visible","",$room,"","");
                }
                else {
                    $group = $(this).data("group");
                    $(this).closest('.panel-default').children('.panel-body').hide("fast");
                    sendAjax(0,$group,"visible","",$room,"","");
                }

            });

        }
        function sendAjax($fid,$group,$call,$title,$room,$print,$print2) {
            $.ajax({
                url: 'inc/rest.php',
                type: "post",
                data: { fid: $fid, group: $group, call: $call,title:$title,room:$room,print:$print,print2:$print2 },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(errorThrown);
                },
                success: function (data) {

                    renderTemplate();
                }
            });
        }
    });
})(jQuery);