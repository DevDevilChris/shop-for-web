/**
 * Created by chris on 13-04-14.
 */
function CheckoutProcess() {

};

CheckoutProcess.prototype.syncShippingTable = function() {
    var checked = $('#same_as_bt').is(':checked');

    $('[name*=bt_]').each(function(i, v){
        var fieldName = v.name.replace('bt_', 'st_');
        if($('[name='+fieldName+']').length > 0) {
            if(v.nodeName == 'SELECT') {
                console.log('select field');
            } else {
                $('[name='+fieldName+']').val(v.value);
            }
        }
    });

    $('div.sameasbt').css('display', (checked) ? 'none' : 'block');
};

CheckoutProcess.prototype.termsAccepted = function() {
    console.log($('input[name=terms_of_agreement]').val());

    return false;
};

CheckoutProcess.prototype.updateQty = function(product_key, qty) {
    var self = this;
    $.getJSON("checkout/update/"+product_key+"/"+qty, function(data) {
        var obj = $.parseJSON(data.cart);
        self.reloadTable( obj );
        CartNX.update();
    });
};

CheckoutProcess.prototype.removeProduct = function(product_key) {
    var self = this;
    $.getJSON("checkout/remove/"+product_key, function(data) {
        var obj = $.parseJSON(data.cart);
        self.removeRow(obj, data);
        CartNX.update();
    });
};

CheckoutProcess.prototype.reloadTable = function(data) {
    var self = this;

    $('tr[cart-item-id='+data.rowid+'] span.product_sub_price').fadeOut(200).fadeIn(200).html(number_format(data.subtotal, 2, ',', '.'));

    self.setTotalValues(data);
};

CheckoutProcess.prototype.removeRow = function(cart, data) {
    var self = this;
    var tr = $('tr[cart-item-id='+data.row_id+']');

    tr.fadeOut(400, function(){
        tr.remove();
    });

    self.setTotalValues(cart);
};

CheckoutProcess.prototype.setTotalValues = function(data) {
    $('span.product_total_sub').html(number_format(data.total, 2, ',', '.'));
    var vat = (data.total * 1.21 ) - data.total;
    $('span.product_total_vat').html(number_format(vat, 2, ',', '.'));
    $('span.product_total').html(number_format(data.total + vat, 2, ',', '.'));
};

var CheckoutNX = new CheckoutProcess();

