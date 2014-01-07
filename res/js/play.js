function PlayData() {
    // [int]玩法ID
    this.id = '';
    // [string]玩法名称
    this.name = '';
    // 竞猜值
    this.value = '';
    // 竞猜值说明
    this.valueText = '';
    // 投注数
    this.wealth = 0;
    //财富名称
    this.wealthName = '';
    //
    this.reviewTemplate = '<tr id="play_review_{playWayId}"><td class="arrow">{playWayName}</td><td>{valueText}</td><td><span>{wealth}</span>{wealthName}</td><td><a href="javascript:;" onclick="GuessPlayHelper.editPlay(\'{playWayId}\')" >修改</a>&nbsp;<a href="javascript:;" onclick="GuessPlayHelper.deletePlay(\'{playWayId}\')" >删除</a></td></tr>';
    
    if(typeof PlayData.__initialized == "undefined"){
	//
	PlayData.prototype.setId = function(id) {
	    this.id = id;
	};
	PlayData.prototype.getId = function() {
	    return this.id;
	};
	PlayData.prototype.setName = function(name) {
	    this.name = name;
	};
	PlayData.prototype.getName = function() {
	    return this.name;
	};
	PlayData.prototype.setValue = function(value) {
	    this.value = value;
	};
	PlayData.prototype.getValue = function() {
	    return this.value;
	};
	PlayData.prototype.setValueText = function(valueText) {
	    this.valueText = valueText;
	};
	PlayData.prototype.getValueText = function() {
	    return this.valueText;
	};
	PlayData.prototype.setWealth = function(wealth) {
	    this.wealth = wealth;
	};
	PlayData.prototype.getWealth = function() {
	    return this.wealth;
	};
	// 格式化成简单字符串
	PlayData.prototype.toSimpleString = function() {
	    if(this.isPlay()){
		return this.valueText + '/' + this.wealth;
	    }else{
		return '未投注';
	    }
	};
	// 格式化成详细字符串
	PlayData.prototype.toReviewString = function() {
	    var review = this.reviewTemplate.replaceAll('{playWayId}', this.id);
	    review = review.replaceAll('{playWayName}', this.name);
	    review = review.replaceAll('{wealth}', this.wealth);
	    review = review.replaceAll('{wealthName}', this.wealthName);
	    review = review.replaceAll('{valueText}', this.valueText);
	    return review;
	};
	//是否已正确投注
	PlayData.prototype.isPlay = function() {
	    if(typeof(this.wealth) == 'undefined' || typeof(this.value) == 'undefined') return false;
	    return this.wealth > 0 && !this.value.isEmpty();
	};
	
	PlayData.__initialized = true;
    }
}
var GuessPlayHelper = {
    // [Json]玩法数据
    playDatas : {},
    // 添加一个玩法数据
    addPlayData : function(playData) {
	this.playDatas[playData.getId()] = playData;
    },
    // 删除玩法数据
    deletePlayData : function(playWayId) {
	var playData = this.playDatas[playWayId];
	var playDataString = playData.toUnUseString();
	$('#play_way_' + playData.getId()).html(playDataString);
	var playWayInputId = '#play_way_input_' + playData.getId();
	var playWayInput = $(playWayInputId);
	playWayInput.remove();
	delete this.playDatas[playWayId];
    },
    // 已添加玩法
    hasPlayData : function() {
	for( var id in this.playDatas){
	    return true;
	}
	return false;
    },
    // 存在指定玩法
    playDataExists : function(playData) {
	return this.playDatas[playData.getId()] == null ? false : true;
    },
    togglePlayBox : function(playWayId) {
	var playBox = $('#play_box_' + playWayId);
	if(playBox.css('display') == 'block'){
	    playBox.slideUp();
	    $('#play_menu_' + playWayId).html($('#play_menu_' + playWayId).attr('menu_name'));
	}else{
	    playBox.slideDown();
	    $('#play_menu_' + playWayId).attr('menu_name',$('#play_menu_' + playWayId).html());
	    $('#play_menu_' + playWayId).html('收起');
	}
    },
    checkWealth : function(playWayId) {
	var playWealthInput = $('#play_wealth_' + playWayId);
	var playWealth = notNanParseInt(playWealthInput.val());
	var max = notNanParseInt(playWealthInput.attr('max'));
	if(playWealth <= 0){
	    playWealth = 0;
	    playWealthInput.val(playWealth);
	}else if(max && playWealth > max){
	    playWealth = max;
	    playWealthInput.val(playWealth);
	}
	var oddsTip = $('#play_wealth_tip_' + playWayId);
	var oods = oddsTip.attr('odds');
	oddsTip.html(oods * playWealth);
    },
    addPlay : function(playWayId) {
	$('#play_box_' + playWayId).hide();
	$('#play_menu_' + playWayId).html($('#play_menu_' + playWayId).attr('menu_name'));
	var playData = this.playDatas[playWayId];
	if(!playData) return;
	playData.setValue($('#play_value_' + playWayId).val());
	playData.setWealth(notNanParseInt($('#play_wealth_' + playWayId).val()));
	if(!playData.isPlay()){
	    // 删除总计部分
	    this.deletePlay(playWayId);
	    $('#play_box_' + playWayId).hide();
	    $('#play_menu_' + playWayId).html($('#play_menu_' + playWayId).attr('menu_name'));
	}else{
	    playData.setValueText($('#play_value_' + playWayId).find("option[value='" + playData.getValue() + "']").text());
	    this.addPlayData(playData);
	    //添加或替换总计
	    var playReviews = $('#play_reviews');
	    var oldPlayReview = playReviews.find("#play_review_"+playWayId);
	    if(oldPlayReview[0]){
		oldPlayReview.replaceWith(playData.toReviewString());
	    }else{
		playReviews.append(playData.toReviewString());
	    }
	}
	$('#play_tip_'+playWayId).html(playData.toSimpleString());
	$('#total_wealth').html(this.totalWealth());
	
    },
    editPlay : function(playWayId) {
	$.scrollTo('#play_list_' + playWayId, 800, {
	    queue : true,
	    onAfter : function() {
		setTimeout(function() {
		    $('#play_menu_' + playWayId).click();
		}, 200);
	    }
	});
    },
    deletePlay : function(playWayId) {
	$('#play_wealth_' + playWayId).val(0);
	$('#play_value_' + playWayId).val('');
	$('#play_review_' + playWayId).remove();
	$('#play_tip_'+playWayId).html('未投注');
    },
    totalWealth : function() {
	var totalWealth = 0;
	for(var key in this.playDatas){
	    if(this.playDatas[key].isPlay()){
		totalWealth += this.playDatas[key].getWealth();
	    }
	}
	return totalWealth;
    }
}

