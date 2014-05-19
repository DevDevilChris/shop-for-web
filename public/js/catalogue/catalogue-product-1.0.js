/**
 * Created by chris on 13-04-14.
 */
var CatalogueFunctions = function() {

};

CatalogueFunctions.prototype.addToCart = function(product_key, qty, response) {
    $.getJSON("/catalogue/add/"+product_key+"/"+qty+"/"+response, function(data) {
        if(data.status == "success") {
            $('#addToCartModal').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
}

CatalogueFunctions.prototype.plusQty = function(field_key, js_add_to_cart) {
    var curVal = $('input[name='+field_key+']').val();
    if(curVal == undefined || curVal == "")
        curVal = 1;
    $('input[name='+field_key+']').val(parseInt(curVal)+1);

    CatalogueNX.setQty(js_add_to_cart);
};

CatalogueFunctions.prototype.minusQty = function(field_key, js_add_to_cart) {
    var curVal = $('input[name='+field_key+']').val();
    if(curVal>1)
        $('input[name='+field_key+']').val(curVal-1);

    CatalogueNX.setQty(js_add_to_cart);
};

CatalogueFunctions.prototype.setQty = function(js_add_to_cart) {
    var qty = $('input[name=product_qty]').val();
    var id = $('input[name=product_id]').val();
    var elem = $('a.add_to_cart');
    var js_atc = $('input[name=js_add_to_cart]').val();

    if(js_atc)
        elem.prop('href', 'javascript: CatalogueNX.addToCart('+id+', '+qty+', '+js_add_to_cart+');');
    else
        elem.prop('href', '/catalogue/add/' + id + '/' + qty + '/' + js_add_to_cart);
};

var CatalogueNX = new CatalogueFunctions();

//capture escape key

