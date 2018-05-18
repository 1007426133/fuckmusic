//index.js
//获取应用实例
const app = getApp()
const config = require('../config')

Page({

  onLoad: function (options) {
    var that = this

    var muisc = wx.getStorageSync("audition")

    if (!muisc.name){

      wx.showModal({
        title: '提示',
        content: '没有可播放的音乐',
        success: function (res) {
          if (res.confirm) {
            console.log('用户点击确定')
          } else if (res.cancel) {
            console.log('用户点击取消')
          }
        }
      })

      return ;
    }
    //console.log(muisc)

    muisc.name = muisc.name.substr(0, 15)

    that.setData({
      musicInfo: muisc
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
  }
})
