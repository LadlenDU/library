var image = {
    showImage: function (file) {
        if (!window.FileReader) {
            return;
        }

        window.URL = window.URL || window.webkitURL;

        var reader = new FileReader();
        reader.addEventListener("load", function (e) {
            var useBlob = window.Blob && window.URL;

            var image = new Image();

            image.src = useBlob ? window.URL.createObjectURL(file) : reader.result;

            image.addEventListener("load", function () {
                $(".image_container a", form).attr("href", image.src);
                $(".image_container a img", form).attr("src", image.src);
            });

            if (useBlob) {
                window.URL.revokeObjectURL(file); // Освобождаем память.
            }
        });

        reader.readAsDataURL(file);
    }
};

