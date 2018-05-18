//app.js
App({
  onLaunch: function () {

    wx.checkSession({
      success: function () {
        //session 未过期，并且在本生命周期一直有效
      },
      fail: function () {
        //登录态过期

        wx.login({
          success: function (code) {

            //console.log(code.code);

            wx.getUserInfo({
              success: function (res) {
                var simpleUser = res.userInfo;
                //wx.setStorageSync("sessionId", 1)
                console.log(simpleUser);
              },
              fail: function () {
                wx.showModal({
                  title: '警告',
                  content: '您点击了拒绝授权，将无法正常使用海量下载的功能体验。请10分钟后再次点击授权，或者删除小程序重新进入。',
                  success: function (res) {
                    if (res.confirm) {
                      console.log('用户点击确定')
                    }
                  }
                })
                wx.clearStorage()
              }
            });
          }
        });
      }
    })





  }
  

})