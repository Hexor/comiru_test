(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["app"],{0:function(e,t,n){e.exports=n("2f39")},"1b68":function(e,t,n){},"2f39":function(e,t,n){"use strict";n.r(t);var a=n("deb5"),r=n.n(a),o=(n("96cf"),n("f44b")),i=n.n(o),c=(n("7d6e"),n("e54f"),n("573e"),n("4439"),n("4605"),n("f580"),n("5b2b"),n("2967"),n("7e67"),n("d770"),n("dd82"),n("922c"),n("c32e"),n("a151"),n("8bc7"),n("d67f"),n("880e"),n("1c10"),n("9482"),n("e797"),n("4848"),n("e9fd"),n("195c"),n("64e9"),n("33c5"),n("4f62"),n("0dbc"),n("4953"),n("81db"),n("2e52"),n("2248"),n("e592"),n("70ca"),n("2318"),n("24bd"),n("8f27"),n("3064"),n("c9a2"),n("8767"),n("4a8e"),n("b828"),n("3c1c"),n("21cb"),n("c00e"),n("e4a8"),n("e4d3"),n("f4d9"),n("b794"),n("af24"),n("7c9c"),n("7bb2"),n("64f7"),n("c382"),n("f5d1"),n("3cec"),n("c00ee"),n("d450"),n("ca07"),n("14e3"),n("1dba"),n("674a"),n("de26"),n("6721"),n("25e9"),n("fc83"),n("98e5"),n("605a"),n("ba60"),n("df07"),n("7903"),n("e046"),n("58af"),n("7713"),n("0571"),n("3e27"),n("6837"),n("3fc9"),n("0693"),n("bf41"),n("1b68"),n("7e6d"),n("2b0e")),s=n("b178");c["a"].use(s["b"],{config:{notify:{timeout:1e3},brand:{primary:"#03a9f4",secondary:"#64b5f6",accent:"#ff80ab",positive:"#21BA45",negative:"#C10015",info:"#0288D1",warning:"#F2C037"},loading:{}}});var u=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{attrs:{id:"q-app"}},[n("router-view")],1)},p=[],h={name:"App"},l=h,f=n("2877"),d=Object(f["a"])(l,u,p,!1,null,null,null),b=d.exports,k=n("8c4f"),g=[{path:"/",component:function(){return n.e("2d0c578a").then(n.bind(null,"3edf"))},children:[{path:"student",component:function(){return n.e("2d0e8814").then(n.bind(null,"8a0e"))}},{path:"teacher",component:function(){return n.e("2d2382c4").then(n.bind(null,"fdf6"))}}]},{path:"/auth",component:function(){return n.e("2d0b2e8a").then(n.bind(null,"25b3"))},children:[{path:"login",component:function(){return n.e("2d0a314a").then(n.bind(null,"013f"))}},{path:"register",component:function(){return n.e("2d0c8f69").then(n.bind(null,"56b4"))}},{path:"bind_login",component:function(){return n.e("2d0a314a").then(n.bind(null,"013f"))}},{path:"bind_register",component:function(){return n.e("2d0c8f69").then(n.bind(null,"56b4"))}},{path:"switch",component:function(){return n.e("2d0a3ce8").then(n.bind(null,"046d"))}},{path:"line",component:function(){return n.e("2d0b368b").then(n.bind(null,"27f6"))},props:function(e){return{access_token:e.query.access_token,expires_in:e.query.expires_in}}}]}];g.push({path:"*",component:function(){return n.e("4b47640d").then(n.bind(null,"e51e"))}});var _=g;c["a"].use(k["a"]);var m=function(){var e=new k["a"]({scrollBehavior:function(){return{x:0,y:0}},routes:_,mode:"hash",base:""});return e},v=function(){var e="function"===typeof m?m({Vue:c["a"]}):m,t={el:"#q-app",router:e,render:function(e){return e(b)}};return{app:t,router:e}},w=n("bc3a"),y=n.n(w),L=function(){var e=i()(r.a.mark(function e(t){var n,a;return r.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:n=t.Vue,a=s["a"].getItem("access_token"),y.a.defaults.baseURL="https://kaiche.co/api/",y.a.defaults.headers.common["Authorization"]="Bearer "+a,n.prototype.$axios=y.a;case 5:case"end":return e.stop()}},e)}));return function(t){return e.apply(this,arguments)}}(),x=function(){var e=i()(r.a.mark(function e(t){var n,a;return r.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:t.app,n=t.router,a=t.Vue,n.beforeEach(function(e,t,r){console.log("route to "+e.path);var o=s["a"].getItem("access_token"),i=s["a"].getItem("token_type"),c=s["a"].getItem("token_expire_at"),u=new Date;if(o&&c>u)switch(e.path){case"/student":break;case"/teacher":break;case"/":case"/auth":case"/auth/register":case"/auth/login":return void n.push({path:"/"+i});case"/auth/bind_login":case"/auth/bind_register":break;case"/auth/switch":break;case"/auth/line":break;default:break}else if(a.prototype.isLineTokenInLocal()||a.prototype.isLineTokenInServer())switch(e.path){case"/student":break;case"/teacher":break;case"/":case"/auth":case"/auth/login":case"/auth/register":return void n.push({path:"/auth/switch"});case"/auth/bind_login":case"/auth/bind_register":break;case"/auth/switch":break;case"/auth/line":break;default:break}else switch(e.path){case"/student":case"/teacher":case"/auth/bind_login":case"/auth/bind_register":case"/auth/switch":case"/auth":case"/":return void n.push({path:"/auth/login"});case"/auth/line":break;case"/auth/register":case"/auth/login":break;default:break}r()});case 2:case"end":return e.stop()}},e)}));return function(t){return e.apply(this,arguments)}}(),I=function(){var e=i()(r.a.mark(function e(t){var n;return r.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:t.app,t.router,n=t.Vue,n.prototype.getLocalTokenType=function(){var e=s["a"].getItem("token_type");return e||(this.isLineTokenInLocal()?"line":void 0)},n.prototype.isLineTokenInServer=function(){if("line_exist_in_server"===s["a"].getItem("line_exist_in_server"))return!0},n.prototype.isLineTokenInLocal=function(){var e=s["a"].getItem("line_access_token"),t=s["a"].getItem("line_token_expire_at"),n=new Date;if(e&&t>n)return!0},n.prototype.updateLocalStorageTokenInfo=function(e,t,n,a){y.a.defaults.headers.common["Authorization"]="Bearer "+e,s["a"].set("access_token",e),s["a"].set("token_type",t),s["a"].set("token_expire_at",n),a&&s["a"].set("line_exist_in_server",a)},n.prototype.signOutAndDeleteData=function(){this.$q.localStorage.clear(),this.$router.push({path:"/auth/login"}),this.$q.notify({color:"info",icon:"logout",message:"您已登出",timeout:500})},n.prototype.handleErrorResponse=function(e){var t=e.response.data.message;this.$q.notify({multiLine:!0,color:"warning",message:t,timeout:1500}),s["a"].clear(),this.$router.push({path:"/auth"})},n.prototype.openLineLoginWindow=function(){return window.open("https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1564192144&redirect_uri=https://kaiche.co/api/line_auth_callback&state=12345&scope=openid","_blank","width=600,height=400,menubar=no,toolbar=no,location=no")},n.prototype.bindSignInTokenWithLineToken=function(){var e=this,t=s["a"].getItem("access_token"),n=s["a"].getItem("line_access_token");t&&y.a.post(s["a"].getItem("token_type")+"/bind_line",{line_token:n}).then(function(t){e.$q.notify({color:"info",icon:"thumb_up",message:"绑定成功!",timeout:500}),e.$router.push({path:"/auth/switch"})}).catch(function(t){e.handleErrorResponse(t)}).then(function(){})},n.prototype.startLoginAsLineProcess=function(){this.startLineProcess("login")},n.prototype.startBindLineProcess=function(){this.startLineProcess("bind")},n.prototype.startLineProcess=function(e){var t=this,n=this.openLineLoginWindow(),a=setInterval(function(){t.isLineTokenInLocal()&&(n.close(),"login"===e?(t.$q.notify({color:"lineColor",textColor:"white",icon:"fab fa-line",message:"登录 Line 成功! ",timeout:3e3}),t.$router.push({path:"/auth/switch"})):"bind"===e&&t.bindSignInTokenWithLineToken(),clearInterval(a))},500);setTimeout(function(){clearInterval(a)},3e4)};case 12:case"end":return e.stop()}},e)}));return function(t){return e.apply(this,arguments)}}(),T=v(),$=T.app,q=T.router;function A(){return S.apply(this,arguments)}function S(){return S=i()(r.a.mark(function e(){var t,n;return r.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:t=[L,x,I],n=0;case 2:if(!(n<t.length)){e.next=18;break}return e.prev=3,e.next=6,t[n]({app:$,router:q,Vue:c["a"],ssrContext:null});case 6:e.next=15;break;case 8:if(e.prev=8,e.t0=e["catch"](3),!e.t0||!e.t0.url){e.next=13;break}return window.location.href=e.t0.url,e.abrupt("return");case 13:return console.error("[Quasar] boot error:",e.t0),e.abrupt("return");case 15:n++,e.next=2;break;case 18:new c["a"]($);case 19:case"end":return e.stop()}},e,null,[[3,8]])})),S.apply(this,arguments)}A()},"7e6d":function(e,t,n){}},[[0,"runtime","vendor"]]]);