/*! my-scss 2016-11-23 */
$.nette.ext("ublaboo-spinners",{before:function(a,b){var c,d,e,f;if(b.nette){if(c=b.nette.el,f=$('<div class="ublaboo-spinner ublaboo-spinner-small"><i></i><i></i><i></i><i></i></div>'),c.is('.datagrid [name="group_action[submit]"]'))return c.after(f);if(c.is(".datagrid a")&&c.data("toggle-detail")){if(d=b.nette.el.attr("data-toggle-detail"),e=$(".item-detail-"+d),!e.hasClass("loaded"))return c.addClass("ublaboo-spinner-icon")}else{if(c.is(".datagrid .col-pagination a"))return c.closest(".row-grid-bottom").find(".col-per-page").prepend(f);if(c.is(".datagrid .datagrid-per-page-submit"))return c.closest(".row-grid-bottom").find(".col-per-page").prepend(f)}}},complete:function(){return $(".ublaboo-spinner").remove(),$(".ublaboo-spinner-icon").removeClass("ublaboo-spinner-icon")}});