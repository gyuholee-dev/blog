<?php // user.php

if (isset($do) && $do == 'mypage') {
  $userid = $_SESSION['user']['userid'];
  $sql = "SELECT * FROM user WHERE userid = '$userid' ";
  $res = mysqli_query($DB, $sql);
  $data = mysqli_fetch_assoc($res);
}

// ## 로그인
$content_login = <<<HTML
<section class="user">
  <div class="header">
    <div class="title">로그인</div>
  </div>
  <div class="content">
    <form name="login" method="post" action="main.php?action=user&do=login">
      <table class="table $do">
        <tr>
          <th>아이디</th>
          <td><input type="text" name="userid" value=""></td>
        </tr>
        <tr>
          <th>비밀번호</th>
          <td><input type="password" name="password" value=""></td>
        </tr>
      </table>
      <div class="buttons">
        <input type="hidden" name="confirm" value="true">
        <input class="btn" type="button" value="로그인" onclick="sendLogin()">
      </div>
    </form>
  </div>
</section>
HTML;

// ## 로그아웃
$content_logout = <<<HTML

HTML;

// ## 회원가입
$content_signup = <<<HTML
  <section class="user">
    <div class="header">
      <div class="title">회원가입</div>
    </div>
    <div class="content">
      <form name="signup" method="post" action="main.php?action=user&do=signup">
        <table class="table $do">
          <tr>
            <th>아이디</th>
            <td>
              <input type="text" name="userid">
              <input type="button" value="중복확인" onclick="checkId()">
            </td>
          </tr>
          <tr>
            <th>비밀번호</th>
            <td><input type="password" name="password"></td>
          </tr>
          <tr>
            <th>비밀번호 확인</th>
            <td><input type="password" name="password_check"></td>
          </tr>
          <tr>
            <td colspan="2" class="hr"></td>
          </tr>
          <tr>
            <th>이름</th>
            <td><input type="text" name="username"></td>
          </tr>
          <tr>
            <th>이메일</th>
            <td>
              <input type="text" name="email">
              <select name="provider">
                <option>직접입력</option>
                <option value="gmail.com">gmail.com</option>
                <option value="naver.com">naver.com</option>
                <option value="hanmail.net">hanmail.net</option>
                <option value="nate.com">nate.com</option>
              </select>
            </td>
          </tr>
          <tr>
            <th>프로필 사진</th>
            <td><input type="text" name="avatar"></td>
          </tr>
          <tr>
            <th>링크</th>
            <td><input type="text" name="link"></td>
          </tr>
        </table>

        <div class="buttons">
          <input type="hidden" name="idcheked" value="false">
          <input type="hidden" name="confirm" value="true">
          <input class="btn" type="button" value="회원가입" onclick="sendSignup()">
          <input class="btn" type="reset" value="재입력">
        </div>

      </form>
    </div>
  </section>
HTML;

// ## 마이페이지
if (isset($do) && $do == 'mypage') {
  $userid = $_SESSION['user']['userid'];
  $sql = "SELECT * FROM user WHERE userid = '$userid' ";
  $res = mysqli_query($DB, $sql);
  $data = mysqli_fetch_assoc($res);

  $content_mypage = <<<HTML
    <section class="user">
      <div class="header">
        <div class="title">회원정보 수정</div>
      </div>
      <div class="content">
        <form name="signup" method="post" action="main.php?action=user&do=edit">
          <table class="table $do">
            <tr>
              <th>아이디</th>
              <td>
                <input type="text" name="userid" value="$data[userid]">
              </td>
            </tr>
            <tr>
              <th>비밀번호</th>
              <td><input type="text" name="password"></td>
            </tr>
            <tr>
              <th>비밀번호 확인</th>
              <td><input type="text" name="password_check"></td>
            </tr>
            <tr>
              <td colspan="2" class="hr"></td>
            </tr>
            <tr>
              <th>이름</th>
              <td><input type="text" name="username" value="$data[username]"></td>
            </tr>
            <tr>
              <th>이메일</th>
              <td>
                <input type="text" name="email" value="$data[email]">
              </td>
            </tr>
            <tr>
              <th>프로필 사진</th>
              <td><input type="text" name="avatar" value="$data[avatar]"></td>
            </tr>
            <tr>
              <th>링크</th>
              <td>
                <input type="text" name="link" value="$data[link]">
              </td>
            </tr>
          </table>

          <div class="buttons">
            <input type="hidden" name="idcheked" value="false">
            <input type="hidden" name="confirm" value="true">
            <input class="btn" type="button" value="정보수정" onclick="sendSignup()">
            <input class="btn" type="reset" value="재입력">
          </div>

        </form>
      </div>
    </section>

    <section class="user">
      <div class="header">
        <div class="title">회원탈퇴</div>
      </div>
      <div class="content">
        <form name="delete" method="post" action="main.php?action=user&do=delete">
          <b>탈퇴하겠습니까?</b>
          <br>
          <div class="buttons">
            <input class="btn" name="confirm" type="submit" value="예">
            <input class="btn" type="button" value="아니오" onclick="location.href='$MAIN'">
          </div>
        </form>
      </div>
    </section>
  HTML;
}

// ## 회원정보 삭제
$content_delete = <<<HTML

HTML;

// ## 컨펌 처리
if (isset($_POST['confirm'])) {
  switch ($do) {
    case 'login': 
      $userid = $_POST['userid'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM user 
              WHERE userid='$userid' 
              AND password='$password' ";
      $res = mysqli_query($DB, $sql);
      if (mysqli_num_rows($res) == 1) {
        $_SESSION['user'] = array(
          'userid' => $userid,
          'password' => $password
        );
        /* echo "
          <script>
            alert('로그인 성공');
            location.href='$MAIN?action=user&do=mypage';
          </script>
        "; */
        // echo "<meta http-equiv='refresh' content='0; url=$MAIN'>";
        header('Location: '.$MAIN);
      } else {
        echo "
          <script>
            alert('로그인 실패');
            location.href='$MAIN?action=user&do=login';
          </script>
        ";
      }
      break;

    case 'signup':
      echo "회원가입 처리";
      break;

    case 'delete':
      $userid = $_SESSION['user']['userid'];
      $sql = "DELETE FROM user WHERE userid = '$userid' ";
      $res = mysqli_query($DB, $sql);
      session_destroy();
      echo "
        <script>
          alert('회원탈퇴하였습니다');
          location.href='$MAIN';
        </script>
      ";
      break;
  }
}


// $do 값에 따라 각각 다른 컨텐츠를 출력
$formTitle = '';
switch ($do) {
  case 'login':
    // $formTitle = '로그인';
    $content .= $content_login;
    break;
  case 'logout':
    // $formTitle = '로그아웃';
    $content .= $content_logout;
    // unset($_SESSION['user']);
    session_destroy();
    header('Location: '.$MAIN);
    break;
  case 'signup':
    // $formTitle = '회원가입';
    $content .= $content_signup;
    break;
  case 'mypage':
    // $formTitle = '마이페이지';
    $content .= $content_mypage;
    break;
  case 'delete':
    // $formTitle = '회원탈퇴';
    $content .= $content_delete;
    break;
}