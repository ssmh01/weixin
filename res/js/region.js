/* $Id : region.js 4865 2007-01-31 14:04:10Z paulgao $ */

var region = new Object();

region.loadRegions = function(parent, type, target, cur)
{
    var callback;
    var url = region.getFileName()+'?type=' + type + '&target=' + target + "&parent=" + parent;
    if((typeof(cur) != "undefined") && (cur != "")){
        url += "&cur="+cur;
        callback = region.responseCur;
    }else{
        callback = region.response;
    }
  $.getJSON(url, callback);
}

/* *
 * 载入指定的国家下所有的省份
 *
 * @country integer     国家的编号
 * @selName string      列表框的名称
 * @cur     integer     当前省份id
 */
region.loadProvinces = function(country, selName, cur)
{
  var objName = (typeof selName == "undefined") ? "selProvinces" : selName;

  region.loadRegions(country, 1, objName, cur);
}

/* *
 * 载入指定的省份下所有的城市
 *
 * @province    integer 省份的编号
 * @selName     string  列表框的名称
 * @cur         integer 当前城市id
 */
region.loadCities = function(province, selName, cur)
{
  var objName = (typeof selName == "undefined") ? "selCities" : selName;

  region.loadRegions(province, 2, objName, cur);
}

/* *
 * 载入指定的城市下的区 / 县
 *
 * @city    integer     城市的编号
 * @selName string      列表框的名称
 * @cur     integer     当前镇区id
 */
region.loadDistricts = function(city, selName, cur)
{
  var objName = (typeof selName == "undefined") ? "selDistricts" : selName;

  region.loadRegions(city, 3, objName, cur);
}

/* *
 * 处理下拉列表改变的函数
 *
 * @obj     object  下拉列表
 * @type    integer 类型
 * @selName string  目标列表框的名称
 */
region.changed = function(obj, type, selName)
{
  var parent = obj.options[obj.selectedIndex].value;

  region.loadRegions(parent, type, selName);
}

region.response = function(result, text_result)
{
  var sel = document.getElementById(result.target);

  sel.length = 1;
  sel.selectedIndex = 0;

  if (document.all)
  {
    sel.fireEvent("onchange");
  }
  else
  {
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent('change', true, true);
    sel.dispatchEvent(evt);
  }
  if (result.regions)
  {
    for (var i in result.regions)
    {
      var opt = document.createElement("OPTION");
      opt.value = result.regions[i].id;
      opt.text  = result.regions[i].name;
      sel.options.add(opt);
    }
  }
}

region.getFileName = function()
{
    return "/system/region/";
}

region.responseCur = function(result, text_result){
    var sel = document.getElementById(result.target);
    var cur = (!isNaN(result.cur) && (result.cur != 0)) ? result.cur : 0;
    if (result.regions){
        for (var i in result.regions){
            var opt = document.createElement("OPTION");
            opt.value = result.regions[i].id;
            opt.text  = result.regions[i].name;
            sel.options.add(opt);
        }
        sel.value = cur;
    }
}
