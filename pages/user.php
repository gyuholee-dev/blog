<?php // user.php

if (isset($DO) && $DO == 'mypage') {
  $userid = $_SESSION['USER']['userid'];
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
      <table class="table $DO">
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
        <table class="table $DO">
          <tr>
            <th>아이디</th>
            <td>
              <input type="text" name="userid" onchange="resetCheck()">
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
            <td><input type="text" name="nickname"></td>
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
            <td><input type="text" name="avatar" readonly></td>
          </tr>
          <tr>
            <th>링크</th>
            <td><input type="text" name="link" readonly></td>
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
if (isset($DO) && $DO == 'mypage') {
  $userid = $_SESSION['USER']['userid'];
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
          <table class="table $DO">
            <tr>
              <th>아이디</th>
              <td>
                <input type="text" name="userid" value="$data[userid]">
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
              <td><input type="text" name="nickname" value="$data[nickname]"></td>
            </tr>
            <tr>
              <th>이메일</th>
              <td>
                <input type="text" name="email" value="$data[email]">
              </td>
            </tr>
            <tr>
              <th>프로필 사진</th>
              <td><input type="text" name="avatar" value="$data[avatar]" readonly></td>
            </tr>
            <tr>
              <th>링크</th>
              <td>
                <input type="text" name="link" value="$data[link]" readonly>
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
            <input class="btn" type="button" value="아니오" onclick="location.href='main.php'">
          </div>
        </form>
      </div>
    </section>
  HTML;
}

// ## 회원정보 삭제
$content_delete = "";

// ## 컨펌 처리
if (isset($_POST['confirm'])) {
  switch ($DO) {
    case 'login': 
      $userid = $_POST['userid'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM user 
              WHERE userid='$userid' 
              AND password='$password' ";
      $res = mysqli_query($DB, $sql);
      if (mysqli_num_rows($res) == 1) {
        $userdata = mysqli_fetch_assoc($res);
        setUserData([
          'userid' => $userdata['userid'],
          'nickname' => $userData['nickname'],
          'groups' => $userData['groups']
        ]);
        header('Location: main.php');
      } else {
        echo "
          <script>
            alert('로그인 실패');
            location.href='main.php?action=user&do=login';
          </script>
        ";
      }
      break;

    case 'signup':
      $userid = $_POST['userid'];
      $password = $_POST['password'];
      $password_check = $_POST['password_check'];
      $nickname = $_POST['nickname'];
      $email = $_POST['email'].'@'.$_POST['provider'];
      $avatar = $_POST['avatar'];
      $link = $_POST['link'];
      $sql = "INSERT INTO user 
              (userid, password, nickname, email, avatar, link) 
              VALUES
              ('$userid', '$password', '$nickname', '$email', '$avatar', '$link') ";
      mysqli_query($DB, $sql);
      setUserData([
        'userid' => $userid,
        'nickname' => $nickname,
        'groups' => 'user'
      ]);
      echo "
        <script>
          alert('회원가입 완료');
          location.href='main.php';
        </script>
      ";
      break;

    case 'delete':
      $userid = $_SESSION['USER']['userid'];
      $sql = "DELETE FROM user WHERE userid = '$userid' ";
      $res = mysqli_query($DB, $sql);
      session_destroy();
      echo "
        <script>
          alert('회원탈퇴하였습니다');
          location.href='main.php';
        </script>
      ";
      break;
  }
}
