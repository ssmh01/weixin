function resetPlayWayData(domId){
    var playWayId = domId.split('_').pop();
	GuessAddHelper.resetPlayWayData(playWayId);
}
/**
 * 竞猜玩法数据类
 * 
 * @returns PlayWayData
 */
function PlayWayData() {
    // [int]玩法ID
    this.id = '';
    // [string]玩法名称
    this.name = '';
    // [int]赔率类型，默认为固定赔率
    this.oddsType = GuessAddHelper.ODDS_TYPE_FIXED;
    // 浮动比率
    this.floatPercent = 0;
    // [int]固定赔率时投注下限
    this.bettingLowerLimit = 0;
    // [int]固定赔率或浮动赔率时投注上限
    this.bettingUpperLimit = 0;
    // [int]固定赔率时参与竞猜人数上限
    this.playCountLimit = 0;
    // [Json]固定赔率时的赔率数据，竞猜选项参数名作键，赔率作值
    this.odds = {}
    if(typeof PlayWayData.__initialized == "undefined"){
	//
	PlayWayData.prototype.setId = function(id) {
	    this.id = id;
	};
	PlayWayData.prototype.getId = function() {
	    return this.id;
	};
	PlayWayData.prototype.setName = function(name) {
	    this.name = name;
	};
	PlayWayData.prototype.getName = function() {
	    return this.name;
	};
	PlayWayData.prototype.setOddsType = function(oddsType) {
	    this.oddsType = notNanParseInt(oddsType);
	};
	PlayWayData.prototype.getOddsType = function() {
	    return this.oddsType;
	};
	PlayWayData.prototype.setFloatPercent = function(floatPercent) {
	    this.floatPercent = notNanParseFloat(floatPercent);
	};
	PlayWayData.prototype.getFloatPercent = function() {
	    return this.floatPercent;
	};
	PlayWayData.prototype.setBettingLowerLimit = function(bettingLowerLimit) {
	    this.bettingLowerLimit = notNanParseInt(bettingLowerLimit);
	};
	PlayWayData.prototype.getBettingLowerLimit = function() {
	    return this.bettingLowerLimit;
	};
	PlayWayData.prototype.setBettingUpperLimit = function(bettingUpperLimit) {
	    this.bettingUpperLimit = notNanParseInt(bettingUpperLimit);
	};
	PlayWayData.prototype.getBettingUpperLimit = function() {
	    return this.bettingUpperLimit;
	};
	PlayWayData.prototype.setPlayCountLimit = function(playCountLimit) {
	    this.playCountLimit = notNanParseInt(playCountLimit);
	};
	PlayWayData.prototype.getPlayCountLimit = function() {
	    return this.playCountLimit;
	};
	// 是否是固定赔率
	PlayWayData.prototype.isFixedOdds = function() {
	    return this.oddsType == GuessAddHelper.ODDS_TYPE_FIXED;
	};
	// 是否是浮动赔率
	PlayWayData.prototype.isFloatOdds = function() {
	    return this.oddsType == GuessAddHelper.ODDS_TYPE_FLOAT;
	};
	PlayWayData.prototype.getOdds = function() {
	    return this.odds;
	};
	// 添加一个赔率
	PlayWayData.prototype.addOdds = function(param, odds) {
	    this.odds[param] = notNanParseFloat(odds);
	};
	// 删除一个赔率
	PlayWayData.prototype.deleteOdds = function(param) {
	    delete this.odds[param];
	};
	// 需要多少托管财富
	PlayWayData.prototype.needKeepWealth = function() {
	    if(this.isFixedOdds()){
		var highestOdds = this.getTheHighestOdds();
		return highestOdds * this.bettingUpperLimit
			* this.playCountLimit;
	    }
	    return 0;
	};
	// 获取最高的赔率
	PlayWayData.prototype.getTheHighestOdds = function() {
	    var highestOdds = 0;
	    for( var param in this.odds){
		if(this.odds[param] > highestOdds){
		    highestOdds = this.odds[param];
		}
	    }
	    return highestOdds;
	};
	// 数据检查,错误时返回错误消息
	PlayWayData.prototype.dataCheck = function() {
	    if(this.id.isEmpty()){
		return '玩法ID不能为空';
	    }
	    if(this.name.isEmpty()){
		return '玩法名称不能为空';
	    }
	    if(this.isFixedOdds()){
		if(this.bettingUpperLimit < 1){
		    return '投注上限不能小于1';
		}
		if(this.playCountLimit < 1){
		    return '竞猜人数上限不能小于1';
		}
		for( var param in this.odds){
		    if(!this.__isOddsValue(this.odds[param])){
			return '固定赔率中有赔率为空或格式不正确';
		    }
		}
	    }else if(this.isFloatOdds()){
		if(this.bettingLowerLimit > this.bettingUpperLimit){
		    return '投注下限不能大于投注上限';
		}
		if(this.floatPercent > 0.9 || this.floatPercent < 0.7){
		    return '赔率比率不正确';
		}
	    }else{
		return '赔率不正确';
	    }
	};
	//
	PlayWayData.prototype.__isOddsValue = function(odds) {
	    return odds > 0;
	};
	// 格式化也可看懂的字符串
	PlayWayData.prototype.toUseString = function(use) {
	    if(this.isFloatOdds()){
		return '玩法:<span style="color:#ff6600">' + this.name + '</span>/赔率:<span style="color:#ff6600">' + this.getOddsTypeName() + '</span>/浮动比率:<span style="color:#ff6600">' + (this.floatPercent * 100) + '%</span>/投注下限:<span style="color:#ff6600">' + this.bettingLowerLimit + '</span>/投注上限:<span style="color:#ff6600">' + this.bettingUpperLimit + '</span>';
	    }else if(this.isFixedOdds()){
		return '玩法:<span style="color:#ff6600">' + this.name + '</span>/赔率:<span style="color:#ff6600">' + this.getOddsTypeName() + '</span>/投注上限:<span style="color:#ff6600">' + this.bettingUpperLimit + '</span>/竞猜人数上限:<span style="color:#ff6600">' + this.playCountLimit + '</span>';
	    }else{
		return '玩法:' + this.name + '/赔率类型出错';
	    }
	};
	// 格式化也可看懂的字符串
	PlayWayData.prototype.toUnUseString = function(use) {
	   return this.name + '/未使用';
	};
	PlayWayData.prototype.getOddsTypeName = function() {
	    if(this.isFloatOdds()){
		return '浮动赔率';
	    }else if(this.isFixedOdds()){
		return '固定赔率';
	    }else{
		return '赔率类型出错';
	    }
	};
	// 格式化成json字符串
	PlayWayData.prototype.toJsonString = function() {
	    var json = {'id':this.id, 'name':this.name, 'oddsType':this.oddsType};
	    if(this.isFloatOdds()){
		json['floatPercent'] = this.floatPercent;
		json['bettingLowerLimit'] = this.bettingLowerLimit;
		json['bettingUpperLimit'] = this.bettingUpperLimit;
	    }else if(this.isFixedOdds()){
		json['playCountLimit'] = this.playCountLimit;
		json['bettingUpperLimit'] = this.bettingUpperLimit;
		json['odds'] = this.odds;
	    }
	    return JSON.stringify(json);
	};
	PlayWayData.__initialized = true;
    }
}
var GuessAddHelper = {
    // [int]固定赔率类型
    ODDS_TYPE_FIXED : 1,
    // [int]浮动赔率类型
    ODDS_TYPE_FLOAT : 2,
    // [string]投注下限名
    NAME_BETTING_LOWER_LIMIT : 'bll',
    // [string]投注上限名
    NAME_BETTING_UPPER_LIMIT : 'bul',
    // [int]财富类型:金币
    WEATH_TYPE_MONEY : 1,
    // [int] 财富类型:积分
    WEATH_TYPE_INTEGRAL : 2,
    // 财富类型
    wealthType : this.WEATH_TYPE_MONEY,
    // [int]当前用户的金币
    userMoney : 0,
    // [int]当前用户的积分
    userIntegral : 0,
    // [Json]玩法数据
    playWayDatas : {},
    // 重置
    reset : function() {
	this.wealthType = this.WEATH_TYPE_MONEY;
	this.userMoney = 0;
	this.userIntegral = 0;
	this.playWayDatas = {};
    },
    setWealthType : function(wealthType) {
	if(!this.wealthIsEnough(wealthType)){
	    if(wealthType == this.WEATH_TYPE_MONEY){
		alert('你当前的金币不足以支付所有玩法所需的托管金币');
	    }else if(wealthType == this.WEATH_TYPE_INTEGRAL){
		alert('你当前的积分不足以支付所有玩法所需的托管积分');
	    }
	    return false;
	}
	this.wealthType = wealthType;
	return true;
    },
    getWealthType : function() {
	return this.wealthType;
    },
    setUserMoney : function(userMoney) {
	this.userMoney = userMoney;
    },
    getUserMoney : function() {
	return this.userMoney;
    },
    setUserIntegral : function(userIntegral) {
	this.userIntegral = userIntegral;
    },
    getUserIntegral : function() {
	return this.userIntegral;
    },
    // 是否是金币类型财富
    wealthTypeIsMoney : function() {
	return this.wealthType == this.WEATH_TYPE_MONEY;
    },
    // 是否是积分类型财富
    wealthTypeIsIntegral : function() {
	return this.wealthType == this.WEATH_TYPE_INTEGRAL;
    },
    // 添加一个玩法数据
    addPlayWayData : function(playWayData) {
	this.playWayDatas[playWayData.getId()] = playWayData;
    },
    // 删除玩法数据
    deletePlayWayData : function(playWayId) {
	var playWayData = this.playWayDatas[playWayId];
	var playWayDataString = playWayData.toUnUseString();
	$('#play_way_' + playWayData.getId()).html(playWayDataString);
	var playWayInputId = '#play_way_input_' + playWayData.getId();
	var playWayInput = $(playWayInputId);
	playWayInput.remove(); 
	delete this.playWayDatas[playWayId];
	$('#playinfo_'+playWayId).hide(); //隐藏玩法项
    },
    // 剩余的财富是否能支付添加一个玩法
    leaveWealthIsEnough : function(playWayData) {
	var needKeepWealth = playWayData.needKeepWealth();
	if(needKeepWealth == 0)
	    return true;
	var leaveWealth = 0;
	var  oldOeedKeepWealth = 0;
	if(this.playWayDataExists(playWayData)){
	    //已存在这个玩法数据，必须减去
	    var oldPlayWayData = this.playWayDatas[playWayData.getId()];
	    oldOeedKeepWealth = oldPlayWayData.needKeepWealth();
	}
	if(this.wealthTypeIsMoney()){
	    leaveWealth = this.userMoney - this.needKeepWealth() + oldOeedKeepWealth;
	}
	if(this.wealthTypeIsIntegral()){
	    leaveWealth = this.userIntegral - this.needKeepWealth() + oldOeedKeepWealth;
	}
	return leaveWealth >= needKeepWealth;
    },
    // 财富是否足以发布这个竞猜
    wealthIsEnough : function(wealthType) {
	var needKeepWealth = this.needKeepWealth();
	if(typeof (wealthType) != 'undefined'){
	    if(wealthType == this.WEATH_TYPE_MONEY){
		return this.userMoney >= needKeepWealth;
	    }else if(wealthType == this.WEATH_TYPE_INTEGRAL){
		return this.userIntegral >= needKeepWealth;
	    }
	}else{
	    if(this.wealthTypeIsMoney()){
		return this.userMoney >= needKeepWealth;
	    }
	    if(this.wealthTypeIsIntegral()){
		return this.userIntegral >= needKeepWealth;
	    }
	}
	return false;
    },
    // 需要多少托管财富
    needKeepWealth : function() {
	var needKeepWealth = 0;
	var playWayData = null;
	for( var id in this.playWayDatas){
	    playWayData = this.playWayDatas[id];
	    needKeepWealth += playWayData.needKeepWealth();
	}
	return needKeepWealth;
    },
    // 已添加玩法
    hasPlayWayData : function() {
	for( var id in this.playWayDatas){
	    return true;
	}
	return false;
    },
    // 存在指定玩法
    playWayDataExists : function(playWayData) {
	return this.playWayDatas[playWayData.getId()] == null? false:true;
    },
    // 收集玩法信息并添加
    collectPlayWayDataAndAdd:function(){
	var playWayData = new PlayWayData();
	var playWayForm = $('#playWayForm');
	playWayData.setId(getFormValue(playWayForm, 'id'));
	playWayData.setName(getFormValue(playWayForm, 'name'));
	playWayData.setOddsType(getFormValue(playWayForm, 'oddsType'));
	if(playWayData.isFixedOdds()){
	    playWayData.setBettingUpperLimit(getFormValue(playWayForm, 'fixedBettingUpperLimit'));
	    playWayData.setPlayCountLimit(getFormValue(playWayForm, 'playCountLimit'));
	    var oddsInputs = $('.odds');
	    oddsInputs.each(function(index, oddsInput){
		oddsInput = $(oddsInput);
		playWayData.addOdds(oddsInput.attr('name'), oddsInput.val());
	    });
	}else if(playWayData.isFloatOdds()){
	   playWayData.setFloatPercent(getFormValue(playWayForm, 'floatPercent'));
	   playWayData.setBettingUpperLimit(getFormValue(playWayForm, 'floatBettingUpperLimit'));
	   playWayData.setBettingLowerLimit(getFormValue(playWayForm, 'floatBettingLowerLimit'));
	}else{
	    this.showMessage('赔率类型不正确');
	    return ;
	}
	$error = playWayData.dataCheck();
	if($error){
	    this.showMessage($error);
	    return;
	}
	if(!this.leaveWealthIsEnough(playWayData)){
	    this.showMessage('你的积分或金币不够，请根据公式调整参数');
	    return;
	}
	this.addPlayWayData(playWayData);
	var playWayDataString = playWayData.toUseString();
	$('#play_way_' + playWayData.getId()).html(playWayDataString);
	var playWayDataJsonString = playWayData.toJsonString();
	var playWayInputId = 'play_way_input_' + playWayData.getId();
	var playWayInput = $('#'+playWayInputId);
	if(playWayInput[0]){
	    // 存在，修改
	    playWayInput.val(playWayDataJsonString);
	}else{
	    // 创建
	    playWayInput = "<input type='hidden' name='playWayDatas[]' value='" + playWayDataJsonString + "' id='" + playWayInputId + "' />";
	    $('#playWays').append(playWayInput);
		$('#playinfo_'+playWayData.getId()).show(); //显示玩法项
	}
	hideMenu();
    },
    // 重置玩法信息
    resetPlayWayData:function(playWayId){
	var playWayData = this.playWayDatas[playWayId];
	if(playWayData){
	    if(playWayData.isFloatOdds()){
		$("#floatPercent").find("option[value='" + playWayData.getFloatPercent() + "']").attr('selected', 'selected');
//		$('#floatPercent_' + playWayData.getFloatPercent()).attr('selected', 'selected');
		$('#floatBettingUpperLimit').val(playWayData.getBettingUpperLimit());
		$('#floatBettingLowerLimit').val(playWayData.getBettingLowerLimit());
	    }else if(playWayData.isFixedOdds()){
		$('#fixedBettingUpperLimit').val(playWayData.getBettingUpperLimit());
		$('#playCountLimit').val(playWayData.getPlayCountLimit());
		oddses = playWayData.getOdds();
		for( var param in oddses){
		    $('#odds_'+param).val(oddses[param]);
		}
	    }
	    $('#oddsType_'+playWayData.getOddsType()).click();
	}
    },
    showMessage:function(message){
	$('#error').html(message);
    }
};
