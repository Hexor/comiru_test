(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["2d0a3ce8"],{"046d":function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"q-pa-md full-width "},[n("div",{staticClass:"row items-center"},[n("q-btn",{staticClass:"col",attrs:{flat:"",color:"primary"},on:{click:function(e){return t.$router.push("/auth/bind_login")}}},[t._v("点击绑定新帐号\n    ")])],1),n("div"),n("q-card",{directives:[{name:"show",rawName:"v-show",value:t.noBindCard,expression:"noBindCard"}],attrs:{bordered:""}},[n("q-card-section",[n("div",{staticClass:"text-body2"},[t._v("当前 Line 尚未绑定任何帐号")])]),n("q-separator",{attrs:{inset:""}})],1),n("q-page",[n("q-scroll-area",{attrs:{offset:250}},t._l(t.lineUsers,function(e,a){return n("div",{key:a,on:{click:function(n){return t.switchUser(e)}}},[n("q-item",[n("q-item-section",[e.teacher?n("q-item-label",{staticClass:"text-h6 cn-bold-font",staticStyle:{"font-size":"15px"}},[t._v("\n              教师 "+t._s(e.teacher.username)+"\n            ")]):t._e(),e.student?n("q-item-label",{staticClass:"text-h6 cn-bold-font",staticStyle:{"font-size":"15px"}},[t._v("\n              学员 "+t._s(e.student.username)+"\n            ")]):t._e()],1),n("q-item-section",{attrs:{side:""}},[n("q-icon",{attrs:{name:"swap_horiz",color:"primary"}})],1)],1),n("q-separator",{attrs:{spaced:"",inset:""}})],1)}),0)],1)],1)},s=[],i=n("bc3a"),o=n.n(i),r={data:function(){return{lineUsers:null,noBindCard:!1}},mounted:function(){this.refreshData()},created:function(){},methods:{refreshData:function(){var t=this,e=this,n=this.getLocalTokenType();if(n){var a=this.$q.localStorage.getItem("line_access_token"),s=n+"/line_users";"line"===n&&(s=s+"?line_token="+a),o.a.get(s).then(function(n){e.lineUsers=n["data"],0===e.lineUsers.length&&(t.noBindCard=!0)}).catch(function(e){t.handleErrorResponse(e)}).then(function(){e.loading=!1})}},switchUser:function(t){var e=this;console.log(t);var n={};t.student?(n["sign_type"]="student",n["id"]=t.student.id):t.teacher&&(n["sign_type"]="teacher",n["id"]=t.teacher.id);var a=this.getLocalTokenType();if(a){var s=this.$q.localStorage.getItem("line_access_token"),i=a+"/switch_user";"line"===a&&(n["line_token"]=s);var r=this;o.a.post(i,n).then(function(t){var n=new Date;r.updateLocalStorageTokenInfo(t.data.access_token,t.data.sign_type,n.getTime()+1e3*t.data.expires_in),e.$q.notify({color:"info",icon:"thumb_up",message:"登录成功 !",timeout:500}),r.$router.push({path:"/"+t.data.sign_type})}).catch(function(t){var e=t.response.data.message;r.$q.notify({multiLine:!0,color:"negative",message:e})}).then(function(){r.loading=!1})}}}},c=r,l=n("2877"),d=Object(l["a"])(c,a,s,!1,null,null,null);e["default"]=d.exports}}]);