DOMLoaded = async ()=>{
  console.log("DOM LOADED");
  // 로그 출력
  printLog();

  // const threadList = await getThreadList();
  // console.log(threadList);

}
WindowLoaded = async ()=>{
  console.log("WINDOW LOADED");

}


Doc.addEvent("DOMContentLoaded", DOMLoaded);
Win.addEvent("load", WindowLoaded);