/**
 * 购物车操作类
 */

//购物车
var Cart = function () {
    this.Count = 0;
    this.Total = 0;
    this.Items = new Array();
};

//购物车集合对象
var CartItem = function () {
    this.Id = 0;
    this.Name = "";
    this.Count = 0;
    this.Price = 0;
};
 
//购物车操作
var CartHelper = function () {
    this.cookieName = "cart";
    this.Clear = function () {
        var cart = new Cart();
        this.Save(cart);
        return cart;
    };
    //向购物车添加
    this.Add = function (id, name, count, price) {
        var cart = this.Read();
        var index = this.Find(id);
        //如果ID已存在，覆盖数量
        if (index > -1) {
            cart.Total -= (((cart.Items[index].Count * 100) * (cart.Items[index].Price * 100)) / 10000);
            cart.Items[index].Count = count;
            cart.Total += (((cart.Items[index].Count * 100) * (cart.Items[index].Price * 100)) / 10000);
        } else {
            var item = new CartItem();
            item.Id = id;
            item.Name = name;
            item.Count = count;
            item.Price = price;
            cart.Items.push(item);
            cart.Count++;
            cart.Total += (((cart.Items[index].Count * 100) * (cart.Items[index].Price * 100)) / 10000);
        }
        this.Save(cart);
        return cart;
    };
    //改变数量
    this.Change = function (id, count) {
        var cart = this.Read();
        var index = this.Find(id);
        cart.Items[index].Count = count;
        this.Save(cart);
        return cart;
    };
    //移出购物车
    this.Del = function (id) {
        var cart = this.Read();
        var index = this.Find(id);
        if (index > -1) {
            var item = cart.Items[index];
            cart.Count--;
            cart.Total = cart.Total - (((item.Count * 100) * (item.Price * 100)) / 10000);
            cart.Items.splice(index, 1);
            this.Save(cart);
        }
        return cart;
    };
    //根据ID查找
    this.Find = function (id) {
        var cart = this.Read();
        var index = -1;
        for (var i = 0; i < cart.Items.length; i++) {
            if (cart.Items[i].Id == id) {
                index = i;
            }
        }
        return index;
    };
    //COOKIE操作
    this.Save = function (cart) {
    	/*
        var source = "";
        for (var i = 0; i < cart.Items.length; i++) {
            if (source != "") { source += "|$|"; }
            source += this.ItemToString(cart.Items[i]);
        }
        $.cookie(this.cookieName, source);
        */
    	
    	$.cookie(this.cookieName, $.toJSON(cart));//转换成json字符串保存
    };
    this.Read = function () {
        //读取COOKIE中的集合
    	/*
        var source = $.cookie(this.cookieName);
        var cart = new Cart();
        if (source == null || source == "") {
            return cart;
        }
        var arr = source.split("|$|");
        cart.Count = arr.length;
        for (var i = 0; i < arr.length; i++) {
            var item = this.ItemToObject(arr[i]);
            cart.Items.push(item);
            cart.Total += (((item.Count * 100) * (item.Price * 100)) / 10000);
        }
        */
    	var cart = new Cart();
    	if($.cookie(this.cookieName))
    	{
    		cart = $.evalJSON($.cookie(this.cookieName));
    	}
        return cart;
    };
    /*
    this.ItemToString = function (item) {
        return item.Id + "||" + escape(item.Name) + "||" + item.Count + "||" + item.Price;
    };
    */
    /*
    this.ItemToObject = function (str) {
        var arr = str.split('||');
        var item = new CartItem();
        item.Id = arr[0];
        item.Name = unescape(arr[1]);
        item.Count = arr[2];
        item.Price = arr[3];
        return item;
    };
    */
}; 
