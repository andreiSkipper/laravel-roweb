$(document).ready(function () {
    $('.cart #cantity').change(function () {
        var form = $(this).parent().parent().serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        });
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/carts-edit/' + form['id'],
            type: 'POST',
            data: form,
            success: function (response) {
                result = JSON.parse(response);
                if (result == false) {
                    alert('Product does not exist in cart.');
                } else {
                    $('#cart-total')[0].innerHTML = result['total'];
                }
            }
        });
    });

    $('.cart #cart-delete').on('click', function () {
        if (confirm('Are you sure you want to delete this product?')) {
            var id = $(this).parent().parent().parent().parent().attr('id');
            id = id.split("-").pop();
            $.ajax({
                url: '/carts-delete/' + id,
                type: 'GET',
                success: function (response) {
                    result = JSON.parse(response);
                    if (result == false) {
                        alert('Product does not exist in cart.');
                    } else {
                        $('#cart-total')[0].innerHTML = result['total'];
                        $('#cart-badge')[0].innerHTML = result['count'];
                        $("#cart-" + id).animate({height: 'toggle'});
                    }
                }
            });
        }
    });

    $('.cart-add').on('click', function () {
        var form = $(this).parent().parent().serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        });
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/carts-add',
            type: 'POST',
            data: form,
            success: function (response) {
                result = JSON.parse(response);
                if (result == false) {
                    alert('There was a problem adding your product to cart.');
                } else {
                    $('#cart-badge')[0].innerHTML = result['count'];
                    alert('Product was added to your cart.');
                }
            }
        });
    });
});