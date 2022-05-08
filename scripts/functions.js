console.log('FUNCTIONS LOADED');
// Promise XMLHttpRequest
async function requestData(file, param = null) {
  let requestUrl = file;
  if (param !== null) {
    let i = 0;
    for (let key in param) {
      if (i === 0) {
        requestUrl += '?' + key + '=' + param[key];
      } else {
        requestUrl += '&' + key + '=' + param[key];
      }
      i++;
    }
  }

  try {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', requestUrl);
    xhr.send();
    const request = await new Promise((resolve, reject) => {
      xhr.onload = function () {
        if (xhr.status == 200) {
          resolve(xhr.response);
        } else {
          reject(Error(xhr.statusText));
        }
      };
    });
    return request;
  } catch (error) {
    throw Error(error);
  }
}
// XHR Excute PHP function
async function xhr(func, param = null, useHtml=false) {
  if (param === null) {
    param = {};
  }
  if (param['call'] === undefined) {
    param['call'] = func;
  }
  let result = await requestData('xhr.php', param);
  if (result) {
    return JSON.parse(result);
  }
}

// 로그 출력
async function printLog() {
  const msg = await xhr('getMsg');
  let logs = '';
  for (type in msg) {
    let log = msg[type];
    if (log) {
      logs += `<div class="log ${type}">${log}</div>`;
    }
  }
  // logs = `<div id="message">${logs}</div>`;
  // https://developer.mozilla.org/ko/docs/Web/API/Element/insertAdjacentHTML
  // document.body.insertAdjacentHTML('afterbegin', logs);
  document.querySelector('#message').insertAdjacentHTML('afterbegin', logs);
}

// ---------------------------------------------------------------------------------------

// 윈도우 스크롤탑
function scrollToTop(speed = 'smooth') {
  window.scroll({top: 0, behavior: speed});
}

// 온비지블 이벤트
function onVisible(element, callback) {
  new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if(entry.intersectionRatio > 0) {
        callback(element);
        // observer.disconnect();
      }
    });
  }).observe(element);
}

// 쓰레드리스트 출력
async function getThreadList() {
  const threadList = await xhr('getThreadList');
  return threadList;
}