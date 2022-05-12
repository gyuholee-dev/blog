// 팝업 핸들링
async function setPopup(postId, form) {
  switch(form.name) {
    case 'threadUpdate':
      await setThreadUpdate(postId, form, popup_thread_update);
      return popup_thread_update;
    
    case 'threadDelete':
      await setThreadDelete(postId, form, popup_thread_delete);
      return popup_thread_delete;

    case 'replyWrite':
      await setReplyWrite(postId, form, popup_reply_write);
      return popup_reply_write;

    case 'replyDelete':
      await setReplyDelete(postId, form, popup_reply_delete);
      return popup_reply_delete;
  }
}


// 쓰레드 수정 팝업
async function setThreadUpdate(threadid, form, popup) {
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

  let popupTitle = popup.querySelector('.title');
  const titleText = popupTitle.getAttribute('data');
  popupTitle.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
}

// 쓰레드 삭제 팝업
async function setThreadDelete(threadid, form=threadDelete) {
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
      <b class="red">"${threadData.title}" ${messageText}</b>
    </span>
  `;
}

// 답글 쓰기 팝업
async function setReplyWrite(threadid, form=replyWrite) {
  const threadData = await getThreadData(threadid);
  form.threadid.value = threadid;

  let popupTitle = popup_reply_write.querySelector('.title');
  const titleText = popupTitle.getAttribute('data');
  popupTitle.innerHTML = `
    <span class="label">#${threadid}</span>${titleText}
  `;
  let popupSubject = popup_reply_write.querySelector('.subject');
  popupSubject.value = threadData.title;
}

// 답글 삭제 팝업
async function setReplyDelete(replyid, form=threadDelete) {

}
