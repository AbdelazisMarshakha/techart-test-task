var testData;

$(function() {

	/*
	 * 
	 */
    $('#js__supply_btn').on('click', function(){
     
        alert("agent");
        return false;
    });
    
	$('.js__compare-with-order').on('click', function(e){
        e.preventDefault();
		
		//

        return false;
    });

	/*
	 * Клик на кнопке с товаром в таблице
	 */
	function jsVariantsCall(xmlId) {
        $("#loadMe").modal({
				backdrop: "static", //remove ability to close modal with click
				//keyboard: false, //remove option to close with keyboard
				show: true //Display loader!
			});
			
        $.ajax({
            url: './ajax.php?action=getVariant',
            data: {
                q: xmlId
            },
            type: 'GET',
            dataType: 'json'
        })
        .done(function(json){
            if (json.success == true) {
				// данные для формирования таблицы
				html = '<table class="variants_table" style="width: 100%;">';

				thead = '<thead>';

				theadRow = '<tr><th>&nbsp;</th>';

				$.each(json.sizes, function(kk, vv){
					theadRow += '<th>' + vv.size + '</th>';
				});
				
				theadRow += '</tr>';
				
				thead += theadRow + '</thead>';

				tbody = '<tbody>';

				$.each(json.answer, function(kk, vv){
					bodyRow = '<tr><th>' + kk + '</th>';

					/*
						product_xmlId: "e991dedc-1977-11e9-9ff4-31500004717a"
						xmlId: "7227a43c-1978-11e9-9107-504800044313"
						color: "SY1725"
						size: "38"
						
						quantity
						
						контейнер-приёмник: 'variants__' + xmlId
					*/
					
					testData = vv;
					
					$.each(json.sizes, function(skk, svv){
						//console.log('[ITER] skk: ' + skk + ', svv: ' + JSON.stringify(svv));
						
						key = svv['size'];

						if (typeof vv[key] !== "undefined") {
							bodyRow += '<td>' + vv[key]['color'] + ' / ' + vv[key]['size'] + '</td>';
						} else {
							bodyRow += '<td>&nbsp;</td>';
						}
					});
					
					bodyRow += '</tr>';
					
					tbody += bodyRow;
				});

				tbody += '</tbody>';

                html += thead + tbody + '</table>';
				
				// id="variants__' + vv.xmlId + '"
				
				$('#variants__' + xmlId).html(html);
            } else {
            }
        
			$("#loadMe").modal("hide");
        })
        .fail(function(xhr, status, errorThrown){
            console.log('[ERROR] status: ' + status + ', errorThrown: ' + errorThrown + '');
        
			$("#loadMe").modal("hide");
        });

        return false;
	}
	
    /*
     * Получить список товаров/моделей
     */
    $('.js__apply_filters_btn').on('click', function(e){
        e.preventDefault();
		$('#js__supply_btn').prop('disabled', true);

        $("#loadMe").modal({
				backdrop: "static", //remove ability to close modal with click
				//keyboard: false, //remove option to close with keyboard
				show: true //Display loader!
			});

        $.ajax({
            url: './ajax.php?action=filterProducts',
            data: {
                itemSearchedBrand: $('#itemSearchedBrand').val(),
                itemSearchedArticle: $('#itemSearchedArticle').val(),
                itemSearchedSize: $('#itemSearchedSize').val(),
                itemSearchedColor: $('#itemSearchedColor').val(),
                itemSearchedCompareWith: $('#itemSearchedCompareWith').val()
            },
            type: 'POST',
            dataType: 'json'
        })
        .done(function(json){
            if (json.success == true) {
                html = '<table class="product_table" style="width: 100%;"><tbody>';
                $(json.answer).each(function(kk, vv){
					prices = '';
					vv.salePrices = JSON.parse(vv.salePrices);

					if (typeof vv.salePrices == "object" && vv.salePrices.length > 0) {
						$(vv.salePrices).each(function(ind, item){
							prices += item.priceType + ': ' + (item.value / 100) + '<br />';
						});
					}
					
                    html += '<tr id="' + vv.xmlId + '"> \
                                <td width="150">' + (vv.image != '' ? '<img src="data:image/png;base64,' + vv.image + '" alt=" " style="max-width: 150px;" />' : '&nbsp;') + '</td>\
                                <td>\
                                    <p>' + vv.name + ' (<a href="' + vv.url + '" target="_blank">перейти</a>)</p>\
									' + (vv.brand != '' ? 'Производитель: ' + vv.brand + '<br />' : '') + ' \
									' + (vv.article != '' ? 'Артикул: ' + vv.article + '<br />' : '') + ' \
									Закупочная цена: <input type="text" \
															name="buyPrice[' + vv.xmlId + ']" \
															id="" \
															value="' + (vv.buyPrice / 100) + '"\
															/><br /> \
									' + prices + ' \
									\
									<div id="variants__' + vv.xmlId + '"></div> \
                                </td> \
								<td> \
									<button class="btn btn-info js__variants_call" data-xmlId="' + vv.xmlId + '">Модификации</button> \
								</td> \
                            </tr>';
                });
                html += '</tbody></table>';
                
                $('#js__items_container').html(html);

				$('#js__supply_btn').prop('disabled', false);

				// заново активируем обработчик клика на кнопке после её перерисовки аяксом
				$('.js__variants_call').on('click', function(e){
					e.preventDefault();

					return jsVariantsCall($(this).attr('data-xmlId'));
				});
                
            } else {
                $('#js__items_container').html('<p><b>Ошибка!</b></p><p>' + json.error + '</p>');
            }
        
			$("#loadMe").modal("hide");
        })
        .fail(function(xhr, status, errorThrown){
            console.log('[ERROR] status: ' + status + ', errorThrown: ' + errorThrown + '');
        
			$("#loadMe").modal("hide");
        });

        return false;
    });

})