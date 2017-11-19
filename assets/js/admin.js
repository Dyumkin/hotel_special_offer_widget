var hotelOfferMedia;

(function ($) {
    hotelOfferMedia = {
        select: function (widgetId) {
            var frame = wp.media({
                title: 'Choose Image',
                multiple: false,
                library: {type: 'image'},
                button: {text: 'Choose Image'}
            });

            // Handle results from media manager.
            frame.on('select', function () {
                hotelOfferMedia.render(widgetId, frame.state().get('selection').first().toJSON());
            });

            frame.open();
            return false;
        },

        render: function (widgetId, attachment) {

            if (attachment == 'undefined') {
                return;
            }

            var content = hotelOfferMedia.getContent(widgetId);

            // update the alt if it has changed
            if (content.imageAlt.val() !== attachment.alt) {
                content.imageAlt.val(attachment.alt).trigger('change');
            }

            // update the url if it has changed
            if (content.imageUrl.val() !== hotelOfferMedia.getImageSRC(attachment)) {
                content.imageUrl.val(hotelOfferMedia.getImageSRC(attachment)).trigger('change');
            }

            hotelOfferMedia.showPreview(content, attachment);

            hotelOfferMedia.showSelector(content.deleteButton);
            hotelOfferMedia.hideSelector(content.selectButton);
        },

        remove: function (widgetId) {
            var content = hotelOfferMedia.getContent(widgetId);

            content.imageUrl.val('').trigger('change');
            content.imageAlt.val('').trigger('change');

            hotelOfferMedia.hidePreview(content);

            hotelOfferMedia.hideSelector(content.deleteButton);
            hotelOfferMedia.showSelector(content.selectButton);
        },

        getContent: function (widgetId) {
            var mediaControl = $('#' + widgetId);

            return {
                'mediaControl': mediaControl,
                'preview': mediaControl.find('.media-widget-preview'),
                'previewImg': $('<img draggable="false">'),
                'imageUrl': mediaControl.find('input.media-url'),
                'imageAlt': mediaControl.find('input.media-alt'),
                'deleteButton': mediaControl.find('.delete-offer-media'),
                'selectButton': mediaControl.find('.select-offer-media')
            };
        },

        getImageSRC: function (attachment) {
            return attachment.sizes.medium.url || attachment.url;
        },

        showPreview: function (content, attachment) {
            content.previewImg.attr('src', hotelOfferMedia.getImageSRC(attachment));
            content.previewImg.attr('alt', attachment.alt);

            hotelOfferMedia.hideSelector(content.preview.children());
            content.preview.append(content.previewImg);
        },

        hidePreview: function (content) {
            content.preview.children('img').remove();
            hotelOfferMedia.showSelector(content.preview.children('div'));
        },

        hideSelector: function (selector) {
            selector.removeClass('not-selected');
            selector.addClass('selected');
        },

        showSelector: function (selector) {
            selector.removeClass('selected');
            selector.addClass('not-selected');
        }
    };
})(jQuery);