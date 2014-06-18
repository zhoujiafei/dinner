
//购物车类
function KcbCarInfo() {
    this.SupID = this.SupName = null;
    this.Businessstate = 1;
    this.SendPrice = this.totalPrice = 0;
    this.DeliveryType = 0;
    this.DeliveryFee = 0;
    this.FreeDeliveryFeePrice = 0;
    this.BusinessModel=1;
    this.FoodInfos = new Array();  
    //刷新Cookie
    this.RefreshCookie = function () {
        $.cookie("KcbCarInfo", JSON.stringify(this), {
            path: "/",
            expires: 43200
        });
    }
};

//菜品信息类
function FoodInfo() {
    this.foodID = this.foodName = null;
    this.number = this.foodprice = 0;
    this.activityState = 0;
}


//判斷菜品是否存在。存在數量加1不存在新增
function ExistsFood(food) {
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    var FoodList = kcbCarInFo.FoodInfos;

    for (var i = 0; i < FoodList.length; i++) {//遍历菜品数组
        if (food.foodID == FoodList[i].foodID) {//找到要增加的对应的菜品
            addFood(food);
            return;
        }
    }
    AddNewFood(food);
}


//添加新的菜品
function AddNewFood(foodmodel) {
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    var FoodList = kcbCarInFo.FoodInfos;

    FoodList[FoodList.length] = foodmodel; //增加菜品

    kcbCarInFo.totalPrice = floatAdd(parseFloat(kcbCarInFo.totalPrice), parseFloat(foodmodel.foodprice));

    //kcbCarInFo.totalPrice = parseFloat(kcbCarInFo.totalPrice) + parseFloat(foodmodel.foodprice); //计算总价
    CreateJson(kcbCarInFo, FoodList); //構造購物車Json
}

//增加已存在的菜品数量
function addFood(food) {
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    var FoodList = kcbCarInFo.FoodInfos;
    
    for (var i = 0; i < FoodList.length; i++) {//遍历菜品数组
        if (food.foodID == FoodList[i].foodID) {//找到要增加的对应的菜品
            FoodList[i].number = parseInt(FoodList[i].number) + 1; //将数量加1

            kcbCarInFo.totalPrice = floatAdd(parseFloat(kcbCarInFo.totalPrice), parseFloat(FoodList[i].foodprice))

            //kcbCarInFo.totalPrice = parseFloat(kcbCarInFo.totalPrice) + parseFloat(FoodList[i].foodprice);
        }
    }
    CreateJson(kcbCarInFo, FoodList); //構造購物車Json
}

function CreateJson(supinfo, foodlist) {
    var kcbCart = new KcbCarInfo();
    if (foodlist.length == 0 || foodlist == null) {//当删除某个菜品后菜品列表数量为0或为空是，设置cookie  KcbCarInfo为null
        $.cookie("KcbCarInfo", null, {
            path: "/",
            expires: 43200
        });
        return;
    }
    else {
        kcbCart.SupID = supinfo.SupID;
        kcbCart.SupName = supinfo.SupName;
        kcbCart.Businessstate = supinfo.Businessstate;
        kcbCart.SendPrice = supinfo.SendPrice;
        kcbCart.DeliveryType = supinfo.DeliveryType;
        kcbCart.totalPrice = supinfo.totalPrice;
        kcbCart.DeliveryFee = supinfo.DeliveryFee;
        kcbCart.FreeDeliveryFeePrice = supinfo.FreeDeliveryFeePrice;
        kcbCart.BusinessModel = 1;
        kcbCart.FoodInfos = foodlist; //将新的菜品数组赋值给新建的对象
    }
   
    kcbCart.RefreshCookie(); //更新cookie
}
//减少已存在的菜品数量
function subFood(food) {
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    var FoodList = kcbCarInFo.FoodInfos;
    for (var i = 0; i < FoodList.length; i++) {//遍历菜品数组
        if (food.foodID == FoodList[i].foodID) {//找到要增加的对应的菜品
            FoodList[i].number = parseInt(FoodList[i].number) - 1; //将数量加1
            kcbCarInFo.totalPrice = floatSub(parseFloat(kcbCarInFo.totalPrice), parseFloat(FoodList[i].foodprice))
            //kcbCarInFo.totalPrice = parseFloat(kcbCarInFo.totalPrice) - parseFloat(FoodList[i].foodprice);
            if (FoodList[i].number == 0) { //减一份后。如果该菜品的数量为0,则将数组中的这个菜品删除
                FoodList.splice(i, 1);
            }
        }
    }
    CreateJson(kcbCarInFo, FoodList);//構造購物車Json
}

//删除某个菜品
function DelFood(food) {
    var kcbCarInFo = eval('(' + $.cookie("KcbCarInfo") + ')');
    var FoodList = kcbCarInFo.FoodInfos;
    for (var i = 0; i < FoodList.length; i++) {//遍历菜品数组
        if (food.foodID == FoodList[i].foodID) {//找到要增加的对应的菜品
            kcbCarInFo.totalPrice = floatSub(parseFloat(kcbCarInFo.totalPrice), (parseFloat(FoodList[i].foodprice) * parseFloat(FoodList[i].number)))

            //kcbCarInFo.totalPrice = parseFloat(kcbCarInFo.totalPrice) - (parseFloat(FoodList[i].foodprice) * parseFloat(FoodList[i].number));           
            FoodList.splice(i, 1);
        }
    }
    CreateJson(kcbCarInFo, FoodList); //構造購物車Json
}


//浮点数加法运算
function floatAdd(arg1, arg2) {
    var r1, r2, m;
    try { r1 = arg1.toString().split(".")[1].length } catch (e) { r1 = 0 }
    try { r2 = arg2.toString().split(".")[1].length } catch (e) { r2 = 0 }
    m = Math.pow(10, Math.max(r1, r2));
    return (arg1 * m + arg2 * m) / m;
}
//浮点数减法运算
function floatSub(arg1, arg2) {
    var r1, r2, m;
    try { r1 = arg1.toString().split(".")[1].length } catch (e) { r1 = 0 }
    try { r2 = arg2.toString().split(".")[1].length } catch (e) { r2 = 0 }
    m = Math.pow(10, Math.max(r1, r2));
    return (arg1 * m - arg2 * m) / m;
}

//浮点数乘法运算  
function floatMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try { m += s1.split(".")[1].length } catch (e) { }
    try { m += s2.split(".")[1].length } catch (e) { }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}