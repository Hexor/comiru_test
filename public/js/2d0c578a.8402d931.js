(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["2d0c578a"],{"3edf":function(t,e,i){"use strict";i.r(e);var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("q-layout",{attrs:{view:"lHh Lpr lFf"}},[i("q-header",{staticClass:"bg-primary",attrs:{elevated:""}},[i("q-toolbar",[i("q-btn",{attrs:{flat:"",dense:"",round:"","aria-label":"Menu"},on:{click:function(e){t.leftDrawerOpen=!t.leftDrawerOpen}}},[i("q-icon",{attrs:{name:"menu"}})],1),i("q-toolbar-title",[t._v("\n        Comiru\n      ")])],1)],1),i("q-drawer",{attrs:{bordered:"","content-class":"bg-grey-2"},on:{input:t.clickDrawerCallback},model:{value:t.leftDrawerOpen,callback:function(e){t.leftDrawerOpen=e},expression:"leftDrawerOpen"}},[i("q-list",[i("q-item",{directives:[{name:"show",rawName:"v-show",value:t.isShowSwitch,expression:"isShowSwitch"}],attrs:{clickable:""},on:{click:function(e){return t.$router.push("/auth/switch")}}},[i("q-item-section",{attrs:{avatar:""}},[i("q-icon",{attrs:{name:"people"}})],1),i("q-item-section",[i("q-item-label",[t._v("切换帐号")]),i("q-item-label",{attrs:{caption:""}},[t._v("切换到或者绑定其他帐号")])],1)],1),i("q-item",{directives:[{name:"show",rawName:"v-show",value:t.isShowBind,expression:"isShowBind"}],attrs:{clickable:""},on:{click:t.bindLineCallback}},[i("q-item-section",{attrs:{avatar:""}},[i("q-icon",{attrs:{name:"fab fa-line"}})],1),i("q-item-section",[i("q-item-label",[t._v("绑定 Line")]),i("q-item-label",{attrs:{caption:""}},[t._v("将 Line 帐号与本站帐号绑定")])],1)],1)],1),i("q-list",[i("q-item",{attrs:{clickable:""},on:{click:t.signOut}},[i("q-item-section",{attrs:{avatar:""}},[i("q-icon",{attrs:{name:"logout"}})],1),i("q-item-section",[i("q-item-label",[t._v("登出")]),i("q-item-label",{attrs:{caption:""}},[t._v("退出当前登录的所有帐号")])],1)],1)],1)],1),i("q-page-container",[i("router-view")],1)],1)},n=[],o=i("b178"),r={name:"UserLayout",data:function(){return{isShowSwitch:!1,isShowBind:!1,leftDrawerOpen:this.$q.platform.is.desktop}},mounted:function(){var t=this.$q.localStorage.getItem("token_type");console.log("mounted "+t),"teacher"!==t&&"student"!==t||this.$router.push({path:"/"+t})},methods:{bindLineCallback:function(){this.startBindLineProcess()},clickDrawerCallback:function(){this.isLineTokenInLocal()||this.isLineTokenInServer()?this.isShowSwitch=!0:this.isShowBind=!0},signOut:function(){this.$q.localStorage.clear(),this.$router.push({path:"/"}),this.$q.notify({color:"info",icon:"logout",message:"您已登出",timeout:500})},openURL:o["c"]}},s=r,l=i("2877"),c=Object(l["a"])(s,a,n,!1,null,null,null);e["default"]=c.exports}}]);