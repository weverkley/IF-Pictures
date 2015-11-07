    $(function() {
        $('.editable').inlineEdit({
            save: function(event, hash, widget) {
                widget._debug('save callback', 'value: ' + hash.value + "\n", 'id: ' + this.id);
                var data = new FormData();
                data.append(this.id, hash.value);
                var xhr = new XMLHttpRequest();
                xhr.addEventListener("load", editComplete, false);
                xhr.open("POST", "public/php/editprofile.php");
                xhr.send(data);
            },
            cancel: function(event, hash, widget) {
                widget._debug('cancel callback', 'value: ' + hash.value + "\n", 'id: ' + this.id);
            },
            change: function(event, widget) {
                widget._debug('change callback', 'id: ' + this.id);
            },
            mutate: function(event, widget) {
                widget._debug('mutate callback', 'id: ' + this.id);
            },
            debug: false
        });
    });

    function editComplete(data) {
        console.log(data.target.responseText);
    }
    $(document).ready(function() {
        //$('[data-toggle="tooltip"]').tooltip(); 
        $('[data-toggle="tooltip"]').mouseenter(function() {
            var that = $(this)
            that.tooltip('show');
            setTimeout(function() {
                that.tooltip('hide');
            }, 2000);
        });
        $('[data-toggle="tooltip"]').mouseleave(function() {
            $(this).tooltip('hide');
        });
    });