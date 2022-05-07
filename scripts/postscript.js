DOMLoaded = async ()=>{
  console.log("DOM LOADED");
  // 로그 출력
  printLog();
  
  // Doc.getQuery('header>.wrap')
  //   .classList.remove('hide');
  // Win.scroll({
  //   top: 140,
  //   left: 0,
  // });

}
WindowLoaded = async ()=>{
  console.log("WINDOW LOADED");

}


Doc.addEvent("DOMContentLoaded", DOMLoaded);
Win.addEvent("load", WindowLoaded);