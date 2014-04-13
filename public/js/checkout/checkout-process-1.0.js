/**
 * Created by chris on 13-04-14.
 */
function CheckoutProcess() {

};

CheckoutProcess.prototype.syncShippingTable = function() {
    var checked = $('#same_as_bt').is(':checked');

    if(checked) {
        $('input[name=st_firstname]').val( $('input[name=bt_firstname]').val() );
        $('input[name=st_insertion]').val( $('input[name=bt_insertion]').val() );
        $('input[name=st_lastname]').val( $('input[name=bt_lastname]').val() );
        $('input[name=st_address_1]').val( $('input[name=bt_address_1]').val() );
        $('input[name=st_address_2]').val( $('input[name=bt_address_2]').val() );
        $('input[name=st_zip]').val( $('input[name=bt_zip]').val() );
        $('input[name=st_city]').val( $('input[name=bt_city]').val() );

        $('div.sameasbt').css('display', 'none');
    } else {
        $('div.sameasbt').css('display', 'block');
    }
};

CheckoutProcess.prototype.termsAccepted = function() {
    console.log($('input[name=terms_of_agreement]').val());

    return false;
};

CheckoutProcess.prototype.updateQty = function(product_key, qty) {
    $.getJSON("checkout/update/"+product_key+"/"+qty, function(data) {
        console.log(data);
    });

    //TODO reset price table
};

CheckoutProcess.prototype.removeProduct = function(product_key) {
    $.getJSON("checkout/remove/"+product_key, function(data) {
        console.log(data);
    });

    //TODO reset price table
};

var CheckoutNX = new CheckoutProcess();

