(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["2d0b2e8a"],{"25b3":function(t,a,e){"use strict";e.r(a);var o=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("q-layout",{attrs:{view:"lHh Lpr lFf"}},[e("q-header",{staticClass:"bg-primary",attrs:{elevated:""}},[e("q-toolbar",[e("q-btn",{attrs:{flat:"",icon:"arrow_back"},on:{click:function(a){return t.backBtnCallback()}}}),e("q-toolbar-title",{staticClass:"text-center",staticStyle:{"font-weight":"bolder"}},[t._v("\n        Comiru\n      ")]),e("q-btn",{attrs:{flat:""},on:{click:function(a){t.confirm=!0}}},[e("q-icon",{attrs:{right:"",name:"logout"}})],1)],1)],1),e("q-page-container",[e("router-view")],1),e("q-dialog",{attrs:{persistent:""},model:{value:t.confirm,callback:function(a){t.confirm=a},expression:"confirm"}},[e("q-card",[e("q-card-section",{staticClass:"row items-center"},[e("span",{staticClass:"q-ml-sm"},[t._v("登出当前帐号, 您可能需要重新登录后才能使用所有功能")])]),e("q-card-actions",{attrs:{align:"right"}},[e("q-btn",{directives:[{name:"close-popup",rawName:"v-close-popup"}],attrs:{flat:"",label:"取消",color:"primary"}}),e("q-btn",{directives:[{name:"close-popup",rawName:"v-close-popup"}],attrs:{flat:"",label:"确认登出",color:"primary"},on:{click:t.sureToLogout}})],1)],1)],1)],1)},r=[],n={name:"AuthLayout",data:function(){return{confirm:!1,name:null,age:null,showBackBtn:!1,accept:!1,isPwd:!0,password:null,leftDrawerOpen:this.$q.platform.is.desktop}},beforeRouteUpdate:function(t,a,e){"/auth/switch"===t.path?(console.log("switch now"),this.showBackBtn=!1):this.showBackBtn=!0,e()},methods:{backBtnCallback:function(){"/auth/switch"===this.$route.path?this.$router.push({path:"/auth/login"}):"/auth/bind_register"===this.$route.path?this.$router.push({path:"/auth/bind_login"}):"/auth/register"===this.$route.path?this.$router.push({path:"/auth/login"}):this.$router.push({path:"/auth/switch"})},sureToLogout:function(){this.signOutAndDeleteData()}}},s=n,i=e("2877"),c=Object(i["a"])(s,o,r,!1,null,null,null);a["default"]=c.exports}}]);