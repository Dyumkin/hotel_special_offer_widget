var hotelOfferMedia;

(function ($) {
    hotelOfferMedia = {
        /**
         * Open media manager to select the image
         *
         * @param {string} widgetId
         * @returns {boolean}
         */
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

        /**
         * Set data to input and show preview image
         *
         * @param {string} widgetId
         * @param {object} attachment Selected image
         */
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

        /**
         * Remove data from input and hide preview
         *
         * @param {string} widgetId
         */
        remove: function (widgetId) {
            var content = hotelOfferMedia.getContent(widgetId);

            content.imageUrl.val('').trigger('change');
            content.imageAlt.val('').trigger('change');

            hotelOfferMedia.hidePreview(content);

            hotelOfferMedia.hideSelector(content.deleteButton);
            hotelOfferMedia.showSelector(content.selectButton);
        },

        /**
         * Return widget block
         *
         * @param {string} widgetId
         * @returns {{mediaControl: (*|HTMLElement), preview, previewImg: (*|HTMLElement), imageUrl, imageAlt, deleteButton, selectButton}}
         */
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

        /**
         * Return image url
         *
         * @param attachment Selected image
         * @returns {*}
         */
        getImageSRC: function (attachment) {
            return attachment.sizes.medium.url || attachment.url;
        },

        /**
         * Show image preview
         *
         * @param content
         * @param attachment Selected image
         */
        showPreview: function (content, attachment) {
            content.previewImg.attr('src', hotelOfferMedia.getImageSRC(attachment));
            content.previewImg.attr('alt', attachment.alt);

            hotelOfferMedia.hideSelector(content.preview.children());
            content.preview.append(content.previewImg);
        },

        /**
         * Hide image preview
         *
         * @param content
         */
        hidePreview: function (content) {
            content.preview.children('img').remove();
            hotelOfferMedia.showSelector(content.preview.children('div'));
        },

        /**
         * Hide HTML block
         *
         * @param selector
         */
        hideSelector: function (selector) {
            selector.removeClass('not-selected');
            selector.addClass('selected');
        },

        /**
         * Show HTML block
         *
         * @param selector
         */
        showSelector: function (selector) {
            selector.removeClass('selected');
            selector.addClass('not-selected');
        }
    };
})(jQuery);