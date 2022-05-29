// console.log('FUNCTIONS LOADED');
// Promise XMLHttpRequest
async function requestData(file, param = null) {  
  let request = '';
  if (param !== null) {
    for (let key in param) {
      if (key === Object.keys(param)[0]) {
        request += key+'='+param[key];
      } else {
        request += '&'+key+'='+param[key];
      }
    }
  }
  // console.log('XHR:', request);
  try {
    const xhr = new XMLHttpRequest();
    // get 전송
    // xhr.open('GET', file+'?'+request);
    // xhr.send();
    // post 전송
    // http://daplus.net/javascript-xmlhttprequest%EB%A5%BC-%EC%82%AC%EC%9A%A9%ED%95%98%EC%97%AC-post-%EB%8D%B0%EC%9D%B4%ED%84%B0-%EB%B3%B4%EB%82%B4%EA%B8%B0/
    xhr.open('POST', file, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(request);

    const result = await new Promise((resolve, reject) => {
      xhr.onload = function () {
        if (xhr.status == 200) {
          resolve(xhr.response);
        } else {
          reject(Error(xhr.statusText));
        }
      };
    });
    return result;
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

// onVisible Event
// https://stackoverflow.com/questions/1462138/event-listener-for-when-element-becomes-visible
// https://velog.io/@dev-tinkerbell/%EB%AC%B4%ED%95%9C%EC%8A%A4%ED%81%AC%EB%A1%A4-%EA%B5%AC%ED%98%84%EB%B0%A9%EB%B2%95
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

// 쿠키 저장
function setCookie(key, value, maxAge=3600) {
  document.cookie = `${key}=${value}; path=/; max-age=${maxAge};`;
}
// 쿠키 삭제
function delCookie(key) {
  document.cookie = `${key}=; path=/; max-age=0;`;
}
// 쿠키 불러오기
function getCookie(key) {
  let cookies = document.cookie.split(';');
  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].split('=');
    if (cookie[0].trim() === key) {
      return cookie[1];
    }
  }
  return null;
}


// 비동기 지연
// https://coder-question-ko.com/cq-ko-blog/81552
// await timeout(1000);
function timeout(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

// 문자열 잘라내기
function substrMax(str, max, ellipsis='&#8230;') {
  if (str.length > max) {
    str = str.substr(0, max)+' '+ellipsis;
  }
  return str;
}

// 윈도우 스크롤탑
function scrollToTop(speed = 'smooth') {
  window.scroll({top: 0, behavior: speed});
}

// ---------------------------------------------------------------------------------------

// 로딩 이벤트 핸들링
// TODO: 활성화 전환
function setLoadingEvent(loading, form, delay=350) {
  // return false;
  onVisible(loading, async()=> {
    let action = form.action.value;
    let start = Number(form.start.value);
    let items = Number(form.items.value);
    let postid = Number(form.postid.value);
    let count = Number(form.count.value);
    console.log('XHR LOAD:',form.name, start, items, postid, count);
    if (start >= count) { 
      loading.remove();
      return false; 
    }
    let promises;
    if (form.name == 'post') {
      promises = [
        makePostList(start, items, action),
        timeout(delay),
      ];
    } else if (form.name == 'thread') {
      promises = [
        makeThreadList(start, items, postid),
        timeout(delay),
      ];
    }
    let result = await Promise.all(promises);
    loading.insertAdjacentHTML('beforebegin', result[0]);
    form.start.value = start + items;
  });
}

// ---------------------------------------------------------------------------------------

// 메인메뉴 토글
function toggleMenu(menu) {
  // let menu = document.querySelector('.menu');
  menu.classList.toggle('open');
}

// ---------------------------------------------------------------------------------------

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

// 포스트리스트 출력
async function makePostList(start, items, action) {
  const postList = await xhr('getPostList', {start: start, items: items, action: action});
  return postList;
}

// 쓰레드리스트 출력
async function makeThreadList(start, items, postid) {
  const threadList = await xhr('getThreadList', {start: start, items: items, postid: postid});
  return threadList;
}

// 쓰레드 데이터
async function getThreadData(threadid) {
  const threadData = await xhr('getThreadData', {threadid: threadid});
  return threadData;
}

// 테마 저장
function initTheme() {
  const USER = getCookie('USER');
  const THEME = getCookie('THEME');
  if (USER) {
    const userData = JSON.parse(decodeURIComponent(USER));
    const userTheme = userData.pref.theme;
    if (!THEME || THEME != userTheme) { 
      setCookie('THEME', userTheme);
    }
  } else if (!THEME) {
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');  
    if (prefersDarkScheme.matches) {
      setCookie('THEME', 'dark');
    } else {
      setCookie('THEME', 'light');
    }
  }
}
