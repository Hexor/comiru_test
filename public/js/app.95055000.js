(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["app"],{0:function(e,n,t){e.exports=t("2f39")},"1b68":function(e,n,t){},"2f39":function(e,n,t){"use strict";t.r(n);var r=t("deb5"),a=t.n(r),o=(t("96cf"),t("f44b")),i=t.n(o),c=(t("7d6e"),t("e54f"),t("573e"),t("4439"),t("4605"),t("f580"),t("5b2b"),t("2967"),t("7e67"),t("d770"),t("dd82"),t("922c"),t("c32e"),t("a151"),t("8bc7"),t("d67f"),t("880e"),t("1c10"),t("9482"),t("e797"),t("4848"),t("e9fd"),t("195c"),t("64e9"),t("33c5"),t("4f62"),t("0dbc"),t("4953"),t("81db"),t("2e52"),t("2248"),t("e592"),t("70ca"),t("2318"),t("24bd"),t("8f27"),t("3064"),t("c9a2"),t("8767"),t("4a8e"),t("b828"),t("3c1c"),t("21cb"),t("c00e"),t("e4a8"),t("e4d3"),t("f4d9"),t("b794"),t("af24"),t("7c9c"),t("7bb2"),t("64f7"),t("c382"),t("f5d1"),t("3cec"),t("c00ee"),t("d450"),t("ca07"),t("14e3"),t("1dba"),t("674a"),t("de26"),t("6721"),t("25e9"),t("fc83"),t("98e5"),t("605a"),t("ba60"),t("df07"),t("7903"),t("e046"),t("58af"),t("7713"),t("0571"),t("3e27"),t("6837"),t("3fc9"),t("0693"),t("bf41"),t("1b68"),t("7e6d"),t("2b0e")),u=t("b178");c["a"].use(u["b"],{config:{notify:{timeout:1e3},brand:{primary:"#03a9f4",secondary:"#64b5f6",accent:"#ff80ab",positive:"#21BA45",negative:"#C10015",info:"#0288D1",warning:"#F2C037"},loading:{}}});var s=function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{attrs:{id:"q-app"}},[t("router-view")],1)},p=[],h={name:"App"},l=h,f=t("2877"),d=Object(f["a"])(l,s,p,!1,null,null,null),b=d.exports,m=t("8c4f"),k=[{path:"/",component:function(){return t.e("2d0c578a").then(t.bind(null,"3edf"))},children:[{path:"student",component:function(){return t.e("2d0e8814").then(t.bind(null,"8a0e"))}},{path:"teacher",component:function(){return t.e("2d2382c4").then(t.bind(null,"fdf6"))}}]},{path:"/auth",component:function(){return t.e("2d0b2e8a").then(t.bind(null,"25b3"))},children:[{path:"",component:function(){return t.e("2d0a314a").then(t.bind(null,"013f"))}},{path:"login",component:function(){return t.e("2d0a314a").then(t.bind(null,"013f"))}},{path:"register",component:function(){return t.e("2d0c8f69").then(t.bind(null,"56b4"))}},{path:"bind_login",component:function(){return t.e("2d0a314a").then(t.bind(null,"013f"))}},{path:"bind_register",component:function(){return t.e("2d0c8f69").then(t.bind(null,"56b4"))}},{path:"switch",component:function(){return t.e("2d0a3ce8").then(t.bind(null,"046d"))}},{path:"line",component:function(){return t.e("2d0b368b").then(t.bind(null,"27f6"))},props:function(e){return{access_token:e.query.access_token,expires_in:e.query.expires_in}}}]}];k.push({path:"*",component:function(){return t.e("4b47640d").then(t.bind(null,"e51e"))}});var _=k;c["a"].use(m["a"]);var v=function(){var e=new m["a"]({scrollBehavior:function(){return{x:0,y:0}},routes:_,mode:"hash",base:""});return e},g=function(){var e="function"===typeof v?v({Vue:c["a"]}):v,n={el:"#q-app",router:e,render:function(e){return e(b)}};return{app:n,router:e}},w=t("bc3a"),y=t.n(w),L=function(){var e=i()(a.a.mark(function e(n){var t,r;return a.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:t=n.Vue,r=u["a"].getItem("access_token"),y.a.defaults.baseURL="https://kaiche.co/api/",y.a.defaults.headers.common["Authorization"]="Bearer "+r,t.prototype.$axios=y.a;case 5:case"end":return e.stop()}},e)}));return function(n){return e.apply(this,arguments)}}(),x=function(){var e=i()(a.a.mark(function e(n){var t,r;return a.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:n.app,t=n.router,r=n.Vue,t.beforeEach(function(e,n,a){console.log("route to "+e.path);var o=u["a"].getItem("access_token"),i=u["a"].getItem("token_type"),c=u["a"].getItem("token_expire_at"),s=new Date;switch(e.path){case"/student":break;case"/teacher":break;case"/":case"/auth":return void(o&&c>s?t.push({path:"/"+i}):r.prototype.isLineTokenInLocal()?t.push({path:"/auth/switch"}):t.push({path:"/auth/login"}));case"/auth/login":break;case"/auth/register":break;case"/auth/bind_login":case"/auth/bind_register":break;case"/auth/switch":break;case"/auth/line":break;default:}a()});case 2:case"end":return e.stop()}},e)}));return function(n){return e.apply(this,arguments)}}(),I=function(){var e=i()(a.a.mark(function e(n){var t;return a.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:n.app,n.router,t=n.Vue,t.prototype.getLocalTokenType=function(){var e=u["a"].getItem("token_type");return e||(this.isLineTokenInLocal()?"line":void 0)},t.prototype.isLineTokenInServer=function(){if("line_exist_in_server"===u["a"].getItem("line_exist_in_server"))return!0},t.prototype.isLineTokenInLocal=function(){var e=u["a"].getItem("line_access_token"),n=u["a"].getItem("line_token_expire_at"),t=new Date;if(e&&n>t)return!0},t.prototype.updateLocalStorageTokenInfo=function(e,n,t,r){y.a.defaults.headers.common["Authorization"]="Bearer "+e,u["a"].set("access_token",e),u["a"].set("token_type",n),u["a"].set("token_expire_at",t),r&&u["a"].set("line_exist_in_server",r)},t.prototype.handleErrorResponse=function(e){var n=e.response.data.message;this.$q.notify({multiLine:!0,color:"warning",message:n,timeout:1500}),u["a"].clear(),this.$router.push({path:"/auth"})},t.prototype.openLineLoginWindow=function(){return window.open("https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1564192144&redirect_uri=https://kaiche.co/api/line_auth_callback&state=12345&scope=openid","_blank","width=600,height=400,menubar=no,toolbar=no,location=no")},t.prototype.bindSignInTokenWithLineToken=function(){var e=this,n=u["a"].getItem("access_token"),t=u["a"].getItem("line_access_token");n&&y.a.post(u["a"].getItem("token_type")+"/bind_line",{line_token:t}).then(function(n){e.$q.notify({color:"info",icon:"thumb_up",message:"绑定成功!",timeout:500}),e.$router.push({path:"/auth/switch"})}).catch(function(n){e.handleErrorResponse(n)}).then(function(){})},t.prototype.startLoginAsLineProcess=function(){this.startLineProcess("login")},t.prototype.startBindLineProcess=function(){this.startLineProcess("bind")},t.prototype.startLineProcess=function(e){var n=this,t=this.openLineLoginWindow(),r=setInterval(function(){n.isLineTokenInLocal()&&(t.close(),"login"===e?(n.$q.notify({color:"lineColor",textColor:"white",icon:"fab fa-line",message:"登录 Line 成功! ",timeout:3e3}),n.$router.push({path:"/auth/switch"})):"bind"===e&&n.bindSignInTokenWithLineToken(),clearInterval(r))},500);setTimeout(function(){clearInterval(r)},3e4)};case 11:case"end":return e.stop()}},e)}));return function(n){return e.apply(this,arguments)}}(),T=g(),$=T.app,q=T.router;function A(){return B.apply(this,arguments)}function B(){return B=i()(a.a.mark(function e(){var n,t;return a.a.wrap(function(e){while(1)switch(e.prev=e.next){case 0:n=[L,x,I],t=0;case 2:if(!(t<n.length)){e.next=18;break}return e.prev=3,e.next=6,n[t]({app:$,router:q,Vue:c["a"],ssrContext:null});case 6:e.next=15;break;case 8:if(e.prev=8,e.t0=e["catch"](3),!e.t0||!e.t0.url){e.next=13;break}return window.location.href=e.t0.url,e.abrupt("return");case 13:return console.error("[Quasar] boot error:",e.t0),e.abrupt("return");case 15:t++,e.next=2;break;case 18:new c["a"]($);case 19:case"end":return e.stop()}},e,null,[[3,8]])})),B.apply(this,arguments)}A()},"7e6d":function(e,n,t){}},[[0,"runtime","vendor"]]]);