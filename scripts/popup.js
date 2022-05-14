// 쓰레드 수정 팝업
async function setThreadUpdate(threadid, form=threadUpdate) {
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
  
  return form;
}

// 쓰레드 삭제 팝업
async function setThreadDelete(threadid, form=threadDelete) {
  const data = document.getElementById('thread_'+threadid);
  form.threadid.value = threadid;

  const text = form.querySelector('.text');
  text.innerHTML = `
    ${substrMax(data.content.value, 160)}
  `;

  return form;
}

// 답글 쓰기 팝업
async function setReplyWrite(threadid, form=replyWrite) {
  const data = document.getElementById('thread_'+threadid);
  
  form.threadid.value = threadid;
  form.title.value = data.title.value;

  return form;
}

// 답글 삭제 팝업
async function setReplyDelete(replyid, form=replyDelete) {
  const data = document.getElementById('reply_'+replyid);
  const threadid = data.threadid.value;
  form.replyid.value = replyid;

  const text = form.querySelector('.text');
  text.innerHTML = `
    ${substrMax(data.content.value, 160)}
  `;

  return form;
}
