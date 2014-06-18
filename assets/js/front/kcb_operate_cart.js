var tools = new tool();
var params = {};
var kcbinfo;

//留言验证码
function checkValidCode() {
    var flag = 0;
    var result = "";
    var validateCode = $.trim($("#txtValidateCode").val());
    var content = $.trim($("#txtMessageContent").val());
    if (content == null || content == "") {
        $(".validRs").html("留言不能为空");
        return false;
    }
    result = tools.checkValidateCode(validateCode, 500, 0);
    if (result == "1") {
        $(".validRs").html("");
        return true;
    }
    else {
        $(".validRs").html(result);
        return false;
    }
}

//获取购物车信息，加载t.aspx和s.aspx页时调用
function getCartInfo() {

    //取出餐厅的营业状态。判断是要显示“查看电话”或“去下单”按钮
    var supBuessineState = Number($("#businessState").val()), //显示餐厅状态提醒
        supBuessineMode = Number($("#businessMode").val());  //电话订餐餐厅提醒

    switch (supBuessineMode) {  //BusinessModel餐厅的营业模式1为在线订餐。3为电话订餐
        case 1:
            if (supBuessineState == 1) {//Businessstate餐厅的营业状态1为营业中
                //$("#emptyOrder").show();
                $("#seeNum").hide();
                $("#ComfirmOrder").show();
                //$("#OrderFoot").show();
            }
            break;
        case 3:
            //$("#emptyOrder").show();
            $("#seeNum").show();
            $("#ComfirmOrder").hide();
            //$("#createOrder").show();
            $("#OrderFoot").show();
            break;
    }

    $("#emptyOrder").show();
    $("#OrderFoot").show();
    $("#OrderBody").empty();
    $("#phoneNum").hide();
    //若没菜品，则隐藏在线订单,并清空餐厅信息

    var FoodList = new Array(); //存放菜品的数组
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')'); //取得购物车cookie
    if (!tools.IsEmpty(kcbCarInFo)) {//判断购物车是否为空
        FoodList = kcbCarInFo.FoodInfos; //不是则取出购物车中的菜品列表
    }

    if (FoodList.length == 0) {//菜品数量为0
        $("#onlineOrder").hide();    //美食筐最外部div隐藏
        $("#tbbasket").hide();    //美食筐表格隐藏
        $("#no_send").show();     //提示框显示
        $("#no_send_inner").html("美食筐是空的！");  //填充提示框内容
        $.cookie("cartSupInfo", "");
        //隐藏有另外餐厅菜品的提示
        if ($("#attentionInfo .other").is(":visible")) {
            $("#attentionInfo .other").hide();
        }
    }
    else {//菜品数量不为0

        $("#tbbasket").show();
        $("#no_send").hide();
        var sendPrice = kcbCarInFo.SendPrice; //获得餐厅的起送价

        //结束餐厅初始化
        var totalPrice = parseFloat(kcbCarInFo.totalPrice);
        for (var i = 0; i < FoodList.length; i++) {
            //菜品列表中已点过的美食改变样式
            var foodName = FoodList[i].foodName.length > 10 ? FoodList[i].foodName.substring(0, 10) + '...' : FoodList[i].foodName; //名称
            $("#left #liFood_" + FoodList[i].foodID + " .addToOrder").addClass("addMore");
            var foodStr = '<tr  food-id=' + FoodList[i].foodID + '><td><p class="food_name">' + foodName + '</p></td><td><div class="order_num">   <a class="minus">&nbsp;</a>   <span>' + FoodList[i].number + '</span><a class="add">&nbsp;</a> </div></td><td>' + FoodList[i].foodprice + '</td><td><a class="del">删除</a></td></tr>';
            $("#OrderBody").append(foodStr);

        }
        // orderSupName.siblings(".order_price").text(totalPrice); //总价

        $.cookie("totalPrice", totalPrice, {
            path: "/",
            expires: 43200
        });  //把总价存入cookie
        //如果总价大于起送价，并且未达到起送价提示存在，则让未达到起送价提示消失
        if (totalPrice >= sendPrice) {
            $("#no_send").hide();
        }

        //如果餐厅如果收取送餐费，且满足收取要求
        var deliveryType = $("#deliveryFeeType").val();
        var deliveryFee = $("#deliveryFee").val();
        var freeDeliveryFeePrice = $("#freeDeliveryFeePrice").val();
       
        if (deliveryType != 0) {
            $("#delivery").show();
            if (deliveryType == 2) {
                $("#delivery .food_name").html("额外收取配送费" + parseFloat(deliveryFee) + "元（订单满" + parseFloat(freeDeliveryFeePrice) + "元免配送费）");
            }
            if (deliveryType == 1) {
                $("#delivery .food_name").html("额外收取配送费" + parseFloat(deliveryFee) + "元");
            }
            $("#delivery .food_deliveryFee").html("￥" + parseFloat(deliveryFee));

        } else {
            $("#delivery").hide();
        }

        $("#totalPrice").html(totalPrice);

        //初始化菜品结束，使美食筐滑出
        $("#onlineOrder").slideDown(200);

    }
}
//购物车
//cookie操作
//关键
//插入订单
function insertIntoCart(foodID, foodName, foodPrice, supName, supID, businessstate, businessmode, sendPrice, activityState) {

    //初始化购物车
    if (tools.IsEmpty($.cookie("KcbCarInfo"))) {
        kcbinfo = new KcbCarInfo();
        kcbinfo.SupID = supID;
        kcbinfo.SupName = supName;
        kcbinfo.Businessstate = businessstate;
        kcbinfo.BusinessModel = businessmode;
        kcbinfo.SendPrice = sendPrice;
        kcbinfo.FoodInfos = new Array();
        kcbinfo.DeliveryType = $("#deliveryFeeType").val();
        kcbinfo.DeliveryFee = $("#deliveryFee").val();
        kcbinfo.FreeDeliveryFeePrice = $("#freeDeliveryFeePrice").val();
        kcbinfo.RefreshCookie(); //刷新购物车cookie
    }
    //构造菜品对象
    var food = new FoodInfo();
    food.foodID = foodID;
    food.foodName = foodName;
    food.number = 1;
    food.foodprice = foodPrice;
    food.activityState = activityState;
    ExistsFood(food); //判断菜品是否存在，存在数量增加数量，不存在新增
}
//隐藏清空订单浮层
function hideshade() {
    $("#shadeSup,.clear_cart").hide();
}
//显示清空订单浮层
function showshade() {
    $("#shadeSup,.clear_cart").show();
}
//检查cookie中是否已经有了该餐厅菜品
function checkIsTheSameSup(supID) {

    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    if (kcbCarInFo == null) {//购物车cookie为空
        return 1;
    }
    FoodList = kcbCarInFo.FoodInfos;
    if (FoodList.length > 0) {//购物车存在菜品
        var oldSupID = kcbCarInFo.SupID;
        if (Number(oldSupID) == Number(supID)) {//购物车里的餐厅ID和当前餐厅id一样，同一家餐厅
            return 1; //是相同的
        }
        return 0;
    }
    return 1;
}
//增加或减少菜品数量
function updateQantity(j, foodID) {
    //j=1代表减少数量，其余代表增加数量

    var FoodList = new Array();
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    if (!tools.IsEmpty(kcbCarInFo)) {//购物车cookie不为空
        FoodList = kcbCarInFo.FoodInfos; //获得购物车的菜品列表
    }
    var food = new FoodInfo();
    food.foodID = foodID;
    if (j == 1) {//是1代表减少
        subFood(food); //调用减少熟练的方法
    }
    else {
        addFood(food); //增加数量方法
    }
    $("#liFood_" + foodID + " .addToOrder").removeClass().addClass("addToOrder"); //更换按钮背景
    getCartInfo(); //刷新购物车视图
}


