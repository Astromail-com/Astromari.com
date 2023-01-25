/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2021 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
$(document).ready(function(){
   if($('.ets_col_product_list_wrapper.layout-slide:not(.slick-slider):not(.product_list_16)').length >0)
   {
        $('.ets_col_product_list_wrapper.layout-slide:not(.slick-slider):not(.product_list_16)').each(function(){
            var ets_col_nbItemsPerLine = $(this).data('row-desktop');
            var ets_col_nbItemsPerLineTablet = $(this).data('row-tablet');
            var ets_col_nbItemsPerLineMobile = $(this).data('row-mobile');
            $(this).slick({
                  slidesToShow: ets_col_nbItemsPerLine,
                  slidesToScroll: 1,
                  arrows: true,
                  responsive: [
                      {
                          breakpoint: 1199,
                          settings: {
                              slidesToShow: ets_col_nbItemsPerLine
                          }
                      },
                      {
                          breakpoint: 992,
                          settings: {
                              slidesToShow: ets_col_nbItemsPerLineTablet
                          }
                      },
                      {
                          breakpoint: 768,
                          settings: {
                              slidesToShow: ets_col_nbItemsPerLineMobile
                          }
                      },
                      {
                          breakpoint: 480,
                          settings: {
                            slidesToShow: ets_col_nbItemsPerLineMobile
                          }
                      }
                   ]
            });
        });
   } 
   if($('.ets_col_product_list_wrapper.layout-slide.product_list_16:not(.slick-slider)').length >0)
   {
        $('.ets_col_product_list_wrapper.layout-slide.product_list_16:not(.slick-slider)').each(function(){
            var ets_col_nbItemsPerLine = $(this).data('row-desktop');
            var ets_col_nbItemsPerLineTablet = $(this).data('row-tablet');
            var ets_col_nbItemsPerLineMobile = $(this).data('row-mobile');
            $(this).find('.product_list').slick({
                  slidesToShow: ets_col_nbItemsPerLine,
                  slidesToScroll: 1,
                  arrows: true,
                  responsive: [
                      {
                          breakpoint: 1199,
                          settings: {
                              slidesToShow: ets_col_nbItemsPerLine
                          }
                      },
                      {
                          breakpoint: 992,
                          settings: {
                              slidesToShow: ets_col_nbItemsPerLineTablet
                          }
                      },
                      {
                          breakpoint: 768,
                          settings: {
                              slidesToShow: ets_col_nbItemsPerLineMobile
                          }
                      },
                      {
                          breakpoint: 480,
                          settings: {
                            slidesToShow: ets_col_nbItemsPerLineMobile
                          }
                      }
                   ]
            });
        })
   }
   if($('.ets_collections_product_list_wrapper.slide:not(.slick-slider)').length >0)
   {
       var ets_col_nbItemsPerLine = $('.ets_collections_product_list_wrapper.slide:not(.slick-slider)').data('row-desktop');
       var ets_col_nbItemsPerLineTablet = $('.ets_collections_product_list_wrapper.slide:not(.slick-slider)').data('row-tablet');
       var ets_col_nbItemsPerLineMobile = $('.ets_collections_product_list_wrapper.slide:not(.slick-slider)').data('row-mobile');     
       $('.ets_collections_product_list_wrapper.slide:not(.slick-slider)').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: true,
          responsive: [
              {
                  breakpoint: 1199,
                  settings: {
                      slidesToShow: ets_col_nbItemsPerLine
                  }
              },
              {
                  breakpoint: 992,
                  settings: {
                      slidesToShow: ets_col_nbItemsPerLineTablet
                  }
              },
              {
                  breakpoint: 768,
                  settings: {
                      slidesToShow: ets_col_nbItemsPerLineMobile
                  }
              },
              {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: ets_col_nbItemsPerLineMobile
                  }
              }
           ]
       });
    }
});