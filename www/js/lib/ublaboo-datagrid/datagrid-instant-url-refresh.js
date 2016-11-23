/*! my-scss 2016-11-23 */
$(function(){return $(".datagrid").length?$.nette.ajax({type:"GET",url:$(".datagrid").first().data("refresh-state")}):void 0});