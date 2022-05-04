document.addEventListener("DOMContentLoaded", async function(){
    
  // 로그 출력
  const msg = await xhr('getMsg');
  let logs = '';
  for (type in msg) {
      let log = msg[type];
      if (log) {
          logs += `<div class="log ${type}">${log}</div>`;
      }
  }
  logs = `<div id="message">${logs}</div>`;
  // https://developer.mozilla.org/ko/docs/Web/API/Element/insertAdjacentHTML
  document.body.insertAdjacentHTML('afterbegin', logs);
  
});