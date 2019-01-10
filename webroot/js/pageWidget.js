
var pageWidget = {

    base_url: 'http://task.loc/',
    file_reader: new FileReader(),
    image_data_url: '',
    image_new_name: '',

    init: function () {

    },

    loadImage: function (e) {
        var img = new Image();

        img.onload = function() {
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");
            var params = pageWidget.converter(img.width, img.height, 320, 240);
            canvas.width = params.width;
            canvas.height = params.height;
            ctx.drawImage(img,0,0,img.width,img.height,0,0,canvas.width,canvas.height);
            document.getElementById("preview_img").src = canvas.toDataURL();
            pageWidget.image_data_url = canvas.toDataURL();
        }
        img.src = e.target.result;
    },

    converter: function (src_width, src_height, max_width, max_height) {

        var ratio = Math.min(max_width / src_width, max_height / src_height);

        return {
            width: src_width*ratio,
            height: src_height*ratio
        };
    },

    saveImage: function (data_url, name) {
        $.ajax({
            type: "POST",
            url: pageWidget.base_url+"task/create",
            data: {
                imgBase64: data_url,
                username: $("#username").val(),
                email: $("#email").val(),
                body: $("#body").val(),
                image: name,
            },
            success: function() {
                window.location = '/';
            }
        }).done(function(o) {
            console.log('saved');
        });
    }
};




