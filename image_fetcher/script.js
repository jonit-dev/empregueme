var config =
{
        maxWidth: 100,
        maxHeight: 75,
};


/** Default Document Ready Event **/
$(function()
{
        // Make form do what we want
        $('#url-form')
                .submit(getImagesFromUrl);
});


/**
 * Sends request for images.
 */
function getImagesFromUrl()
{
        // Make object out of form data
        var data = $(this).serializeObject();
        
        // Create request
        $.post($(this).attr('action'), data, getImagesFromUrlDone);

        // Return false so the form doesn't actually submit
        return false;
}


/**
 * Creates hidden image tags for the found image urls.
 */
function getImagesFromUrlDone(data)
{
        $('#output')
                .empty();

        if(data && data.images)
                for(var n in data.images)
                {
                        var image = $('<img>')
                                .prop(data.images[n])
                                .css({opacity: 0, display: 'none'})
                                .appendTo('#output')
                                .load(imageLoaded);
                }
}


/**
 * Set proper size and fade in after load.
 */
function imageLoaded()
{
        var image = $(this);

        // Remove tiny images
        if(image.width() < 2 || image.height() < 2)
        {
                image.remove();
                return;
        }

        // Find scale
        var scale = Math.min(config.maxWidth/image.width(), config.maxHeight/image.height());

        // Set new width and height
        image.attr({
			/*
                width: Math.ceil(scale*image.width()),
                height: Math.ceil(scale*image.height()),*/
				width: 200,
				height: 200,
        })

        // Fade in
        image
                .css({display: 'inline-block'})
                .animate({opacity: 1});
}


/**
 * Serializes a form into an object.
 */
$.fn.serializeObject = function()
{
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
                if (o[this.name]) {
                        if (!o[this.name].push) {
                                o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                } else {
                        o[this.name] = this.value || '';
                }
        });
        return o;
};