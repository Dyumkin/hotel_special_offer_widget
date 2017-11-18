/**
 * Hotel Special Offer Block
 *
 * @param context html block
 * @constructor
 */
function Offer(context) {
    this.context = jQuery(context);
    this.data = null;

    this.loader = this.context.find('.loader');
    this.table = this.context.find('div table');

    if (this.table.length == 0 || this.table.loader == 0) {
        this.context.hide();
        throw new Error('Special offer context doesn\'t have necessary html blocks');
    }

    this.loadData();
}

Offer.prototype.loadData = function () {

    if (typeof offer_config.ajax_url == 'undefined') {
        return;
    }

    var self = this;

    jQuery.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: offer_config.ajax_url,
        data: {
            action: 'offer_get_data',
            number: this.context.children().data('number')
        },
        beforeSend: function () {
            self.loader.show();
        },
        success: function (data) {
            if (!data) {
                self.hide();
            }

            self.render(data);
        },
        error: function () {
            self.hide();
        },
        complete: function () {
            self.loader.hide();
        }
    });
};

Offer.prototype.render = function (data) {
    var self = this,
        $arrival = this.table.find('.arrival'),
        $departure = this.table.find('.departure');

    self.table.find('.hotel').text(data['hotel_name'].toUpperCase());
    self.table.find('.room').text(data['room_name'].toUpperCase());
    self.table.find('.cost-rate').text(data['cost_rate'].toUpperCase());

    $arrival.find('.month').text(data['arrival_month'].toUpperCase());
    $arrival.find('.day').text(data['arrival_day']);

    $departure.find('.month').text(data['departure_month'].toUpperCase());
    $departure.find('.day').text(data['departure_day']);

    self.table.show();
};

Offer.prototype.hide = function () {
    this.context.hide();
};