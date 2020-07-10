"use strict";const scripts=document.getElementsByTagName("script"),re1=/usaepay/i,re2=/pay\.js/i;let src,host="https://www.usaepay.com";for(let a=0;a<scripts.length;a++)if(src=scripts[a].src,src&&src.match(re1)&&src.match(re2)){host=src.split("/js/")[0];break}var usaepay;(function(a){a.Client=class{constructor(a){this.pubKey=a,this.publicKey=a}createPaymentCardEntry(){return new b(this)}createApplePayEntry(a){return new c(this,a)}getPaymentKey(a){return a.getPaymentKey()}};class b{constructor(a){this.paymentKey="",this.payCardHTML="",this.payCardStyles=" body { margin: 0; overflow: hidden; } ",this.client=a}generateHTML(a){a&&Object.keys(a).forEach(b=>{this.generateStyleClass(b,a[b])});let b=`${host}/js/v1/card.html#${this.client.publicKey}`;this.payCardHTML=`<iframe id="paymentCardIFrame" src="${b}" width="100%" height="100%" frameborder="0"></iframe>`}generateStyleClass(a,b){let c="";c+=`.payjs-${a} { `;let d=Object.keys(b);d.forEach(d=>{d.startsWith(":")?this.generateStyleClass(a+d,b[d]):c+=`${this.camelToDash(d)}: ${b[d]}; `}),c+=" } ",this.payCardStyles+=c}camelToDash(a){return a.replace(/([A-Z])/g,function(a){return"-"+a.toLowerCase()})}addHTML(a){const b=document.getElementById(a);b?b.innerHTML=this.payCardHTML:console.error("could not find "+a),this.addEventListener("ready",()=>{const a=document.getElementById("paymentCardIFrame"),b=a.contentWindow;b.postMessage(`addStyles::${this.payCardStyles}`,"*")})}addEventListener(a,b){window.addEventListener("message",c=>{const d=c.data.split("::");d[0]===a&&b(d[1])})}getPaymentKey(){return new Promise((a,b)=>{const c=document.getElementById("paymentCardIFrame"),d=c.contentWindow;d.postMessage("generateToken::true","*"),this.addEventListener("paymentKey",b=>{a(b)}),this.addEventListener("error",a=>{b(a)})})}}class c{constructor(a,b){this.paymentKey="",this.callbacks={},this.client=a,this.applePayPaymentRequest=Object.assign({},b.paymentRequest,{merchantCapabilities:[],supportedNetworks:[]}),this.applePayConfig=b,this.addSpinner(b.targetDiv)}checkCompatibility(){return new Promise((a,b)=>{window.ApplePaySession?window.ApplePaySession.canMakePayments?this.checkPermissions(a,b):b("Apple Pay is not set up by the user."):b("Apple Pay is not available from this browser")})}addSpinner(a){const b=document.getElementById(a);if(b){const a=document.getElementsByTagName("head")[0],c=document.getElementsByTagName("meta")[0],d=document.createElement("style");d.innerHTML=`.apple-pay-button{box-sizing:border-box;width:100%;height:100%;margin:0;padding:0}#payjs-applePayError{width:100%;text-align:right;color:red;font-size:10px}#paybox-spinnerContainer{position:relative;height:100%;width:100%}#paybox-spinner{animation:rotate 2s linear infinite;z-index:2;position:absolute;top:50%;left:50%;margin:-25px 0 0 -25px;width:50px;height:50px}#paybox-spinnerPath{stroke:#000;stroke-linecap:round;animation:dash 1.5s ease-in-out infinite}@keyframes rotate{100%{transform:rotate(360deg)}}@keyframes dash{0%{stroke-dasharray:1,150;stroke-dashoffset:0}50%{stroke-dasharray:90,150;stroke-dashoffset:-35}100%{stroke-dasharray:90,150;stroke-dashoffset:-124}}@supports (-webkit-appearance:-apple-pay-button){.apple-pay-button{display:inline-block;-webkit-appearance:-apple-pay-button}.apple-pay-button-black{-apple-pay-button-style:black}.apple-pay-button-white{-apple-pay-button-style:white}.apple-pay-button-white-with-line{-apple-pay-button-style:white-outline}}@supports not (-webkit-appearance:-apple-pay-button){.apple-pay-button{display:inline-block;background-size:100% 60%;background-repeat:no-repeat;background-position:50% 50%;border-radius:5px;padding:0;box-sizing:border-box;min-width:200px;min-height:32px;max-height:64px}.apple-pay-button-black{background-image:-webkit-named-image(apple-pay-logo-white);background-color:black}.apple-pay-button-white{background-image:-webkit-named-image(apple-pay-logo-black);background-color:white}.apple-pay-button-white-with-line{background-image:-webkit-named-image(apple-pay-logo-black);background-color:white;border:.5px solid black}}`,a.insertBefore(d,c),b.innerHTML=`<div id="paybox-spinnerContainer"><svg id="paybox-spinner" viewBox="0 0 50 50"><circle id="paybox-spinnerPath" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg></div>`}else console.error(`Could not find ${a}`)}checkPermissions(a,b){const c=document.getElementById(this.applePayConfig.targetDiv);if(c){const a=document.createElement("iframe");a.id="payjs-applePayRelay",a.src=`${host}/js/v1/relay.html#${this.client.publicKey}`,a.width="0",a.height="0",a.frameBorder="0",a.style.display="none",c.appendChild(a)}else console.error(`Could not find ${this.applePayConfig.targetDiv}`);window.addEventListener("message",c=>{if(c.data.includes("::")){const d=c.data.split("::"),e=JSON.parse(d[1]);let f;if(!e.error)switch(d[0]){case"relayReady":this.relayMessage("getMerchantCapabilities",JSON.stringify({route:"/api/v2/pub/merchant_capabilities"}));break;case"merchantCapabilities":e.applepay?(this.onStatusUpdate("applePayPermissionGranted"),this.applePayPaymentRequest.merchantCapabilities=e.applepay.capabilities,this.applePayPaymentRequest.supportedNetworks=e.applepay.networks,!this.applePayConfig.merchantId&&(this.applePayConfig.merchantId=e.applepay.merchant_id),a("Apple Pay is available.")):(this.onStatusUpdate("applePayPermissionDenied"),b("Your merchant account is not set up to use Apple Pay."));break;case"applePayMercahntValidation":this.onStatusUpdate("applePayMerchantValidated"),f=this.applePaySession;const c=JSON.parse(e.payload);f.completeMerchantValidation(c);break;case"paymentKey":f=this.applePaySession,this.paymentKey=e.key,f.completePayment(window.ApplePaySession.STATUS_SUCCESS),this.onStatusUpdate("applePaySuccess");}else switch(console.error("ERROR: ",e.error),this.displayError(d[1]),d[0]){case"applePayMercahntValidation":case"paymentKey":this.onStatusUpdate("applePayError");}}})}addButton(){const a=document.getElementById(this.applePayConfig.targetDiv),b=document.createElement("div");b.id="payjs-applePayBtn",b.setAttribute("class","apple-pay-button apple-pay-button-black"),a.appendChild(b),b.addEventListener("click",a=>{this.createApplePaySession(a)});const c=document.getElementById("paybox-spinnerContainer");c.style.display="none";const d=document.createElement("div");d.id="payjs-applePayError",a.appendChild(d)}createApplePaySession(){this.applePaySession=new window.ApplePaySession(3,this.applePayPaymentRequest);const a=this.applePaySession;a.onvalidatemerchant=a=>{this.onStatusUpdate("applePaySessionBegin");const b=JSON.stringify({route:"/api/v2/pub/applepay/validate",url:a.validationURL,display_name:this.applePayConfig.displayName,domain_name:window.location.hostname,merchant_id:this.applePayConfig.merchantId});this.relayMessage("validateApplePayMerchant",b)},a.oncancel=()=>{this.onStatusUpdate("applePaySessionCancel")},a.onpaymentauthorized=a=>{this.onStatusUpdate("applePayPaymentAuthorized");const b={route:"/api/v2/pub/payment_keys",applepay:a.payment.token};this.relayMessage("getPaymentKey",JSON.stringify(b))},a.begin()}relayMessage(a,b){const c=document.getElementById("payjs-applePayRelay"),d=c.contentWindow;d.postMessage(`${a}::${b}`,"*")}displayError(a){const b=document.getElementById("payjs-applePayError");b.innerText=a}on(a,b){this.callbacks[a]=b}onStatusUpdate(a){this.callbacks[a]&&this.callbacks[a]()}getPaymentKey(){return new Promise(a=>{a(this.paymentKey)})}}})(usaepay||(usaepay={}));