//删除某菜品[更新订单]
function removeFood(foodID) {
    var food = new FoodInfo();
    food.foodID = foodID;
    DelFood(food);
    getCartInfo(); //刷新购物车视图
}
//删除某菜品[不更新订单]//这个方法用在电话餐厅。点击查看电话按钮后，清掉Cookie。但是购物车视图上的菜品信息不能清掉。因为用户打电话后还得向餐厅订刚才所点的菜品（暂时还没修改，等确定电话订餐机制后在改）
function nRemoveFood() {//獨立出一個方法，坑能以後有擴展
    $.cookie("KcbCarInfo", null, {
        path: "/",
        expires: 43200
    });
}

var flyFlag = 0; //作用：限制用户在特价页快速点击2个不同餐厅的菜品,一共8处使用flyFlag=0

//点餐调用方法
function selectFood($obj) {
    //取得数据
    var $select = $obj.parents(".foodListItem");
    var foodID = $select.attr("food-foodid"),
        foodName = $select.attr("food-foodname"),
        foodPrice = $select.attr("food-price"),
        supName = $select.attr("food-supname"),
        supID = $select.attr("food-supid"),
        businessstate = $select.attr("food-businessState"),
        activityState = $select.attr("food-activityState"),
        sendPrice = $select.attr("food-supSendPrice"),
        businessmode = $select.attr("food-businessmode");
    //        deliveryType = $("#deliveryFeeType").val(),
    //        deliveryFee = $("#deliveryFee").val(),
    //        freeDeliveryFeePrice = $("#freeDeliveryFeePrice").val();

    if (flyFlag != 0) {
        return;
    }
    flyFlag = 1;   //标识不为0，表示有订单正在插入，不能马上插入其它订单

    //判断是否是不同餐厅菜品,不同==0
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    if (kcbCarInFo != null && kcbCarInFo != "") {
        if (checkIsTheSameSup(supID) == 0) {
            if ($(".tf").length > 0) {  //特价页显示单独提示样式.特价页（便宜吧）现在已经没有购物车了
            }
            else {
                hideshade(); //隐藏情况菜品浮层提醒
                $(".clear_cart .cart_food_from").html("美食筐中包含来自[<em>" + kcbCarInFo.SupName + "</em>]餐厅的美食");
            }
            flyFlag = 0;
            return;
        };
    }
    //根据餐厅状态判断
    if (Number(businessstate) == 1 || Number(businessmode) == 3) {
        if (Number(businessmode) == 2) {
            $(".attentiono.call").show();
        }
        if (Number($select.attr("food-foodstate")) == 1) {

            $.XYTipsWindow({
                ___title: "开吃吧提示",
                ___drag: "___boxTitle",
                ___width: "300px",
                ___height: "100px",
                ___content: "text:<p style=\"color:#555;text-align: center;margin-top:40px;font-size:16px;font-weight:bold;\">真遗憾，" + foodName + "刚卖完</p>",
                ___showbg: true,
                ___time: 1800
            });
            flyFlag = 0;
            return;
        }

        var uniID;
        if ($.cookie("uniID") != null && $.cookie("uniID") != "") {
            uniID = $.cookie("uniID");
        } else {
            scroll(0, 0);
            $(".attention.location").show();
            flyFlag = 0;
            return;
        }

        $.ajax({
            type: "POST",
            url: "/ajax/Supplier/CheckSupIDByUniID.ashx",
            data: { supID: supID, uniID: uniID },
            success: function (data) {
                if (data == "1") {

                    /*********************点餐动态飞单效果***************************/
                    var b = $obj.offset(),
    			        g = $("#basketshow").offset();
                    //g.top += $("#onlineOrder").height() / 2;
                    var flyEffectTxt = $('<div class="flyEffect">' + foodPrice + "</div>");
                    flyEffectTxt.offset(b);
                    flyEffectTxt.appendTo("body").animate(
                            {
                                left: g.left + "px",
                                top: g.top + "px",
                                opacity: 1
                            },
    			            function () {
    			                $(this).animate({ opacity: 0 },
    			                function () {
    			                    $(this).remove();

    			                    //飞单效果结束，插入订单		
    			                    insertIntoCart(foodID, foodName, foodPrice, supName, supID, businessstate, businessmode, sendPrice, activityState);
    			                    $("#liFood_" + foodID + " .addToOrder").addClass("addMore"); //显示再来一份按钮

    			                    getCartInfo();
    			                    flyFlag = 0;
    			                })
    			            }
    			          );
                    /*********************结束点餐动态飞单效果***************************/

                } else {
                    scroll(0, 0);
                    $(".attention.warn").show();
                    flyFlag = 0;
                    return;
                }
            }
        });
        /**************验证下单餐厅是否送到当前大学 end**********************/
    }
    else {
        switch (Number(businessstate)) {
            case 0:
                scroll(0, 0);
                $(".attention.rest").slideDown(1000);
                flyFlag = 0;
                break;
            case 3:
                scroll(0, 0);
                $("#attentionInfo .busy").show();
                flyFlag = 0;
                break;
            case 4:
                scroll(0, 0);
                $("#attentionInfo .vacation").show();
                flyFlag = 0;
                break;
        }
        if (flyFlag == 0) {
            hideshade(); //隐藏情况菜品浮层提醒
        }
    }
}

