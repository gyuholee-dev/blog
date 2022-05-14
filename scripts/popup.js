// 쓰레드 수정 팝업
async function setThreadUpdate(threadid, form=threadUpdate) {
  const popup = popup_thread_update;
  const data = document.getElementById('thread_'+threadid);
  form.title.value = data.title.value;
  form.content.value = data.content.value;
  form.threadid.value = data.threadid.value;

  if (form.pinned !== undefined) {
    form.pinned.checked = (data.pinned.value == 1) ? true : false;
  }
  if (form.secret !== undefined) {
    form.secret.checked = (data.secret.value == 1) ? true : false;
  }

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  
  return popup;
}

// 쓰레드 삭제 팝업
async function setThreadDelete(threadid, form=threadDelete) {
  const popup = popup_thread_delete;
  const data = document.getElementById('thread_'+threadid);
  form.threadid.value = threadid;

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  const text = popup.querySelector('.text');
  text.innerHTML = `
    ${substrMax(data.content.value, 160)}
  `;

  return popup;
}

// 답글 쓰기 팝업
async function setReplyWrite(threadid, form=replyWrite) {
  const popup = popup_reply_write;
  const data = document.getElementById('thread_'+threadid);
  form.threadid.value = threadid;

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  const subject = popup.querySelector('.subject');
  subject.value = data.title.value;

  return popup;
}

// 답글 삭제 팝업
async function setReplyDelete(replyid, form=replyDelete) {
  const popup = popup_reply_delete;
  const data = document.getElementById('reply_'+replyid);
  const threadid = data.threadid.value;
  form.replyid.value = replyid;

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  const text = popup.querySelector('.text');
  text.innerHTML = `
    ${substrMax(data.content.value, 160)}
  `;

  return popup;
}
