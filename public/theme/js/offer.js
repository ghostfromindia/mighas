$(document).ready(function(){
        $(document).on('click', '#source .selectable', function(){
          if($(this).hasClass('selected'))
            $(this).removeClass('selected');
          else
            $(this).addClass('selected');
          check_all_selected();
        });

        $(document).on('click', '#destination .list-group-item, #free-destination .list-group-item, #combo-free-destination .list-group-item', function(){
            if($(this).hasClass('deselected'))
              $(this).removeClass('deselected');
            else
              $(this).addClass('deselected');
        });

        $(document).on('click', '#source-btn', function(){
          $('.selected').each( function(){
            $(this).removeClass('selected selectable');
            var clone = $(this).clone();
            clone.find('input').each(function() {
                this.name= 'offer_products[]';
            });
            $('#destination').append(clone);
            $(this).addClass('disabled');
            $('#offer_check').val('1');
          })
        });

        $(document).on('click', '#free-source-btn', function(){
          $('.selected').each( function(){
            $(this).removeClass('selected selectable');
            var clone = $(this).clone();
            clone.find('input').each(function() {
                this.name= 'free_products[]';
            });
            $('#free-destination').append(clone);
            $(this).addClass('disabled');
            $('#free_check').val('1');
          })
        });

        $(document).on('click', '#combo-free-source-btn', function(){
          $('.selected').each( function(){
            $(this).removeClass('selected selectable');
            var label = $(this).find('label').text();
            var pid = $(this).find('input').val();
            var html = "<li class='list-group-item' id='"+pid+"'><div><label>"+label+"</label>";
            html += '<div class="row column-seperation padding-5 combo-free-checkbox"><div class="checkbox check-success"><input type="checkbox" value="1" name="free[]" id="checkbox-'+pid+'" checked="checked"><label for="checkbox-'+pid+'">Free</label></div></div>';
            html += '<div style="display: none;" class="combo-free-discount"><div class="row column-seperation padding-5">';
            html += '<div class="form-group form-group-default form-group-default-select2"><label>Discount Type</label><select class="full-width select2-dropdown combo-free-discount-type" name="free_discount_type[]" ><option value="Discount Percentage">Discount Percentage</option><option value="Fixed Price">Fixed Price</option><option value="Discount Price">Discount Price</option></select>';
            html += '</div></div><div class="row column-seperation padding-5 combo-free-discount-amount" style="display:none;"><div class="form-group form-group-default">';
            html += '<label>Amount</label><input class="form-control amount" name="free_discount_amount[]" type="text"></div></div>';
            html += '<div class="row column-seperation padding-5 combo-free-discount-percentage"><div class="form-group form-group-default required">';
            html += '<label>Percentage</label><input class="form-control numeric" name="free_discount_percentage[]" type="text"></div><span class="error"></span>';
            html += '</div><div class="row column-seperation padding-5"><div class="form-group form-group-default required"><label>Maximum discount amount</label><input class="form-control numeric" name="free_max_discount_amount[]" type="text"></div></div></div>';
            html += '</div>';
            html += "<input type='hidden' name='combo_free_products[]' value='"+pid+"'/></div></li>";
            
            $('#combo-free-destination').append(html);
            $(this).addClass('disabled');
            $('#combo_free_check').val('1');
            $('.select2-dropdown').select2();
            $('#combo_free_check').val('1');
          })
        });

        $(document).on('click', '.combo-free-checkbox input', function(){
          if($(this).is(':checked'))
          {
            $(this).parents('.combo-free-checkbox').show();
            $(this).parents('.combo-free-checkbox').next('.combo-free-discount').hide();
          }
          else{
            $(this).parents('.combo-free-checkbox').next('.combo-free-discount').show();
          }
        });

        $(document).on('change', '.combo-free-discount-type', function(){
          var type = $(this).val();
          if(type == "Discount Percentage")
          {
            $(this).parents('.combo-free-discount').find('.combo-free-discount-amount').hide();
            $(this).parents('.combo-free-discount').find('.combo-free-discount-percentage').show();
          }
          else{
            $(this).parents('.combo-free-discount').find('.combo-free-discount-amount').show();
            $(this).parents('.combo-free-discount').find('.combo-free-discount-percentage').hide();
          }
        })

        $(document).on('click', '#destination-btn, #free-destination-btn, #combo-free-destination-btn', function(){
          $('.deselected').each( function(){
            var id = $(this).attr('id');
            $(this).detach();
            $('#source #'+id).removeClass('disabled').addClass('selectable');
          });
          if($("input[name='offer_products[]']").length == 0)
            $('#offer_check').val('');

          if($("input[name='free_products[]']").length == 0)
            $('#free_check').val('');

          if($("input[name='combo_free_products[]']").length == 0)
            $('#combo_free_check').val('');
        });

        $(document).on('click', '#filterBtn', function(){
          var selected_item = [];
          $('#destination .list-group-item').each( function(){
              selected_item.push($(this).find("input[name='offer_products[]']").val());
          });
          $('#free-destination .list-group-item').each( function(){
              selected_item.push($(this).find("input[name='free_products[]']").val());
          });
          $('#combo-free-destination .list-group-item').each( function(){
              selected_item.push($(this).find("input[name='combo_free_products[]']").val());
          });
          var data = {
            selected_item: selected_item,
            category: $('#category').val(),
            brand: $('#brand').val(),
            keyword: $('#keyword').val(),
            _token: _token,
          }
          $.post(base_url+'/admin/offers/ajax-list', data, function(result){
            $('#source').html(result);
            $('#filterModal').modal('hide');
          })
        })

        $('#source').bind('scroll', function(){
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
              load_more('scroll');
            }
        });

        $(document).on('click', '#load-more a', function(){
            load_more('click');
        });

        $(document).on('change', '#inputDiscountType, #inputComboDiscountType', function(){
          if($(this).val() == "Discount Percentage")
          {
            $('#offer-percentage-sec').show();
            $("#offer-amount-sec").hide();
          }
          else{
            $('#offer-percentage-sec').hide();
            $("#offer-amount-sec").show();
          }
        });

        $(document).on('change', '#inputType', function(){
          $('.offer-manager-sec').hide();
          if($(this).val() == "Price")
          {
            $('.offer-wrapper').show();
            $('#price-wrapper').show();
            $('#price_offer_applicable_to').trigger('change');
          }
          else if($(this).val() == "Combo")
          {
            $('.offer-wrapper').show();
            $('#combo-wrapper').show();
            $('#source-btn').show();

            $('#free-product-wrapper').hide();
            $('#free-source-btn').hide();
            //$('#free-wrapper').hide();

            $('#combo_offer_type').trigger('change');
          }
          else if($(this).val() == "Group")
          {
            $('.offer-wrapper').hide();
            $('#group-wrapper').show();
            $('#group_offer_type').trigger('change');
          }
          else if($(this).val() == "Free")
          {
            $('.offer-wrapper').show();
            $('#free-product-wrapper').show();
            $('#free-source-btn').show();
            $('#free-wrapper').show();
            $('#free_offer_applicable_to').trigger('change');
          }
        });

        $(document).on('change', '#group_offer_type', function(){
          if($(this).val() == "Another Product")
          {
            $('#group-offer-howmany-free-sec').show();
            $('.group-offer-price-wrapper').hide();
          }
          else{
            $('#group-offer-howmany-free-sec').hide();
            $('.group-offer-price-wrapper').show();
            $('#group_discount_type').trigger('change');
          }
        })

        $(document).on('change', '#combo_offer_type', function(){
          if($(this).val() == "Price")
          {
            $('.combo-offer-price-wrapper').show();
            $('#offer-product-wrapper').show();
            $('#combo-free-product-wrapper').hide();
            $('#combo-free-source-btn').hide();
            $('#combo_discount_type').trigger('change');
          }
          else{
            $('.combo-offer-price-wrapper').hide();
            $('#offer-product-wrapper').show();
            $('#combo-free-product-wrapper').show();
            $('#combo-free-source-btn').show();
          }
        })

        $(document).on('change', '#price_offer_applicable_to', function(){
          if($(this).val() == "Categories")
          {
            $('#price-category-sec').show();
            $('.offer-wrapper').hide();
          }
          else if($(this).val() == "All Products")
          {
            $('#price-category-sec').hide();
            $('.offer-wrapper').hide();
          }
          else{
            $('#price-category-sec').hide();
            $('.offer-wrapper').show();
            $('#offer-product-wrapper').show();
            $('#free-product-wrapper').hide();
            $('#combo-free-product-wrapper').hide();
          }
        });

        $(document).on('change', '#free_offer_applicable_to', function(){
          if($(this).val() == "Categories")
          {
            $('#free-category-sec').show();
            $('#offer-product-wrapper').hide();
            $('#source-btn').hide();
            $('#combo-free-source-btn').hide();
            $('#combo-free-product-wrapper').hide();
          }
          else if($(this).val() == "All Products")
          {
            $('#free-category-sec').hide();
            $('#offer-product-wrapper').hide();
            $('#source-btn').hide();
            $('#combo-free-source-btn').hide();
            $('#combo-free-product-wrapper').hide();
          }
          else{
            $('#free-category-sec').hide();
            $('#offer-product-wrapper').show();
            $('#source-btn').show();
            $('#combo-free-source-btn').hide();
            $('#combo-free-product-wrapper').hide();
          }
        })

        $(document).on('change', '#price_discount_type', function(){
          if($(this).val() == "Discount Percentage")
          {
            $('#price-offer-amount-sec').hide();
            $('#price-offer-percentage-sec').show();
          }
          else{
            $('#price-offer-amount-sec').show();
            $('#price-offer-percentage-sec').hide();
          }
        });

        $(document).on('change', '#combo_discount_type', function(){
          if($(this).val() == "Discount Percentage")
          {
            $('#combo-offer-amount-sec').hide();
            $('#combo-offer-percentage-sec').show();
          }
          else{
            $('#combo-offer-amount-sec').show();
            $('#combo-offer-percentage-sec').hide();
          }
        });

        $(document).on('change', '#group_discount_type', function(){
          if($(this).val() == "Discount Percentage")
          {
            $('#group-offer-amount-sec').hide();
            $('#group-offer-percentage-sec').show();
          }
          else{
            $('#group-offer-amount-sec').show();
            $('#group-offer-percentage-sec').hide();
          }
        });

        $(document).on('click', '#all-select', function(){
          if($(this).is(':checked'))
          {
            $('#source .selectable').each(function(){
              $(this).addClass('selected');
            });
          }
          else{
            $('#source .selected').each(function(){
              $(this).removeClass('selected');
            });
          }
        });

        $(document).on('change', '#combo_offer_type, #free_offer_applicable_to', function(){
            $('#source .disabled').each(function(){
              $(this).removeClass('disabled')
              $(this).addClass('selectable');
            });

            $('#destination').empty();
            $('#free-destination').empty();
            $('#combo-free-destination').empty();
        });

       var validator = $('#OfferFrm').validate({
          ignore: [],
          invalidHandler: function() {
            if(validator.numberOfInvalids())
            {
                if($('.alert-error').length>0)
                    $('.alert-error').remove();
                  var html = '<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error:</strong>Oops! look like you have missed some important fields, please check all tabs.</div>';
                  $( html ).insertBefore( ".page-wrapper" );
            }
          },
          errorPlacement: function(error, element){
              $(element).each(function (){
                  var id = $(this).attr('id');
                  if(id == 'offer_check' || id == 'free_check')
                    $(this).next('span.error').html(error);
                  else
                    $(this).parents('.form-group').next('span.error').html(error);
              });
          },
          rules: {
            offer_name: "required",
            type: "required",
            validity_start_date: "required",
            validity_end_date: "required",
            price_amount: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Price' && $('#price_discount_type option:selected').val() == "Discount Price"))
                  return true;
                else
                  return false;
              }
            },
            price_percentage: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Price' && $("#price_discount_type option:selected").val() == 'Discount Percentage'))
                  return true;
                else
                  return false;
              }
            },
            "price_categories[]":{
              required: function(element){
                if(($("#inputType option:selected").val() == 'Price' && $("#price_offer_applicable_to option:selected").val() == 'Categories'))
                  return true;
                else
                  return false;
              }
            },
            combo_amount: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Combo' && $('#combo_discount_type option:selected').val() == "Discount Price" && $('#combo_offer_type option:selected').val() == "Price"))
                  return true;
                else
                  return false;
              }
            },
            combo_percentage: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Combo' && $("#combo_discount_type option:selected").val() == 'Discount Percentage' && $('#combo_offer_type option:selected').val() == "Price"))
                  return true;
                else
                  return false;
              }
            },
            group_amount: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Group' && $('#group_discount_type option:selected').val() == "Discount Price" && $('#group_offer_type option:selected').val() == "Price"))
                  return true;
                else
                  return false;
              }
            },
            group_percentage: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Group' && $("#group_discount_type option:selected").val() == 'Discount Percentage' && $('#group_offer_type option:selected').val() == "Price"))
                  return true;
                else
                  return false;
              }
            },
            offer_check: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Price' && $("#price_offer_applicable_to option:selected").val() == 'Products') || $("#inputType option:selected").val() == 'Combo' || ($("#inputType option:selected").val() == 'Free' && $("#free_offer_applicable_to option:selected").val() == 'Products'))
                  return true;
                else
                  return false;
              }
            },
            free_check: {
              required: function(element){
                if($("#inputType option:selected").val() == 'Free')
                  return true;
                else
                  return false;
              }
            },
            "free_categories[]":{
              required: function(element){
                if(($("#inputType option:selected").val() == 'Free' && $("#free_offer_applicable_to option:selected").val() == 'Categories'))
                  return true;
                else
                  return false;
              }
            },
            combo_free_check: {
              required: function(element){
                if($("#inputType option:selected").val() == 'Combo' && $('#combo_offer_type option:selected').val() == "Another Product")
                  return true;
                else
                  return false;
              }
            },
          },
          messages: {
            offer_name: "Offer name cannot be blank",
            type: "Please select an offer type",
            validity_start_date: "Please select validity start date",
            validity_end_date: "Please select validity end date",
            discount_type: "Please select discount type",
            "price_categories[]": "Please select a category",
            price_amount: "Amount cannot be blank",
            price_percentage: "Percentage cannot be blank",
            combo_amount: "Amount cannot be blank",
            combo_percentage: "Percentage cannot be blank",
            group_amount: "Amount cannot be blank",
            group_percentage: "Percentage cannot be blank",
            offer_check: "Please add offer products",
            free_check: "Please add free products",
            "free_categories[]": "Please select a category",
            combo_free_check: "Please add offer products"
          },
        });
      });

    function check_all_selected()
    {
      if($('.selectable').length == $('.selected').length)
      {
        $('#all-select').prop('checked', true);
      }
      else{
        $('#all-select').prop('checked', false);
      }
    }
    function load_more($type)
    {
            var selected_item = [];
            $('#destination .list-group-item').each( function(){
                selected_item.push($(this).find("input[name='offer_products[]']").val());
            });
            var data = {
              category: $('#category').val(),
              brand: $('#brand').val(),
              keyword: $('#keyword').val(),
              select_all: $('#all-select').val(),
              "_token": _token,
            }
            var url = $('#pagination-ajax .pagination li.active + li a').attr('href');
            if (typeof url !== typeof undefined && url !== false)
            {
                  $('#pagination-ajax').remove();
                  $('#load-more').remove();
                  $.ajax({
                        url: url,
                        method: 'POST',
                        data: data,
                        success: function(result){
                          $('#source').append(result);
                      },
                  });
            }
    }