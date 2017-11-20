(function($){
    $(document).ready(function() {
        var offers = [];

        //find and render all widgets in the page
        $('.widget.hotel-special-offer').each(function () {
            offers.push(new Offer(this));
        });
    });
})(jQuery);