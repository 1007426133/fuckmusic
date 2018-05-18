//index.js
//获取应用实例
const app = getApp()
const config = require('../config')

Page({
  data: {

    index: 0,

  }, 
  //用户授权登陆获取用户信息
  login: function () {
    
    var that =this;

    if (wx.getStorageSync("UserSession")) {

      var userInfo = wx.getStorageSync("UserSession")
      //console.log(userInfo.avatarUrl)

      that.uInfo(userInfo)
      return;
    }

    //获取用户信息传送到服务器
    wx.login({
      success: function (code) {

        wx.getUserInfo({
          success: function (res) {
            var simpleUser = res.userInfo;//用户名称、头像信息
            that.setData({
              userinfo: res.userInfo
            })
            //发起请求到服务器保存用户信息
            wx.request({
              url: config.loginUrl,
              method: 'GET',
              data: {
                code: code.code,
                userInfo: simpleUser
              },
              header: {
                'Content-Type': 'application/json'
              },
              success: function (res) {
                //console.log(res.data);
                if(res.data.session_key){
                  wx.setStorageSync("UserSession", res.data)

                  that.uInfo(res.data)
                }
              }
            })
          },
          fail: function () {

            that.setData({
              imgurl: "../image/defind.png",
              userName: "用户未授权"
            })

            wx.showModal({
              title: '警告',
              content: '您点击了拒绝授权，将无法正常使用海量下载的功能体验。请10分钟后再次点击授权，或者删除小程序重新进入。',
              success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                }
              }
            })          

          }
        });
      }
    });
  },
  //将用户信息发送到页面
  uInfo:function(info){
    var that = this

    that.setData({
      imgurl: info.avatarUrl,
      userName: info.nickName
    })
  },
  onLoad: function (options) {
    var that = this

    that.login();

    wx.showLoading({
      title: '加载中。。。',
    })
    wx.request({
      url: config.typesUrl,
      method: 'GET',
      data: {
        
      },
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {

       that.setData({
         typeArray:res.data.types,
         serachStr: res.data.searchStr
       })

        setTimeout(function () {
          wx.hideLoading()
        }, 1000)
      }
    })

  }, 
  bindPickerChange: function (e) {
    
    this.setData({
      index: e.detail.value
    })
  },
  formSubmit:function(e){
    //console.log(e)
    if (!e.detail.value.w ){
      return ;
    }
    var that = this
    wx.showLoading({
      title: '加载中。。。',
    })
    wx.request({
      url: config.listUrl,
      method: 'GET',
      data: {
        w: e.detail.value.w,
        types: e.detail.value.types
      },
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {
        console.log(res.data)

        // wx.navigateTo({
        //   url: '../taobao/sousuo?types=s&k=sousuo1'
        // })

        that.setData({
          muiscList: res.data
        })
        setTimeout(function () {
          wx.hideLoading()
        }, 1000)
      }
    })

  },
  onclick:function(e){
    var link = e.currentTarget.dataset.url
    wx.setClipboardData({
      data: link,
      success: function (res) {
        wx.showToast({
          title: "复制成功"
        })
      }
    })
  },
  audition:function(e){
    //console.log(e.currentTarget.dataset);
    wx.setStorageSync("audition", e.currentTarget.dataset)

    wx.navigateTo({
      url: "../audition/index"     
    })
  },
  navigateTo:function(e){
    console.log(e)
    wx.navigateTo({ 
      url: "../taobao/conten?id=" + e.currentTarget.dataset.id + "&type=" + e.currentTarget.dataset.cun
      })
  }

})
