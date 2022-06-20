// console.log('POST SCRIPT LOADED');
DOMLoaded = async ()=>{
  // console.log("DOM LOADED");

  // 테마 저장
  // initTheme();

  // 로그 출력
  printLog();

}
WindowLoaded = async ()=>{
  // console.log("WINDOW LOADED");

}
document.addEventListener("DOMContentLoaded", DOMLoaded);
window.addEventListener("load", WindowLoaded);