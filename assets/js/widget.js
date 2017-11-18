(function($){
    $(document).ready(function() {
        var offers = [];

        $('.widget.hotel-special-offer').each(function () {
            offers.push(new Offer(this));
        });
    });
})(jQuery);