var Spotlight=(window.webpackJsonpSpotlight=window.webpackJsonpSpotlight||[]).push([[12],{0:function(t,e){t.exports=React},1085:function(t,e,n){"use strict";n.r(e);var o=n(394),r=n(812),i=n.n(r);class a extends elementorModules.frontend.handlers.Base{getDefaultSettings(){return{}}getDefaultElements(){return{$feed:this.$element.find("div.spotlight-instagram-feed")}}bindEvents(){this.elements.$feed.length>0&&Object(o.a)(this.elements.$feed.get(0))}}i()(window).on("elementor/frontend/init",()=>{elementorFrontend.hooks.addAction("frontend/element_ready/sl-insta-feed.default",t=>{elementorFrontend.elementsHandler.addHandler(a,{$element:t})})})},121:function(t,e,n){"use strict";var o=n(122);function r(){}function i(){}i.resetWarningCache=r,t.exports=function(){function t(t,e,n,r,i,a){if(a!==o){var s=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw s.name="Invariant Violation",s}}function e(){return t}t.isRequired=t;var n={array:t,bool:t,func:t,number:t,object:t,string:t,symbol:t,any:t,arrayOf:e,element:t,elementType:t,instanceOf:e,node:t,objectOf:e,oneOf:e,oneOfType:e,shape:e,exact:e,checkPropTypes:i,resetWarningCache:r};return n.PropTypes=n,n}},122:function(t,e,n){"use strict";t.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"},26:function(t,e,n){t.exports=n(121)()},313:function(t,e,n){"use strict";t.exports=function(t){return"[object RegExp]"===Object.prototype.toString.call(t)}},317:function(t,e,n){"use strict";var o=n(47);e.createRoot=o.createRoot,e.hydrateRoot=o.hydrateRoot},394:function(t,e,n){"use strict";n.d(e,"b",(function(){return f})),n.d(e,"a",(function(){return w}));var o=n(0),r=n.n(o),i=n(180),a=n(6),s=n(190),c=(n(597),n(217));function d({id:t,feedState:e}){const[n,i]=Object(o.useState)(e);return r.a.createElement("div",{className:"spotlight-instagram-app"},r.a.createElement(c.a,{id:t,state:n,onUpdateState:i,autoDevice:!0,autoLoad:!0}))}var l=n(16),u=n(361),p=n(187);function f(t={}){const e=document.getElementsByClassName("spotlight-instagram-feed");for(let n=0,o=e.length||0;n<o;++n){const o=w(e[n],t);o&&(window.SpotlightInstagram.instances[n]=o)}}function w(t,e={}){const n=t.getAttribute("data-feed-var"),o="1"===t.getAttribute("data-analytics"),c=parseInt(t.getAttribute("data-instance")),f=h[w=n]=h.hasOwnProperty(w)?h[w]:g("sli__f__"+w);var w;const y=function(t){return m[t]=m.hasOwnProperty(t)?m[t]:g("sli__a__"+t)}(n),S=function(t){return b[t]=b.hasOwnProperty(t)?b[t]:g("sli__m__"+t)}(n);if(n&&"object"==typeof f&&Array.isArray(y)){if(t.children.length>0)if(e.reInit){const e=t.cloneNode();t.parentNode.append(e),t.remove(),t=e}else if(!e.silent)return console.warn("A Spotlight Instagram feed could not be created because its DOM node is not empty"),null;const w=l.b.getDevice(Object(s.b)()),g=a.b.forFrontApp(y);let h=new a.e(f,w,g,o,c);Object(u.a)(S)||([h]=h.load(S));const m={run(){const e=r.a.createElement(d,{id:"sli-feed-"+n,feedState:h});Object(p.a)(e,t)}};return Object(i.b)(()=>m.run()),m}return null}function g(t){const e=document.getElementById(t);return e&&e.hasAttribute("data-json")?JSON.parse(e.getAttribute("data-json")):null}window.SliFrontCtx||(window.SliFrontCtx={}),window.SliAccountInfo||(window.SliAccountInfo={}),window.SliPreloadedMedia||(window.SliPreloadedMedia={}),window.SpotlightInstagram||(window.SpotlightInstagram={instances:[],init:f,feed:w});const h=window.SliFrontCtx,m=window.SliAccountInfo,b=window.SliPreloadedMedia},47:function(t,e){t.exports=ReactDOM},597:function(t,e,n){t.exports={"spotlight-instagram-app":"spotlight-instagram-app"}},78:function(t,e){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(t){"object"==typeof window&&(n=window)}t.exports=n},812:function(t,e){t.exports=jQuery}},[[1085,3,1,2,0]]]);