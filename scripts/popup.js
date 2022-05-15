// 팝업 오픈
async function openPopup(element) {
  const elem = await element;
  if (elem.classList.contains('active')) {
    return false;
  }
  elem.classList.add('show');
  await timeout(50);
  elem.classList.add('active');
}

// 팝업 클로즈
async function closePopup(element, listener=null) {
  let delay = 350;
  element.classList.remove('active');
  await timeout(delay);
  element.classList.remove('show');
  if (listener) {
    element.removeEventListener('input', listener);
  }
}

// 쓰레드 쓰기 팝업 
async function setThreadWrite(form=threadWrite) {
  inputHandler = ()=>{
    if (form.title.value != '' || form.content.value != '') {
      form.confirm.disabled = false;
    } else {
      form.confirm.disabled = true;
    }
  }
  form.addEventListener('input', inputHandler);

  return form;
}

// 쓰레드 수정 팝업
async function setThreadUpdate(threadid, form=threadUpdate) {
  const data = document.getElementById('thread_'+threadid);
  const threadnumb = data.threadnumb.value;
  form.title.value = data.title.value;
  form.content.value = data.content.value;
  form.threadid.value = data.threadid.value;
  form.threadnumb.value = threadnumb;

  if (form.pinned !== undefined) {
    form.pinned.checked = (data.pinned.value == 1)?true:false;
  }
  if (form.secret !== undefined) {
    form.secret.checked = (data.secret.value == 1)?true:false;
  }

  const title = form.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label"><i class='sharp'></i>${threadnumb}</span>${titleText}
  `;

  inputHandler = ()=>{
    if (form.pinned !== undefined) {
      form.pinchanged.value = (form.pinned.checked != (data.pinned.value==1?true:false))?1:0;
    }
    if (form.secret !== undefined) {
      form.secchanged.value = (form.secret.checked != (data.secret.value==1?true:false))?1:0;
    }
    if (
      form.pinned !== undefined && form.pinchanged.value == 1 || 
      form.secret !== undefined && form.secchanged.value == 1 || 
      form.pullup.checked != 0 ||
      form.title.value != data.title.value || 
      form.content.value != data.content.value
    ) {
      form.confirm.disabled = false;
    } else {
      form.confirm.disabled = true;
    }
  }
  form.addEventListener('input', inputHandler);
  
  return form;
}

// 쓰레드 삭제 팝업
async function setThreadDelete(threadid, form=threadDelete) {
  const data = document.getElementById('thread_'+threadid);
  const threadnumb = data.threadnumb.value;
  form.threadid.value = threadid;
  form.threadnumb.value = threadnumb;

  if (form.pinned !== undefined) {
    form.pinned.value = data.pinned.value;
  }

  const title = form.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label"><i class='sharp'></i>${threadnumb}</span>${titleText}
  `;
  const text = form.querySelector('.text');
  text.innerHTML = `
    ${substrMax(data.content.value, 160)}
  `;

  return form;
}

// 답글 쓰기 팝업
async function setReplyWrite(threadid, form=replyWrite) {
  const data = document.getElementById('thread_'+threadid);
  const threadnumb = data.threadnumb.value;
  form.threadid.value = threadid;
  form.threadnumb.value = threadnumb;
  if (data.secret.value == 1) {
    form.title.value = '비밀글';
  } else {
    form.title.value = data.title.value;
  }

  const title = form.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label"><i class='sharp'></i>${threadnumb}</span>${titleText}
  `;

  inputHandler = ()=>{
    if (form.content.value != '') {
      form.confirm.disabled = false;
    } else {
      form.confirm.disabled = true;
    }
  }
  form.addEventListener('input', inputHandler);

  return form;
}

// 답글 삭제 팝업
async function setReplyDelete(replyid, form=replyDelete) {
  const data = document.getElementById('reply_'+replyid);
  const threadid = data.threadid.value;
  const threadnumb = document.getElementById('thread_'+threadid).threadnumb.value;
  form.replyid.value = replyid;
  form.threadid.value = threadid;
  form.threadnumb.value = threadnumb;

  const title = form.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label"><i class='sharp'></i>${threadnumb}</span>${titleText}
  `;
  const text = form.querySelector('.text');
  text.innerHTML = `
    ${substrMax(data.content.value, 160)}
  `;

  return form;
}
