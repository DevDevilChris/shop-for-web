/**
 * Created by chrissmits on 19/05/14.
 */

function CartFunctions() {

}

CartFunctions.prototype.update = function() {
    var self = this;
    self.cart();
};

CartFunctions.prototype.cart = function() {
    var self = this;
    $.ajax({
        url:'/cart',
        type:'GET',
        dataType:'json',
        beforeSend: function() {
            console.log('sending');
            self.emptyItems();
        },
        success:function(response) {
            $('.count').html(response.count);
            $.each(response.cart, function(row, data) {
                var html = self.buildItem(data);
                $('tbody.cart-items').append(html);
            });
        }
    });
};

CartFunctions.prototype.emptyItems = function() {
    $('tbody.cart-items').empty();
};

CartFunctions.prototype.buildItem = function(row) {
    var html = "";
    html += "<tr>";
    html +=     "<td>";
    html +=         "<div class='media'>";
    html +=             "<img class='media-object img-rounded pull-left' data-src='holder.js/60x60' />";
    html +=             "<div class='media-body'>";
    html +=                 "<h4 class='media-heading'>"+row.name+"</h4>";
    html +=                 "<small>sku-id: "+row.id+"</small>";
    html +=             "</div>";
    html +=         "</div>";
    html +=     "</td>";
    html +=     "<td>";
    html +=     "&times "+row.qty;
    html +=     "</td>";
    html +=     "<td>";
    html +=     "<a href='/checkout/remove/"+row.rowid+"' class='btn btn-danger'>&times;</a>";
    html +=     "</td>";
    html += "</tr>";

    return html;
};

var CartNX = new CartFunctions();

$(function() {
    var selector =  $('.cart-expandable, .cart-summary');
    selector.mouseenter(function(event) {
        $(this).find('.cart-summary').show();
        $('.cart').addClass('mo');
    }).mouseleave(function(event) {
        $(this).find('.cart-summary').hide();
        $('.cart').removeClass('mo');
    });
});
