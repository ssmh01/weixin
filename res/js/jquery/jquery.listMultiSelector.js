/**
 * 多选列表
 *
 * @author Away shaoweizheng@163.com
 * @version 1.0.0
 * 获取的数据格式：
 * [{id:id,pid:父id,name:名称},{id:id,pid:父id,name:名称}]
 */
;(function($){
    $.fn.listMultiSelector = function(options){
        var LEVEL_ITEMID_SEP = "_";                     //层级与项id关联之间分隔符
        var LI_ID_PRE = "list_li_";                     //列表项id属性前缀
        var LI_REL_PRE = "list_li_rel_";                //列表项rel属性前缀
        var CACHE_ID = "cache_";                        //缓存容器id
        var CACHE_KEY_PRE = "cache_key_";               //缓存键前缀
        var LIST_ID_PRE = "list_con_";                  //列表id前缀
        var LEVEL_ID_PRE = "level_con_";                //层级容器id前缀
        var LIST_CUR_PRE = "list_cur_";                 //列表cur属性前缀
        var INPUT_SELECT_ID_PRE = "list_item_";         //选框控件id前缀
        var INPUT_SELECT_REL_PRE = "list_item_rel_";    //选框控件rel属性前缀

        var _selectType = "";           //选择类型，单多选
        var _indexArr = new Array();    //列表数，第一维为层级，第二维为在当前层级的索引
        var _initLevelIndex = 0;        //层级索引初始值
        var _indexLevel = 0;            //层级索引
        var _ajaxRequest;               //ajax请求
        var _dataSel = {};              //存放选中的项
        var _initIdsArr = [];//初始id
        var _loadInitIdsArr = [];//已加载的初始id

        var defaults = {
            width: "150px",                     //每个列表的宽度
            url: "/common/category/ajax/",      //获取数据的地址
            urlParam: {},                       //url相关参数，json格式
            multiSelect: true,                  //是否为多选
            itemNum: 10,                        //一个列表展示的数量
            dataId: "list_data",                //提交数据的控件id
            dataName: "listids",                //提交数据的控件name
            initPid: 0,                         //父id初始值
            listClass: "c_icenter_select_box",  //列表容器class
            selectFormClass: "left",             //复选框控件class
            ids: ""//已有的分类，多个以逗号分隔
        };
        var options = $.extend(defaults, options);
        var self = $(this);

        _selectType = options.multiSelect ? "checkbox" : "radio";

        this.each(function(){
            createDataCon();
            run();
        });

        /**
         * 开始执行
         */
        function run(){
            if(options.ids != "") _initIdsArr = options.ids.split(",");
            for(var _i= 0,_len=_initIdsArr.length; _i<_len; _i++){
                if(_initIdsArr[_i] == "") delete(_initIdsArr[_i]);
            }
            genLevel(_initLevelIndex, options.initPid);
        }

        /**
         * 生成层级
         *
         * @param {Number} level 层级
         * @param {Number} pid 父id
         */
        function genLevel(level, pid){
            var i = 0;
            $("div[id^='"+LEVEL_ID_PRE+"']").each(function(){
                (i++ > level) ? $(this).hide() : $(this).show();
            });

            var level_id = genLevelAndId(level,pid);
            $("#"+LEVEL_ID_PRE+level+" > ul").each(function(){//隐藏当前层级下的列表
                $(this).hide();
            });
            if($("#"+LEVEL_ID_PRE+level+" > ul[id='"+LIST_ID_PRE+level_id+"']").length > 0){
                $("#"+LEVEL_ID_PRE+level+" > ul[id='"+LIST_ID_PRE+level_id+"']").show();
            }else{//生成子级容器
                var data = {"pid":pid};
                if(options.urlParam) data = mergerJson(data, options.urlParam);
                $.getJSON(options.url, data, function(items){
                    if(items.length > 0){
                        if($("#"+LEVEL_ID_PRE+level).length == 0) self.append('<div id="'+LEVEL_ID_PRE+level+'"></div>');
                        genList(items, level, pid);
                        var _i = $.inArray(pid, _loadInitIdsArr);
                        if(_i == -1){
                            selectAllSub(level-1, pid);
                        }else{
                            _loadInitIdsArr.splice(_i, 1);
                        }

                        setValidData();
                    }
                });
            }
        }

        /**
         * 生成列表
         *
         * @param {Object} items 列表各项信息，json格式
         * @param {Number} level 层级
         * @param {Number} pid 父id
         */
        function genList(items, level, pid){
            var ulId = LIST_ID_PRE+genLevelAndId(level,pid);
            var plevel = level - 1;//父层级
            if($("#"+ulId).length == 0){
                var html = '';
                html += '<ul id="'+ulId+'" class="'+options.listClass+'" cur="'+LIST_CUR_PRE+level+'">';
                for(var i=0,len=items.length; i<len; i++){
                    html += '<li id="'+LI_ID_PRE+genLevelAndId(level,items[i].id)+'" rel="'+LI_REL_PRE+genLevelAndId(plevel,pid)+'">';
                    html += '<input type="'+_selectType+'" value="'+items[i].id+'" id="'+INPUT_SELECT_ID_PRE+genLevelAndId(level,items[i].id)+'" rel="'+INPUT_SELECT_REL_PRE+genLevelAndId(plevel,pid)+'" class="'+options.selectFormClass+'" />'+items[i].name;
                    html += '</li>';
                }
                html += '</ul>';
                $("ul[cur='"+LIST_CUR_PRE+level+"']").each(function(){
                    $(this).hide();
                });
                $("#"+LEVEL_ID_PRE+level).append(html);
                var info;
                //触发列表项
                $("#"+ulId+" > li").each(function(){
                    var _this = $(this);
                    _this.bind({
                        click: function(){
                            //显示子级
                            info = getLevelAndId(_this.attr("id"));
                            genLevel(level+1, info.id);
                        }
                    });
                });
                //点击选框
                $("#"+ulId+" input[id^='"+INPUT_SELECT_ID_PRE+"']").each(function(){
                    var _this = $(this);
                    _this.bind({
                        click: function(){
                            //子级相关
                            selectAllSub(level, _this.val());

                            //父级相关
                            if(_this.attr("checked")){
                                var _relInfo = getLevelAndId(_this.attr("rel"));
                                selectParentStatus(_relInfo.level, _relInfo.id);
                            }else{
                                var _idInfo = getLevelAndId(_this.attr("id"));
                                cancelParentStatus(_idInfo.level, _idInfo.id);
                            }

                            setValidData();
                        }
                    });
                });
            }

            $("#"+LIST_ID_PRE+plevel).each(function(){
                $(this).hide();
            });
            $("#"+ulId).show();

            //初始选中项
            if(_initIdsArr.length > 0){
                $("li[rel='"+LI_REL_PRE+genLevelAndId(plevel,pid)+"'] > input[id^='"+INPUT_SELECT_ID_PRE+"']").each(function(){
                    var _this = $(this);
                    var _i = $.inArray(_this.val(), _initIdsArr);
                    if(_i != -1){
                        _this.attr("checked", true);
                        _loadInitIdsArr.push(_initIdsArr[_i]);
                        _initIdsArr.splice(_i, 1);

                        genLevel(level+1, _this.val());
                    }
                });
            }
        }

        /**
         * 创建提交数据的容器
         */
        function createDataCon(){
            if($("#"+options.dataId).length == 0) self.after('<input type="hidden" name="'+options.dataName+'" id="'+options.dataId+'" />');
        }

        /**
         * 选择所有子级
         *
         * @param {String} plevel 父层级
         * @param {String} pid 父级id
         */
        function selectAllSub(plevel, pid){
                var _level_id = genLevelAndId(plevel,pid);
                var selStatus = $("#"+INPUT_SELECT_ID_PRE+_level_id).attr("checked");
                $("input[rel='"+INPUT_SELECT_REL_PRE+_level_id+"']").each(function(){
                    $(this).attr("checked", selStatus);
                });
        }

        /**
         * 获取层级索引与id
         *
         * @param {String} str 要识别的字符串
         * @return {Object} {level:层级索引, id:id}
         */
        function getLevelAndId(str){
            var arr = str.split("_");
            var id = arr.pop();
            var level = arr.pop();
            return {level:level, id:id};
        }

        /**
         * 生成层级索引与id关联
         *
         * @param {Number} level 层级
         * @param {Number} id
         */
        function genLevelAndId(level, id){
            return level+LEVEL_ITEMID_SEP+id;
        }

        /**
         * 合并两个json
         *
         * @param {Object} json
         * @param {Object} addJson
         * @return {Object}
         */
        function mergerJson(json, addJson){
            for(var o in addJson){
                json[o] = addJson[o];
            }
            return json;
        }

        /**
         * json转为数组
         *
         * @param json
         * @return array
         */
        function json2Array(json){
            var _arr = new Array();
            for(var o in json){
                _arr.push(json[o]);
            }
            return _arr;
        }

        /**
         * 设置要提交的数据
         */
        function setValidData(){
            var _idsArr = new Array();
            $("input[id^='"+INPUT_SELECT_ID_PRE+"']").each(function(){
                var _this = $(this);
                if(_this.attr("checked")) _idsArr.push(_this.val());
            });
            $("#"+options.dataId).val(_idsArr.join(","));
//            $("#"+options.dataId).val(json2Array(_dataSel).join(","));
        }

//        /**
//         * 选中/取消项时修改提交的数据
//         *
//         * @param {Object} obj 选框控件对象
//         */
//        function selectItemHandle(obj){
//            var $obj = $(obj);//转为jquery对象
//            var idInfo = getLevelAndId($obj.attr("id"));
//            var relInfo = getLevelAndId($obj.attr("rel"));
//            var level = idInfo.level;
//            var pid = relInfo.id;
//            var selectAll = true;
//            var _datasCurSel = {};//当前列表选中的数据
//            var _datas = {};//当前列表下的数据
//            $("#"+LIST_ID_PRE+genLevelAndId(level,pid)+" > li > input[rel^='"+INPUT_SELECT_REL_PRE+"']").each(function(){
//                var _this = $(this);
//                var _val = _this.val();
//                _datas[_val] = _val;
//                if(_this.attr("checked") == true) _datasCurSel[_val] = _val;
//                if(_this.attr("checked") == false) selectAll = false;//非全选
//            });
//            for(var i=0,len=_datas.length; i<len; i++){
//                delete(_dataSel[_datas[i]]);
//            }
//
//            if(selectAll){//子级全选，保存父id
//                _dataSel[pid] = pid;
//            }else{//保存选中的子级
//                for(var o in _datasCurSel){
//                    _dataSel[_datasCurSel[o]] = _datasCurSel[o];
//                }
//                delete(_dataSel[pid]);
//            }
//
//            setValidData();
//        }

        /**
         * 选中父级选框
         *
         * @param {Number} plevel 父层级
         * @param {Number} pid 父id
         */
        function selectParentStatus(plevel, pid){
            if(plevel >= _initLevelIndex){
                var cur = $("#"+INPUT_SELECT_ID_PRE+genLevelAndId(plevel,pid));
                cur.attr("checked", true);
                var relInfo = getLevelAndId(cur.attr("rel"));
                selectParentStatus(relInfo.level, relInfo.id);
            }
        }

        /**
         * 取消父级选框
         *
         * @param {Number} level 当前层级
         * @param {Number} id 当前id
         */
        function cancelParentStatus(level, id){
            if(level >= _initLevelIndex){
                var cur = $("#"+INPUT_SELECT_ID_PRE+genLevelAndId(level,id));
                cur.attr("checked", false);
                var allCancel = true;
                $("input[rel='"+cur.attr("rel")+"']").each(function(){
                    if($(this).attr("checked") == true){
                        allCancel = false;
                        return;
                    }
                });
                if(allCancel){
                    var relInfo = getLevelAndId(cur.attr("rel"));
                    cancelParentStatus(relInfo.level, relInfo.id);
                }
            }
        }
    }
})(jQuery);
