/*! Fabrik */

define(["jquery","fab/list-plugin"],function(jQuery,FbListPlugin){var FbListPhp=new Class({Extends:FbListPlugin,initialize:function(t){this.parent(t)},buttonAction:function(event){var additional_data=this.options.additional_data,hdata=$H({}),rowIndexes=[],ok;this.list.getForm().getElements("input[name^=ids]").each(function(e){if(e.checked){ok=!0;var n=e.name.match(/ids\[(\d+)\]/)[1];rowIndexes.push(n),additional_data&&(hdata.has(n)||hdata.set(n,$H({})),hdata[n].rowid=e.value,additional_data.split(",").each(function(t){var i=e.getParent(".fabrik_row").getElements("td.fabrik_row___"+t)[0].innerHTML;hdata[n][t]=i}))}});var chxs=this.list.getForm().getElements("input[name^=ids]").filter(function(t){return t.checked}),ids=chxs.map(function(t){return t.get("value")}),rows={};if(chxs.each(function(t){var i=t.get("value");rows[i]=this.list.getRow(i)}.bind(this)),additional_data&&(this.list.getForm().getElement("input[name=fabrik_listplugin_options]").value=Json.encode(hdata)),""!==this.options.js_code){var result=eval("(function() {"+this.options.js_code+"}())");if(!1===result)return}this.list.submit("list.doPlugin")}});return FbListPhp});