$(function(){


	

	$("#image").on("change",function() {

		if (this.files && this.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#image-preivew').attr('src', e.target.result);
			}

			reader.readAsDataURL(this.files[0]);
		}
	});

	$(".add-cart").on("click",function(e){

		e.preventDefault();
		$(this).removeClass("btn-primary add-cart").addClass("btn-info disabled");
		var name = $(this).data("name"),
		id = $(this).data("id"),
		price =$.number( $(this).data("price"),2),
		html = `
		<tr>
		<input type='hidden' name='products[]' value='${id}'>
		<td>${name}</td>
		<td><input type="number" name='quantities[]' class='form-controll product-quantity ' style='width:50px ;' data-price ='${price}' min="1" value="1"></td>
		<td class='priceRow' >${price}</td>
		<td><button class='btn btn-danger btn-sm remove-btn' data-id='${id}'><span class='fa fa-trash'></span></button>	</td>
		</tr>	
		`;
		$("#order-list").append(html);
		calcTotal();
	});


	$(".update-cart").on("click",function(e){

		e.preventDefault();
		$(this).removeClass("btn-primary update-cart").addClass("btn-info disabled");
		var name = $(this).data("name"),
		id = $(this).data("id"),
		price =$.number( $(this).data("price"),2),
		html = `
		<tr>
		<td>${name}</td>
		<td><input type="number" name='quantities[]' class='form-controll product-quantity ' style='width:50px ;' data-price ='${price}' min="1" value="1"></td>
		<td class='priceRow' >${price}</td>
		<td><button class='btn btn-danger btn-sm remove-btn' data-id='${id}'><span class='fa fa-trash'></span></button>	</td>
		</tr>	
		`;
		$("#order-list").append(html);
		calcTotal();
	});

	$("body").on("click",".remove-btn",function(e){

		e.preventDefault();
		var id = $(this).data("id");
		$(this).closest("tr").remove(); 
		$("#product-"+id).removeClass("btn-info disabled").addClass("btn-primary add-cart");
		calcTotal();
	});

//on key up or change the  quantity of any product calc total of bill and total price of this product
$("body").on("keyup change",".product-quantity",function(){
	var quantity = parseInt($(this).val()),
	unitPrice =parseFloat($(this).data('price').toString().replace(/,/g, '')) ;
	console.log(quantity);
	console.log(unitPrice);
	$(this).closest("tr").find(".priceRow").html($.number(quantity*unitPrice,2));
	calcTotal();

});

// prevent any action of button has class disabled
$("body").on("click","button.disabled",function(e){

	e.preventDefault();

});
$(".order-products").on("click",function(){

	var url = $(this).data("url");
	$.ajax({
		url:url,
		method:"get",
		success:function(data){
			$(".products-position").html(data);
		}

	})
});


});

function calcTotal(){
	var price = 0;	
	$("#order-list .priceRow").each(function(){
		price +=parseFloat($(this).html().replace(/,/g, ''));


	});
	$(".total-price").html($.number(price,2));

	if(price>0)
	{
		$(".submit-order").removeClass("disabled");

	}
	else{
		$(".submit-order").addClass("disabled");
	}
}
