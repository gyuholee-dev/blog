// console.log('POST SCRIPT LOADED');
DOMLoaded = async ()=>{
  // console.log("DOM LOADED");
  // 로그 출력
  printLog();

  // const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');  
  // if (prefersDarkScheme.matches) {
  //   document.body.classList.add('theme-dark');
  // } else {
  //   document.body.classList.remove('theme-dark');
  // }
}
WindowLoaded = async ()=>{
  // console.log("WINDOW LOADED");

}


document.addEventListener("DOMContentLoaded", DOMLoaded);
window.addEventListener("load", WindowLoaded);