//清空订单
function emptyOrder() {
    if ($("#phoneNum").is(":visible")) getCartInfo(); //如果显示了电话再点清空，则清空订单
    if ($.cookie("KcbCarInfo") == null || $.cookie("KcbCarInfo") == "") {
        return;
    }
    $.cookie("KcbCarInfo", null, {
        path: "/",
        expires: 43200
    });
    $(".foodListItem .addToOrder").removeClass().addClass("addToOrder"); //恢复按钮
    $("#no_send").hide(); //删除餐厅起送价
    $(".attention,.trat_arrow").hide();  //隐藏提示

    getCartInfo();
}

//减少菜品数量调用方法
function lessNum($obj) {
    var foodID = $obj.parent().attr("food-foodid");
    updateQantity(1, foodID);
}

//浮点数加法运算  可调用common.js的方法（在这个js没用到。确认其他js用了没）
function floatAdd(arg1, arg2) {
    var r1, r2, m;
    try { r1 = arg1.toString().split(".")[1].length } catch (e) { r1 = 0 }
    try { r2 = arg2.toString().split(".")[1].length } catch (e) { r2 = 0 }
    m = Math.pow(10, Math.max(r1, r2));
    return (arg1 * m + arg2 * m) / m;
}

//浮点数乘法运算  （在这个js没用到。确认其他js用了没）
function floatMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try { m += s1.split(".")[1].length } catch (e) { }
    try { m += s2.split(".")[1].length } catch (e) { }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

