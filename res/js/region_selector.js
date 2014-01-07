/**
 * 地区选择框(基于jq)
 *
 * @author Away shaoweizheng@163.com
 */
var Region = Region || {};
Region.Selector = {
    conId: "",                      //容器id
    provinces: {},                  //省份信息，json
    cities: {},                     //城市信息，json
    districts: {},                  //镇区信息，json
    selNameProvince: "m_province",    //省份下拉框name
    selNameCity: "m_city",            //城市下拉框name
    selNameDistrict: "m_area",    //镇区下拉框name
    selIdProvince: "selProvinces",  //省份下拉框id
    selIdCity: "selCities",         //城市下拉框id
    selIdDistrict: "selDistricts",  //镇区下拉框id
    selClassProvince: "uc_select",  //省份下拉框样式
    selClassCity: "uc_select",      //城市下拉框样式
    selClassDistrict: "uc_select",  //镇区下拉框样式
    showProvince: true,             //是否显示省份
    showCity: false,                //是否显示城市
    showDistrict: false,            //是否显示镇区
    curProvince: "",                //选中的省份
    curCity: "",                    //选中的城市
    curDistrict: "",                //选中的镇区
    country: 0,                     //国家id，用于获取省份列表，有指定则忽略 provinces
    province: 0,                    //省份id，用于获取城市列表，有指定则忽略 cities
    city: 0,                        //城市id，用于获取镇区列表，有指定则忽略 districts
    district: 0,                    //镇区id

    _init: function(config){
        var region = Region.Selector;
        for(var o in config){
            region[o] = config[o];
        }
    },

    /**
     * 生成省份
     */
    _genProvince: function(){
        var str = "";
        str += '<select name="'+this.selNameProvince+'" id="'+this.selIdProvince+'" onChange="region.changed(this, 2, \''+this.selIdCity+'\')" class="'+this.selClassProvince+'">';
        str += '    <option value="0">请选择省</option>';
        str += '</select>';
        jq("#"+this.conId).append(str);
        // if(!this.showProvince) jq("#"+this.selIdProvince).hide();
    },

    /**
     * 生成省份各项
     */
    _genProvinceItem: function(){
        var str = "", item;
        var curSelProvince = ((typeof(this.curProvince) == "undefined") || (this.curProvince == "")) ? this.province : this.curProvince;
        for(var i in this.provinces){
            item = this.provinces[i];
            str += '<option value="'+item.id+'"';
            if(curSelProvince == item.id) str += ' selected';
            str += '>'+item.name+'</option>';
        }
        jq("#"+this.selIdProvince).append(str);
    },

    /**
     * 动态加载省份列表
     */
    _genProvinceItemLoad: function(){
        region.loadProvinces(this.country, this.selIdProvince, this.province);
    },

    /**
     * 生成城市
     */
    _genCity: function(){
        var str = "";
        str += '<select name="'+this.selNameCity+'" id="'+this.selIdCity+'" onChange="region.changed(this, 3, \''+this.selIdDistrict+'\')" class="'+this.selClassCity+'">';
        str += '    <option value="0">请选择市</option>';
        str += '</select>';
        jq("#"+this.conId).append(str);
    },

    /**
     * 生成城市各项
     */
    _genCityItem: function(){
        var str = "", item;
        var curSelCity = ((typeof(this.curCity) == "undefined") || (this.curCity == "")) ? this.city : this.curCity;
        for(var i in this.cities){
            item = this.cities[i];
            str += '<option value="'+item.id+'"';
            if(curSelCity == item.id) str += ' selected';
            str += '>'+item.name+'</option>';
        }
        jq("#"+this.selIdCity).append(str);
    },

    /**
     * 动态加载城市列表
     */
    _genCityItemLoad: function(){
        region.loadCities(this.province, this.selIdCity, this.city);
    },

    /**
     * 生成镇区
     */
    _genDistrict: function(){
        var str = "";
        str += '<select name="'+this.selNameDistrict+'" id="'+this.selIdDistrict+'" class="'+this.selClassDistrict+'">';
        str += '    <option value="0">请选择区</option>';

        str += '</select>';
        jq("#"+this.conId).append(str);
        // if(!this.showDistrict) jq("#"+this.selIdDistrict).hide();
    },

    /**
     * 生成镇区各项
     */
    _genDistrictItem: function(){
        var str = "", item;
        var curSelDistrict = ((typeof(this.curDistrict) == "undefined") || (this.curDistrict == "")) ? this.district : this.curDistrict;
        for(var i in this.districts){
            item = this.districts[i];
            str += '<option value="'+item.id+'"';
            if(this.curDistrict == item.id) str += ' selected';
            str += '>'+item.name+'</option>';
        }
        jq("#"+this.selIdDistrict).append(str);
    },

    /**
     * 动态加载镇区列表
     */
    _genDistrictItemLoad: function(){
        region.loadDistricts(this.city, this.selIdDistrict, this.district);
    },

    /**
     * 显示
     *
     * @param {Object} config json
     */
    show: function(config){
        this._init(config);
        jq("#"+this.conId).html("");
        this._genProvince();
        this._genCity();
        this._genDistrict();
        (!isNaN(this.country) && (this.country != 0)) ? this._genProvinceItemLoad() : this._genProvinceItem();
        (!isNaN(this.province) && (this.province != 0)) ? this._genCityItemLoad() : this._genCityItem();
        (!isNaN(this.city) && (this.city != 0)) ? this._genDistrictItemLoad() : this._genDistrictItem();
    }
};