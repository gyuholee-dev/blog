// 쓰레드 쓰기 팝업
async function setThreadUpdate(threadid, form) {
  const threadData = await getThreadData(threadid);
  form.title.value = threadData.title;
  form.content.value = threadData.content;
  form.threadid.value = threadData.threadid;
  if (form.pinned !== undefined) {
    form.pinned.checked = (threadData.pinned == 1) ? true : false;
  }
  if (form.secret !== undefined) {
    form.secret.checked = (threadData.secret == 1) ? true : false;
  }

  let popupTitle = popup_thread_update.querySelector('.title');
  const titleText = popupTitle.getAttribute('data');
  popupTitle.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
}

// 쓰레드 삭제 팝업
async function setThreadDelete(threadid, form) {
  const threadData = await getThreadData(threadid);
  form.threadid.value = threadid;

  let title = popup_thread_delete.querySelector('.title');
  const titleText = title.getAttribute('data');
  title.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  let message = popup_thread_delete.querySelector('.message');
  const messageText = message.getAttribute('data');
  message.innerHTML = `
    <span class="msg">
      <span class="label">"${threadData.title}"</span> 
      <b class="red">${messageText}</b>
    </span>
  `;
}

// 답글 쓰기 팝업
async function setReplyWrite(threadid, form) {
  const threadData = await getThreadData(threadid);
  form.threadid.value = threadid;
  if (form.secret !== undefined) {
    form.secret.checked = (threadData.secret == 1) ? true : false;
  }

  let popupTitle = popup_reply_write.querySelector('.title');
  const titleText = popupTitle.getAttribute('data');
  popupTitle.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  let popupSubject = popup_reply_write.querySelector('.subject');
  popupSubject.value = threadData.title;
}
