(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["2d0e8814"],{"8a0e":function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("q-page",[n("div",{staticClass:"q-pa-md full-width "},[n("q-card",{attrs:{bordered:""}},[n("q-card-section",[n("div",{staticClass:"text-h6"},[t._v("欢迎学员")]),n("div",{staticClass:"text-body1"},[t._v(t._s(t.studentInfo))])]),n("q-separator",{attrs:{inset:""}})],1),n("br"),n("div",{staticClass:"text-center text-h6"},[t._v("以下是所有的教师, 点击后即可关注")]),n("q-scroll-area",{attrs:{offset:250}},t._l(t.teachers,function(e,s){return n("div",{key:s,on:{click:function(n){return t.followTeacher(e)}}},[n("q-item",[n("q-item-section",[n("q-item-label",{staticClass:"text-h6 cn-bold-font",staticStyle:{"font-size":"15px"}},[t._v("\n              教师 "+t._s(e.nickname)+"\n            ")]),n("q-item-label",{staticClass:"text-primary"},[t._v("\n              "+t._s(e.follow_status)+"\n            ")])],1)],1),n("q-separator",{attrs:{spaced:"",inset:""}})],1)}),0)],1)])},a=[],o=(n("55dd"),n("bc3a")),c=n.n(o),r={data:function(){return{studentInfo:"",teachers:null,followedTeachers:[]}},mounted:function(){var t=this,e=this;c.a.get("student").then(function(t){e.studentInfo=t["data"]}).catch(function(e){t.handleErrorResponse(e)}).then(function(){}),c.a.get("teachers").then(function(n){for(var s in e.teachers=n["data"],t.teachers){var a=t.teachers[s];a.followed.length?a.follow_status="已关注":a.follow_status=""}}).catch(function(e){t.handleErrorResponse(e)}).then(function(){})},methods:{followTeacher:function(t,e){var n=this,s=this;c.a.post("student/follow_teacher",{teacher_id:t.id}).then(function(e){var n="关注成功 !";t.follow_status="已关注",s.teachers.sort(),"unfollowing"===e.data.follows_status&&(t.follow_status="",n="取消关注成功 !"),s.$q.notify({color:"info",icon:"thumb_up",message:n,timeout:500})}).catch(function(t){n.handleErrorResponse(t)}).then(function(){})}}},l=r,i=n("2877"),u=Object(i["a"])(l,s,a,!1,null,null,null);e["default"]=u.exports}}]);