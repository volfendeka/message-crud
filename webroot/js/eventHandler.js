var eventHandler = {

    init: function () {
        this.load();
        //this.save();
        this.preview();

    },


    load: function () {
        var input = document.getElementById('image');
        if(input){
            input.addEventListener("change", function(){
                if (document.getElementById("image").files.length === 0) {
                    return;
                }
                var file = document.getElementById("image").files[0];
                pageWidget.file_reader.onload = function (e) {
                    pageWidget.loadImage(e)
                };
                pageWidget.file_reader.readAsDataURL(file);
            });
        }

    },

    save: function () {
        $('#save').click(function(e){
            e.preventDefault();
            pageWidget.saveImage(pageWidget.image_data_url, document.getElementById("image").files[0].name);
        });
    },

    preview: function () {
        $('#preview').click(function(e){
            console.log($("#username").val());
            $("#preview_username").html($("#username").val());
            $("#preview_body").html($("#body").val());
            $("#preview_email").html($("#email").val());
        });
    }


};
