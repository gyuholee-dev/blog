console.log('SCRIPT LOAD OK');

// Promise XMLHttpRequest
async function requestData(url, option = null) {
  try {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url);

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
  }
  catch (error) {
    throw Error(error);
  }
}

async function checkId() {
  if (signup.userid.value=='') {
    alert('아이디를 입력하세요');
    signup.userid.focus();
    return false;
  }

  let check = await requestData(
    'xhr.php?call=checkId&userid='+signup.userid.value
  );

  if (check == 0) {
    alert('아이디 사용 가능');
    signup.password.focus();
    signup.idcheked.value=true;
  } else {
    alert('중복된 아이디입니다');
    signup.userid.value = '';
    signup.userid.focus();
    return false;
  }
}

function resetCheck() {
  signup.idcheked.value=false;
}

function sendSignup() {
  if (signup.userid.value=='') {
    alert('아이디를 입력하세요');
    signup.userid.focus();
    return false;
  }
  if (signup.idcheked.value != 'true') {
    alert('아이디 중복체크를 해주세요');
    signup.userid.focus();
    return false;
  }
  if (signup.password.value=='') {
    alert('비밀번호를 입력하세요');
    signup.password.focus();
    return false;
  }
  if (signup.password_check.value=='') {
    alert('비밀번호를 확인해 주세요');
    signup.password_check.focus();
    return false;
  }
  if (signup.password.value != signup.password_check.value) {
    alert('비밀번호가 다릅니다');
    signup.password.value = '';
    signup.password_check.value = '';
    signup.password.focus();
    return false;
  }
  if (signup.nickname.value=='') {
    alert('이름을 입력하세요');
    signup.nickname.focus();
    return false;
  }
  if (signup.email.value=='') {
    alert('이메일을 입력하세요');
    signup.email.focus();
    return false;
  }
  
  signup.confirm.value = true;
  document.signup.submit();
}

function sendLogin() {
  if (login.userid.value=='') {
    alert('아이디를 입력하세요');
    signup.userid.focus();
    return false;
  }
  if (login.password.value=='') {
    alert('비밀번호를 입력하세요');
    signup.password.focus();
    return false;
  }
  login.confirm.value = true;
  document.login.submit();
}