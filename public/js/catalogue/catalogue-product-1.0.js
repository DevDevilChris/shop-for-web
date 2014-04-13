/**
 * Created by chris on 13-04-14.
 */
var CatalogueFunctions = function() {

};

CatalogueFunctions.prototype.plusQty = function(field_key) {
    var curVal = $('input[name='+field_key+']').val();
    if(curVal == undefined || curVal == "")
        curVal = 1;
    $('input[name='+field_key+']').val(parseInt(curVal)+1);

    CatalogueNX.setQty();
};

CatalogueFunctions.prototype.minusQty = function(field_key) {
    var curVal = $('input[name='+field_key+']').val();
    if(curVal>1)
        $('input[name='+field_key+']').val(curVal-1);

    CatalogueNX.setQty();
};

CatalogueFunctions.prototype.setQty = function() {
    var qty = $('input[name=product_qty]').val();
    var id = $('input[name=product_id]').val();
    var elem = $('a.add_to_cart');
    elem.prop('href', '/catalogue/add/' + id + '/' + qty);
};

var CatalogueNX = new CatalogueFunctions();