//固定订单
function fixOrder(order) {
    var shopIntroHeight = $("#shopOverall").height();
    var istotopshow = 0;
    var isfoodcartshow = 0;
    var isfoodMenuShow = 0;
    var istipsNumbersShow = 0; //控制tipsNumbers只获取一次,以解决ie7下滑动性能问题
    var topScroll = "",
        toTop_Top = "";
    var tipsNumbers = 0;

    //alert(shopIntroHeight );
    //获取顶部显示的提示数目
    $(window).scroll(function () {
        //tipsNumbers = $(".attention:visible").length;
        topScroll = $(window).scrollTop(); //从浏览器顶部距离开始滚动的距离
        if (istipsNumbersShow == 0) {
            tipsNumbers = $(".attention:visible").length;
            istipsNumbersShow = 1;
        }

        //160为header高度和其它边距
        //固定购物车
        /*
        if (topScroll > (150 + shopIntroHeight + tipsNumbers * 42)) {
        if (isfoodcartshow == 1) {
        }
        else {
        $("#onlineOrder").css({  //固定在线订单
        "position": "fixed",
        "top": "0px",
        "margin-top": "0px",
        "left": order.offset().left + "px"
        });
        isfoodcartshow = 1;
        }

        }
        else if (isfoodcartshow == 1) {//解除固定
        $("#onlineOrder").css({
        "position": "relative",
        "margin-top": "0",
        "top": "",
        "left": ""
        });
        isfoodcartshow = 0;
        }
        */

        //215=160为header高度和其它边距+55为tab的高度和菜单分类上边距
        //固定菜品类别
        if ($("#menuCategory").length > 0) {
            if (isfoodMenuShow == 0 && topScroll > (215 + shopIntroHeight + tipsNumbers * 42)) {
                $("#menuCategory").css({
                    "position": "fixed",
                    "top": "0px",
                    "margin-top": "0",
                    "border-bottom": "1px solid #ddd",
                    "z-index": "11"
                });
                isfoodMenuShow = 1;
            }
            else if (isfoodMenuShow == 1 && topScroll <= (215 + shopIntroHeight + tipsNumbers * 42)) {//解除固定
                $("#menuCategory").css({
                    "position": "static",
                    "top": "",
                    "left": "",
                    "margin-top": "10px",
                    "border-bottom": "none"
                });
                isfoodMenuShow = 0;
            }
        }


        //固定回顶部
        if ($(".to-top").length > 0) {
            if (istotopshow == 0 && topScroll > 150) {
                $(".to-top").css("display", "block");
                istotopshow = 1;
            }
            else if (istotopshow == 1 && topScroll <= 150) {
                $(".to-top").css("display", "none");
                istotopshow = 0;
            }
        }
    });
}


