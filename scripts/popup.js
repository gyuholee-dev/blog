// 쓰레드 수정 팝업
async function setThreadUpdate(threadid, form=threadUpdate) {
  const popup = popup_thread_update;
  const threadData = await getThreadData(threadid);
  form.title.value = threadData.title;
  form.content.value = threadData.content;
  form.threadid.value = threadData.threadid;

  if (form.pinned !== undefined) {
    form.pinned.checked = (threadData.pinned.value == 1) ? true : false;
  }
  if (form.secret !== undefined) {
    form.secret.checked = (threadData.secret.value == 1) ? true : false;
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
  const threadData = await getThreadData(threadid);
  form.threadid.value = threadid;

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  const message = popup.querySelector('.message');
  const messageText = message.getAttribute('data');
  message.innerHTML = `
    <span class="msg">
      <b class="red">"${threadData.title}" ${messageText}</b>
    </span>
  `;

  return popup;
}

// 답글 쓰기 팝업
async function setReplyWrite(threadid, form=replyWrite) {
  const popup = popup_reply_write;
  const threadData = await getThreadData(threadid);
  form.threadid.value = threadid;

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  const subject = popup.querySelector('.subject');
  subject.value = threadData.title;

  return popup;
}

// 답글 삭제 팝업
async function setReplyDelete(replyid, form=replyDelete) {
  const popup = popup_reply_delete;
  // const replyData = await getReplyData(replyid);
  // const threadData = await getThreadData(replyData.threadid);
  form.replyid.value = replyid;

  const title = popup.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${replyid}</span>${titleText}
  `;

  return popup;
}