$(document).ready(function () {

    // 固定在线订单
    if ($("#onlineOrder").length > 0) {
        fixOrder($("#onlineOrder"));
    }

    //从搜索页面或者热门菜品跳转过来
    var searchFoodId = $.cookie("searchFoodId"); //取到搜索得到的菜品id
    try {
        if (searchFoodId != null && searchFoodId != "") {
            $.cookie("KcbCarInfo", null, {
                path: "/",
                expires: -1
            });
            var _this = $("#liFood_" + searchFoodId + " .addToOrder"), //得到点餐按钮元素
                browserHeight = document.body.clientHeight,
                currentLiTop = $("#liFood_" + searchFoodId).offset().top; //获取选中元素距离页面顶部高度
            //调用scroll()函数页面滚动到选择菜品处
            scroll(0, currentLiTop - browserHeight / 2);
            if (!$("#liFood_" + searchFoodId + " .price_outer").next().hasClass("saleup")) {

                //延时把搜索页面所选的菜品加入订单 
                setTimeout(function () { selectFood(_this); }, 1000);
            }
        }
    }
    catch (e) {
    }
    $.cookie("searchFoodId", "", {
        path: "/",
        expires: 1
    }); //清除cookie
    var supDetail = "";

    //显示大学名称
    var uniName = $.cookie("uniName");
    if (uniName != null && uniName != "") {
        $("#uniName").html(uniName + "&nbsp/&nbsp");
    }

    $("#uniName").css("cursor", "pointer").bind("click", function () {
        if ($.cookie("uniID") == null) {
            window.location.href = "http://kaichiba.com/index.aspx";
            return;
        }
        window.location = "http://kaichiba.com/area/" + $.cookie("uniID");
    });

    //显示评价详情
    $("#detail").click(function () {
        $(this).hide();
        $(".satis").css("float", "left");
        $("#detail_table").slideDown("fast");
    });

    //隐藏评价详情
    $("#hide_detail").click(function () {
        $("#detail_table").slideUp("fast");
        $("#detail").show();
    });

    //显示餐厅介绍
    $("#supIntrodetail").live('click', function () {
        $(this).parent().hide();
        $("#supIntroDetail").show();
    });
    //隐藏餐厅介绍
    $("#hide_supIntrodetail").live('click', function () {
        $("#supIntroDetail").hide();
        $(".send_price").next("p").show();
        //        $("#supIntro").html(supDetail);
    });

    //刷新验证码
    $("#.make_msg .chk_code span").click(function () {
        $("#authenticationCode_foodCorrect").click();
    });

    //美食筐左下角的购物车图标点击事件
    $("#basketshow").click(function () {
        $("#onlineOrder").slideToggle(200);
    })

    var businessState = Number($("#businessState").val()), //显示餐厅状态提醒
        businessMode = Number($("#businessMode").val()), //电话订餐餐厅提醒
        supID = Number($("#supID").val()),
        uniName = $.cookie("uniName");



    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    if (kcbCarInFo != null && kcbCarInFo != "") {
        //有其他餐厅的菜品
        if ($("#supID").val() != kcbCarInFo.SupID) {
            showshade();
            $(".clear_cart .cart_food_from").html("美食筐中包含来自[<em>" + kcbCarInFo.SupName + "</em>]餐厅的美食");
        }
    }
    //显示电话订餐餐厅提醒
    if (businessMode == 3) {
        var uniID;
        if ($.cookie("uniID") != null && $.cookie("uniID") != "") {
            uniID = $.cookie("uniID");
            $.ajax({
                type: "POST",
                url: "/ajax/Supplier/CheckSupIDByUniID.ashx",
                data: { supID: supID, uniID: uniID },
                success: function (data) {
                    if (data != "1") {
                        scroll(0, 0);
                        $(".warn").show();
                    }
                    else {
                        $(".call").show();
                    }
                }
            });
        } else {
            scroll(0, 0);
            $(".location").show();
        }
    }
    else {
        //显示餐厅状态提醒（如：休假、忙、打烊等）
        switch (businessState) {
            case 0:
                //$(".attention.rest").slideDown();
                $(".rest").animate(300, function () {
                    $(this).slideDown();
                });
                hideshade()
                break;
            case 1:
                var uniID;
                if ($.cookie("uniID") != null && $.cookie("uniID") != "") {
                    uniID = $.cookie("uniID");
                    $.ajax({
                        type: "POST",
                        url: "/ajax/Supplier/CheckSupIDByUniID.ashx",
                        data: { supID: supID, uniID: uniID },
                        success: function (data) {
                            if (data != "1") {
                                scroll(0, 0);
                                $(".warn").show();
                            }
                        }
                    });
                } else {
                    scroll(0, 0);
                    $(".location").show();
                }
                break;
            case 3:
                $(".busy").show();
                hideshade(); //隐藏情况菜品浮层提醒
                break;
            case 4:
                $(".vacation").show();
                hideshade(); //隐藏情况菜品浮层提醒
                break;
        }
    }
    getCartInfo();

    //显示餐厅说明
    $("#shopOverall .tips").hover(
    function () {
        $(".arrow_top,.intro").css("display", "block");
        $(".arrow_top").css({ "left": $(this).position().left + "px" });
        $(".intro").css({ "left": $(this).position().left - 110 + "px" });
    },
    function () {
        $(".arrow_top,.intro").css("display", "none");
    });

    //绑定增减菜品数量功能
    $('.order_num .add').live('click', function () {
        var foodID = $(this).parent().parent().parent().attr("food-id");
        updateQantity(0, foodID);
    });

    $('.order_num .minus').live('click', function () {
        var foodID = $(this).parent().parent().parent().attr("food-id");
        updateQantity(1, foodID);
    });

    //删除菜品
    $(".del").live('click', function () {
        var foodID = $(this).parent().parent().attr("food-id");
        removeFood(foodID);
        $("#liFood_" + foodID + " .addToOrder").removeClass().addClass("addToOrder");
    });

    //显示已售完按钮
    $("li.saleup").css("width", "73px");
    $('li.saleup a').remove();
    $("li.saleup").removeClass("saleup").append("<span class='saleup'>已售完</span>");

    $("#left").click(function (e) {
        var $triggerFood = $(e.target); //获取触发事件来自哪个菜品
        for (k = 0; k < 10; $triggerFood = $triggerFood.parent()) {
            if ($triggerFood.hasClass("addToOrder")) {//点餐

                selectFood($triggerFood);
                break;
            } else {
                break;
            }
            if ($triggerFood.hasClass("main")) {//点击其他地方 
                break;
            }
        }
    });

    var FoodList = new Array(); //存放菜品的数组
    var KcbcarInfo = eval('(' + $.cookie("KcbCarInfo") + ')'); //取得购物车cookie
    if (KcbcarInfo == null) {//判断购物车是否为空
        getCartInfo();
        KcbcarInfo = new KcbCarInfo();
    }
    else {
        FoodList = KcbcarInfo.FoodInfos;
    }


    //在线订餐转到创建订单页面
    $("#createOrder #ComfirmOrder").click(function () {
        KcbcarInfo = eval('(' + $.cookie("KcbCarInfo") + ')'); //取得购物车cookie

        if (typeof (KcbcarInfo) == "undefined" || KcbcarInfo == null) {//判断购物车是否为空
            //getCartInfo();
            //KcbcarInfo = new KcbCarInfo();
            $("#onlineOrder").slideDown(200);
            $("#no_send").show();
            $("#tbbasket").hide();
            $("#no_send_inner").html("美食筐是空的！");
            return;
        }

        var orderPrice = $(".order_price").html(),
        sendPrice = KcbcarInfo.SendPrice,
        supID = KcbcarInfo.SupID,
        supName = KcbcarInfo.SupName;

        //订单未到起送价
        if (parseFloat(sendPrice) > parseFloat(orderPrice)) {
            $("#no_send").show();
            $("#no_send_inner").html("抱歉，该餐厅订单满" + sendPrice + "元起送");
            return;
        }
        else {
            $("#no_send").hide();
        }

        location.href = "/order/checkout";
    });

    //查看电话
    $("#createOrder #seeNum").click(function () {

        if (!$("#phoneNum").is(":hidden")) { return; }

        KcbcarInfo = eval('(' + $.cookie("KcbCarInfo") + ')'); //取得购物车cookie

        if (typeof (KcbcarInfo) == "undefined" || KcbcarInfo == null) {//判断购物车是否为空
            //getCartInfo();
            //KcbcarInfo = new KcbCarInfo();
            $("#onlineOrder").slideDown(200);
            $("#no_send").show();
            $("#tbbasket").hide();
            $("#no_send_inner").html("美食筐是空的！");
            return;
        }

        var $context = $(this);
        $.ajax({
            type: "POST",
            url: "/ajax/Order/SeeNum.ashx",
            beforeSend: function () {
                $context.val("载入中..");
            },
            success: function (data) {
                $context.val("查看电话");
                if (data == "0") {//没点餐
                    $.XYTipsWindow({
                        ___title: "开吃吧提示",
                        ___drag: "___boxTitle",
                        ___width: "300px",
                        ___height: "100px",
                        ___content: "text:<p style=\"color:#555;text-align: center;margin-top:40px;font-size:16px;font-weight:bold;\">还没点餐呢</p>",
                        ___showbg: true,
                        ___time: 1800
                    });
                    return false;
                } else if (data == "1") {
                    //未登录，弹出登录框
                    $.cookie('seenum', '1', { expires: 7 });
                    $(".minLoginBg,.minLogReg").css("display", "block");
                    return false;
                } else if (data == "3") {

                    $.XYTipsWindow({
                        ___title: "开吃吧提示",
                        ___drag: "___boxTitle",
                        ___width: "300px",
                        ___height: "100px",
                        ___content: "text:<p style=\"color:#555;text-align: center;margin-top:40px;font-size:16px;font-weight:bold;\">菜品信息非法，请重新点餐</p>",
                        ___showbg: true,
                        ___time: 1800
                    });
                    return false;
                } else {    //成功
                    if (data != undefined) {
                        data = $.parseJSON(data);
                        $("#phoneNum").show();
                        $("#phoneNum .phone_num").html(data.ReservationCall);
                        $("#phoneNum .alternate_phone").html(data.AlternateCall);
                        $("#phoneNum .thrid_phone").html(data.ThirdCall);
                    }
                    $("#phoneNum").slideDown();
                    //$("#seeNum").hide();
                    //$("#emptyOrder").hide(); //隐藏清空按钮           
                    $(".addToOrder").removeClass("addMore");
                }

                nRemoveFood(); //清楚菜品餐不跟心購物車視圖。因為用戶還需打電話訂餐                
                $(".order_num .add,.order_num .minus").remove();
                $.cookie("cartFoodInfo", ""); //清空菜品信息和餐厅信息
                $.cookie("cartSupInfo", "");
                $(".del").remove(); //去除增减数量
            }
        });
        return false;
    });

    //清空订单
    $("#emptyOrder").click(function () {
        emptyOrder();
    });
    //清空美食筐
    $(".do_clear").live("click", function () {
        emptyOrder();
        hideshade();
    });
    //不清空美食筐
    $(".do_not_clear").live("click", function () {
        $('.clear_cart,.shade').hide();
    });


    //菜单纠错
    $("#menuCorrection").bind("click", function () {
        $("#authenticationCode_foodCorrect").click();
        var supName = $("#supplierName_H .name").text();
        $("#corTextarea textarea").val("如：价格有误、地址不准确或该店已关闭等等").css("color", "#bbb");
        $("#userMail input").val("请输入您的邮箱，以便我们能够联系上您").css("color", "#bbb");
        $(".corrValiDateCode").val("");
        $(".validRs").html("");
        $("#corTextarea textarea").blur(function () {
            var content = $.trim($(this).val());
            if (content == null || content == "") {
                $("#corTextarea textarea").val("如：价格有误、地址不准确或该店已关闭等等").css("color", "#bbb");
            }
        });
        $("#userMail input").blur(function () {
            var mail = $.trim($(this).val()),
                regExp = new RegExp("^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$");
            if (mail == null || mail == "") {
                $(".validRs").html("");
                $(this).val("请输入您的邮箱，以便我们能够联系上您").css("color", "#bbb");
            }
            else if (!regExp.exec(mail)) {
                $(".validRs").html("邮箱格式错误");
            }
            else {
                $(".validRs").html("");
            }
        });
        $.XYTipsWindow({
            ___title: supName + " (" + uniName + ") -纠错",
            ___drag: "___boxTitle",
            ___width: "500px",
            ___height: "240px",
            ___content: "id:correctHide",
            ___showbg: true

        });
    });

    //更换验证码
    $("#chgValidCode").click(function () {
        $("#authenticationCode_foodCorrect").click();
    });

    //提交纠错事件
    $(".correctBtn").click(function () {
        var msgContent = $.trim($("#corTextarea textarea").val()),
            mail = $.trim($("#userMail input").val()),
            validateCode = $.trim($(".corrValiDateCode").val()),
            result = "",
            regExp = new RegExp("^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$");

        if (msgContent == "如：价格有误、地址不准确或该店已关闭等等") {
            msgContent = "";
        }
        if (msgContent == null || msgContent == "") {
            $(".validRs").html("内容不能为空");
            $("#correctCont").next().focus();
            return;
        }

        result = tools.checkValidateCode(validateCode, 500, 0);
        if (result != "1") {
            $(".validRs").html(result);
            return;
        }

        if (mail != null && mail != "" && mail != "请输入您的邮箱，以便我们能够联系上您") {
            if (!regExp.exec(mail)) {
                $(".validRs").html("邮箱格式错误");
                return;
            }
        }

        $.ajax({
            type: "POST",
            url: "../ajax/Food/MenuCorrection.ashx",
            data: { content: msgContent, supID: supID, mail: mail },
            success: function (data) {

                if (data == "1") {
                    parent.$.XYTipsWindow.removeBox();  //修改成功后关闭弹窗
                    $.XYTipsWindow({
                        ___title: "开吃吧提示",
                        ___drag: "___boxTitle",
                        ___width: "300px",
                        ___height: "120px",
                        ___content: "text:<p style=\"color:#555;margin:30px 20px 0;font-size:16px;font-weight:bold;\">菜单纠错提交成功，感谢您对开吃吧菜单信息的监督</p>",
                        ___showbg: true,
                        ___time: 1800
                    });

                }
                else if (data == "-13") {
                    $(".validRs").html("验证码错误");
                    $("#authenticationCode_foodCorrect").click();
                    //return;
                }
                else {
                    $.XYTipsWindow({
                        ___title: "开吃吧提示",
                        ___drag: "___boxTitle",
                        ___width: "300px",
                        ___height: "100px",
                        ___content: "text:<p style=\"color:#555;margin:30px 20px 0;font-size:16px;font-weight:bold;\">由于系统繁忙，您的纠错信息提交失败，请重新提交</p>",
                        ___showbg: true,
                        ___time: 1800
                    });
                }
            }
        });

    });
    //取消纠错事件
    $(".corCancelBt").click(function () {
        parent.$.XYTipsWindow.removeBox();

    });

    //回复餐厅留言
    $(".sm_reply").click(function () {
        var replyID = $(this).attr("id");
        $("#txtMessageContent").focus();
        $("#txtMessageContent").val("#" + replyID + "#  ");
        return false;
    });

    //关闭浮层
    $("#commentLayer .close").click(function () {
        $("#commentLayer").css("display", "none");
        $("#layer").css("display", "none");
    })

});
